<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $movements = StockMovement::with(['product', 'user'])
            ->when($request->search, function ($q, $s) {
                $q->whereHas('product', fn($q2) => $q2->where('name', 'like', "%{$s}%")->orWhere('sku', 'like', "%{$s}%"));
            })
            ->when(auth()->user()->branch_id, fn($q, $bId) => $q->inBranch($bId))
            ->latest()
            ->paginate(20);

        return view('stock-movements.index', compact('movements'));
    }

    public function create(Request $request)
    {
        $products = Product::active()
            ->when(auth()->user()->branch_id, fn($q, $bId) => $q->inBranch($bId))
            ->orderBy('name')
            ->get();

        $selectedProductId = $request->query('product_id');

        return view('stock-movements.create', compact('products', 'selectedProductId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type'       => ['required', 'in:in,out,adjustment'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'notes'      => ['nullable', 'string', 'max:255'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (auth()->user()->branch_id && $product->branch_id !== auth()->user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        // Jika barang keluar, pastikan stok mencukupi
        if (in_array($validated['type'], ['out', 'adjustment']) && $request->input('action') === 'reduce') {
            if ($product->quantity < $validated['quantity']) {
                return back()->withInput()->withErrors([
                    'quantity' => 'Stok saat ini (' . $product->quantity . ') tidak mencukupi untuk pengurangan sebanyak ' . $validated['quantity']
                ]);
            }
            $validated['type'] = 'out'; // Force adjustment to out if reducing
        } elseif ($validated['type'] === 'adjustment' && $request->input('action') === 'add') {
            $validated['type'] = 'in'; // Force adjustment to in if adding
        }

        DB::transaction(function () use ($validated, $product, $request) {
            StockMovement::record(
                $product,
                $request->user()->id,
                $validated['type'],
                $validated['quantity'],
                null,
                $validated['notes']
            );
        });

        return redirect()->route('products.index')->with('success', 'Stok berhasil disesuaikan.');
    }
}
