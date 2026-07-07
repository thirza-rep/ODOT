<x-layouts.app title="Edit Produk">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card animate-slide-up">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-800">Edit Produk: {{ $product->name }}</h3>
                    <span class="badge bg-slate-100 font-mono">{{ $product->sku }}</span>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="form-label">Nama Produk</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required class="form-input @error('name') !border-red-400 @enderror">
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="category_id" class="form-label">Kategori</label>
                            <select id="category_id" name="category_id" required class="form-input @error('category_id') !border-red-400 @enderror">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="sku" class="form-label">SKU</label>
                            <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku) }}" required class="form-input font-mono text-sm uppercase">
                            @error('sku') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Status Produk</label>
                            <div class="mt-2.5">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-surface-300 text-primary-500 focus:ring-primary-500 cursor-pointer">
                                    <span class="text-sm font-medium text-slate-700">Aktif (Ditampilkan di Kasir)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="form-label">Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <textarea id="description" name="description" rows="3" class="form-input">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card animate-slide-up" style="animation-delay: 100ms">
                <h3 class="text-lg font-semibold text-slate-800 mb-6">Harga & Stok</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-5">
                        <div>
                            <label for="cost_price" class="form-label">Harga Modal (Rp)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm font-medium pointer-events-none">Rp</span>
                                <input id="cost_price" name="cost_price" type="number" min="0" step="100" value="{{ old('cost_price', $product->cost_price_rupiah) }}" required class="form-input pl-10">
                            </div>
                            @error('cost_price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="sell_price" class="form-label">Harga Jual (Rp)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm font-medium pointer-events-none">Rp</span>
                                <input id="sell_price" name="sell_price" type="number" min="0" step="100" value="{{ old('sell_price', $product->sell_price_rupiah) }}" required class="form-input pl-10">
                            </div>
                            @error('sell_price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="form-label">Sisa Stok (Tidak bisa diedit langsung)</label>
                            <div class="flex items-center gap-3 mt-1.5">
                                <span class="text-2xl font-bold text-slate-800">{{ $product->quantity }}</span>
                                <a href="{{ route('stock-movements.create', ['product_id' => $product->id]) }}" class="text-sm font-medium text-accent-600 hover:text-accent-700 underline">Sesuaikan Stok</a>
                            </div>
                            <p class="text-xs text-slate-400 mt-2">Untuk mengubah stok, gunakan fitur Penyesuaian Stok demi menjaga riwayat pergerakan barang.</p>
                        </div>
                        <div>
                            <label for="min_stock" class="form-label">Batas Stok Minimum <span class="text-slate-400 font-normal">(Alert)</span></label>
                            <input id="min_stock" name="min_stock" type="number" min="0" value="{{ old('min_stock', $product->min_stock) }}" required class="form-input">
                            @error('min_stock') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card animate-slide-up" style="animation-delay: 200ms">
                <h3 class="text-lg font-semibold text-slate-800 mb-6">Foto Produk</h3>
                
                <div x-data="{ preview: null }">
                    <div class="flex items-start gap-5">
                        <div class="w-32 h-32 rounded-2xl border-2 border-dashed border-surface-300 flex items-center justify-center overflow-hidden bg-surface-50 shrink-0">
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!preview">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                @endif
                            </template>
                        </div>
                        <div class="pt-2">
                            <label class="btn-secondary cursor-pointer inline-flex">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                Ubah Gambar
                                <input type="file" name="image" class="hidden" accept="image/jpeg,image/png,image/webp" 
                                       @change="if($event.target.files[0]) preview = URL.createObjectURL($event.target.files[0])">
                            </label>
                            <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG, WebP. Maksimal 2MB.</p>
                            @error('image') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pb-8">
                <a href="{{ route('products.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
