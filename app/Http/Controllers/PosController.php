<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        
        $products = Product::with('category')
            ->active()
            ->when($request->user()->branch_id, fn($q, $bId) => $q->inBranch($bId))
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                return [
                    'id'          => $product->id,
                    'category_id' => $product->category_id,
                    'name'        => $product->name,
                    'sku'         => $product->sku,
                    'sell_price'  => $product->sell_price_rupiah, // We send full rupiah for Alpine to display/calculate
                    'stock'       => $product->quantity,
                    'image_url'   => $product->image ? asset('storage/' . $product->image) : null,
                ];
            })->values()->toArray();

        return view('pos.index', compact('categories', 'products'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items'                 => ['required', 'array', 'min:1'],
            'items.*.product_id'    => ['required', 'exists:products,id'],
            'items.*.quantity'      => ['required', 'integer', 'min:1'],
            'payment_method'        => ['required', 'string', 'in:cash,transfer,qris,ewallet'],
            'amount_paid'           => ['required', 'numeric', 'min:0'],
            'notes'                 => ['nullable', 'string', 'max:255'],
        ]);

        $branchId = $request->user()->branch_id;

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $orderItemsData = [];

            // 1. Validasi stok dan hitung total
            foreach ($validated['items'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->branch_id && $branchId && $product->branch_id !== $branchId) {
                    throw new \Exception("Produk {$product->name} bukan dari cabang ini.");
                }

                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk produk: {$product->name}. Tersisa: {$product->quantity}");
                }

                $itemSubtotal = $product->sell_price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $orderItemsData[] = [
                    'product'      => $product,
                    'quantity'     => $item['quantity'],
                    'cost_price'   => $product->cost_price,
                    'sell_price'   => $product->sell_price,
                    'subtotal'     => $itemSubtotal,
                ];
            }

            // 2. Buat Order (konversi kembali amount_paid ke format database /1000)
            $amountPaidDb = $validated['amount_paid'] / 1000;
            $changeAmountDb = $amountPaidDb - $subtotal;

            if ($changeAmountDb < 0) {
                throw new \Exception("Jumlah bayar kurang dari total belanja.");
            }

            $order = Order::create([
                'user_id'        => $request->user()->id,
                'branch_id'      => $branchId,
                'invoice_number' => Order::generateInvoiceNumber($branchId),
                'subtotal'       => $subtotal,
                'discount'       => 0, // Default no discount for now
                'tax'            => 0, // Default no tax for now
                'total'          => $subtotal,
                'amount_paid'    => $amountPaidDb,
                'change_amount'  => $changeAmountDb,
                'payment_method' => $validated['payment_method'],
                'status'         => 'completed',
                'notes'          => $validated['notes'],
            ]);

            // 3. Buat Order Items & Stock Movements
            foreach ($orderItemsData as $data) {
                $product = $data['product'];

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'product_sku'  => $product->sku,
                    'cost_price'   => $data['cost_price'],
                    'sell_price'   => $data['sell_price'],
                    'quantity'     => $data['quantity'],
                    'subtotal'     => $data['subtotal'],
                ]);

                // Kurangi stok & catat movement
                StockMovement::record(
                    $product,
                    $request->user()->id,
                    'out',
                    $data['quantity'],
                    $order->invoice_number,
                    "Penjualan POS - Inv: " . $order->invoice_number
                );
            }

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Transaksi berhasil',
                'order_id'     => $order->id,
                'redirect_url' => route('pos.receipt', $order->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function receipt(Request $request, Order $order)
    {
        if ($request->user()->branch_id && $order->branch_id !== $request->user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['items', 'user', 'branch']);
        return view('pos.receipt', compact('order'));
    }
}
