<x-layouts.app title="Produk & Stok">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Manajemen Produk & Stok</h2>
                <p class="text-sm text-slate-500">Kelola daftar produk, harga, dan pantau stok barang</p>
            </div>
            <div class="flex items-center gap-3">
                @can('stock.view')
                <a href="{{ route('stock-movements.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
                    Riwayat Stok
                </a>
                @endcan

                @can('product.create')
                <a href="{{ route('products.create') }}" class="btn-primary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tambah Produk
                </a>
                @endcan
            </div>
        </div>

        {{-- Filters & Search --}}
        <div class="card !p-4 flex flex-col md:flex-row gap-4 items-end">
            <form method="GET" class="flex-1 flex gap-3 w-full">
                <input name="search" value="{{ request('search') }}" type="text" class="form-input flex-1 max-w-sm" placeholder="Cari SKU atau nama produk...">
                <button type="submit" class="btn-secondary">Cari</button>
                @if(request('search'))
                    <a href="{{ route('products.index') }}" class="btn-ghost">Reset</a>
                @endif
            </form>
        </div>

        {{-- Product List --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @forelse($products as $product)
                <div class="card flex flex-col h-full hover:border-primary-200 hover:shadow-md transition-all">
                    {{-- Status Badge & SKU --}}
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-mono text-slate-400 bg-surface-100 px-2 py-1 rounded-md">{{ $product->sku }}</span>
                        @if(!$product->is_active)
                            <span class="badge bg-slate-100 text-slate-500">Nonaktif</span>
                        @elseif($product->isLowStock())
                            <span class="badge bg-red-50 text-red-600 animate-pulse">Stok Kritis</span>
                        @else
                            <span class="badge bg-green-50 text-green-600">Aktif</span>
                        @endif
                    </div>

                    {{-- Product Info --}}
                    <div class="flex gap-4 mb-4">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-xl object-cover ring-1 ring-surface-200 shrink-0">
                        @else
                            <div class="w-16 h-16 rounded-xl bg-surface-100 border border-surface-200 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h3 class="font-semibold text-slate-800 text-base leading-tight truncate mb-1" title="{{ $product->name }}">{{ $product->name }}</h3>
                            <p class="text-xs text-slate-500 mb-2">{{ $product->category->name }}</p>
                        </div>
                    </div>

                    {{-- Prices & Stock grid --}}
                    <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                        <div class="bg-surface-50 p-2.5 rounded-xl border border-surface-100">
                            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mb-0.5">Harga Jual</p>
                            <p class="text-sm font-bold text-slate-800">{{ $product->formatted_sell_price }}</p>
                        </div>
                        <div class="bg-surface-50 p-2.5 rounded-xl border border-surface-100">
                            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mb-0.5">Sisa Stok</p>
                            <p class="text-sm font-bold {{ $product->isLowStock() ? 'text-red-600' : 'text-slate-800' }}">
                                {{ $product->quantity }} <span class="text-xs font-normal text-slate-500">Unit</span>
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-4 border-t border-surface-100">
                        <div class="text-xs text-slate-400">Modal: {{ $product->formatted_cost_price }}</div>
                        
                        <div class="flex items-center gap-2">
                            @can('stock.adjust')
                            <a href="{{ route('stock-movements.create', ['product_id' => $product->id]) }}" class="p-2 rounded-lg text-slate-500 hover:text-accent-600 hover:bg-accent-50 transition-colors" title="Penyesuaian Stok">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            </a>
                            @endcan

                            @can('product.edit')
                            <a href="{{ route('products.edit', $product) }}" class="p-2 rounded-lg text-slate-500 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit Produk">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            </a>
                            @endcan

                            @can('product.delete')
                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Hapus produk {{ $product->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer" title="Hapus Produk">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-surface-200">
                    <div class="w-16 h-16 bg-surface-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-800 mb-1">Tidak ada produk ditemukan</h3>
                    <p class="text-sm text-slate-500 mb-4">Coba cari dengan kata kunci lain atau tambah produk baru.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div>{{ $products->withQueryString()->links() }}</div>
    </div>
</x-layouts.app>
