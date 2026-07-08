<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'branch'])
            ->when($request->search, fn($q, $s) => $q->search($s))
            ->when($request->user()->branch_id, fn($q, $bId) => $q->inBranch($bId))
            ->latest()
            ->paginate(15);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'sku'         => ['nullable', 'string', 'max:255', 'unique:products'],
            'description' => ['nullable', 'string'],
            'cost_price'  => ['required', 'numeric', 'min:0'],
            'sell_price'  => ['required', 'numeric', 'min:0'],
            'quantity'    => ['required', 'integer', 'min:0'],
            'min_stock'   => ['required', 'integer', 'min:0'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'   => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Konversi ke format DB (1 = 1000)
        $validated['cost_price'] = $validated['cost_price'] / 1000;
        $validated['sell_price'] = $validated['sell_price'] / 1000;

        $validated['branch_id'] = $request->user()->branch_id; // Assigned to user's branch
        
        if (empty($validated['sku'])) {
            $validated['sku'] = Product::generateSku(strtoupper(substr(Category::find($validated['category_id'])->name, 0, 3)));
        }

        $validated['is_active'] = $request->has('is_active');

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Request $request, Product $product)
    {
        // Pastikan hanya bisa edit produk di cabangnya sendiri
        if ($request->user()->branch_id && $product->branch_id !== $request->user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($request->user()->branch_id && $product->branch_id !== $request->user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'sku'         => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'description' => ['nullable', 'string'],
            'cost_price'  => ['required', 'numeric', 'min:0'],
            'sell_price'  => ['required', 'numeric', 'min:0'],
            'min_stock'   => ['required', 'integer', 'min:0'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'   => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Konversi ke format DB (1 = 1000)
        $validated['cost_price'] = $validated['cost_price'] / 1000;
        $validated['sell_price'] = $validated['sell_price'] / 1000;

        $validated['is_active'] = $request->has('is_active');

        // Note: quantity is updated via stock movements, not direct edit.
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product)
    {
        if ($request->user()->branch_id && $product->branch_id !== $request->user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($product->orderItems()->exists()) {
            return back()->with('error', 'Produk tidak bisa dihapus karena sudah memiliki riwayat penjualan.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
