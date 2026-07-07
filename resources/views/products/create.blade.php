<x-layouts.app title="Tambah Produk">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="card animate-slide-up">
                <h3 class="text-lg font-semibold text-slate-800 mb-6">Informasi Dasar</h3>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="form-label">Nama Produk</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="form-input @error('name') !border-red-400 @enderror">
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="category_id" class="form-label">Kategori</label>
                            <select id="category_id" name="category_id" required class="form-input @error('category_id') !border-red-400 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="sku" class="form-label">SKU <span class="text-slate-400 font-normal">(Kosongkan untuk generate otomatis)</span></label>
                            <input id="sku" name="sku" type="text" value="{{ old('sku') }}" class="form-input font-mono text-sm uppercase">
                            @error('sku') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Status Produk</label>
                            <div class="mt-2.5">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-surface-300 text-primary-500 focus:ring-primary-500 cursor-pointer">
                                    <span class="text-sm font-medium text-slate-700">Aktif (Ditampilkan di Kasir)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="form-label">Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <textarea id="description" name="description" rows="3" class="form-input">{{ old('description') }}</textarea>
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
                                <input id="cost_price" name="cost_price" type="number" min="0" step="100" value="{{ old('cost_price') }}" required class="form-input pl-10">
                            </div>
                            @error('cost_price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="sell_price" class="form-label">Harga Jual (Rp)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm font-medium pointer-events-none">Rp</span>
                                <input id="sell_price" name="sell_price" type="number" min="0" step="100" value="{{ old('sell_price') }}" required class="form-input pl-10">
                            </div>
                            @error('sell_price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="quantity" class="form-label">Stok Awal</label>
                            <input id="quantity" name="quantity" type="number" min="0" value="{{ old('quantity', 0) }}" required class="form-input">
                            @error('quantity') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="min_stock" class="form-label">Batas Stok Minimum <span class="text-slate-400 font-normal">(Alert)</span></label>
                            <input id="min_stock" name="min_stock" type="number" min="0" value="{{ old('min_stock', 5) }}" required class="form-input">
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
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            </template>
                        </div>
                        <div class="pt-2">
                            <label class="btn-secondary cursor-pointer inline-flex">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                Pilih Gambar
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
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
