<x-layouts.app title="Penyesuaian Stok">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali
            </a>
        </div>

        <div class="card animate-slide-up">
            <h3 class="text-lg font-semibold text-slate-800 mb-6">Buat Penyesuaian Stok</h3>

            <form method="POST" action="{{ route('stock-movements.store') }}" class="space-y-5" x-data="{ type: 'adjustment', action: 'add' }">
                @csrf

                <div>
                    <label for="product_id" class="form-label">Pilih Produk</label>
                    <select id="product_id" name="product_id" required class="form-input @error('product_id') !border-red-400 @enderror">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                data-stock="{{ $product->quantity }}"
                                {{ old('product_id', $selectedProductId) == $product->id ? 'selected' : '' }}>
                                {{ $product->sku }} — {{ $product->name }} (Stok: {{ $product->quantity }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Jenis Penyesuaian</label>
                        <select name="type" x-model="type" class="form-input">
                            <option value="in">Barang Masuk (Restock)</option>
                            <option value="out">Barang Keluar (Rusak/Hilang)</option>
                            <option value="adjustment">Koreksi Stok (Opname)</option>
                        </select>
                    </div>
                    
                    <div x-show="type === 'adjustment'">
                        <label class="form-label">Aksi Koreksi</label>
                        <select name="action" x-model="action" class="form-input">
                            <option value="add">Tambah Stok (+)</option>
                            <option value="reduce">Kurangi Stok (-)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="quantity" class="form-label">Jumlah Unit</label>
                    <input id="quantity" name="quantity" type="number" min="1" value="{{ old('quantity', 1) }}" required class="form-input @error('quantity') !border-red-400 @enderror">
                    @error('quantity') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea id="notes" name="notes" rows="3" class="form-input" placeholder="Contoh: Barang retur dari supplier / Stok fisik lebih 2 unit">{{ old('notes') }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('products.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Simpan Penyesuaian
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
