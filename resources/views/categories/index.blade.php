<x-layouts.app title="Kategori Produk">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Kategori Produk</h2>
                <p class="text-sm text-slate-500">Kelola kategori untuk pengelompokan produk Anda</p>
            </div>
            @can('category.create')
            <a href="{{ route('categories.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Tambah Kategori
            </a>
            @endcan
        </div>

        {{-- Search --}}
        <div class="card !p-4">
            <form method="GET" class="flex gap-3">
                <input name="search" value="{{ request('search') }}" type="text" class="form-input max-w-xs" placeholder="Cari nama kategori...">
                <button type="submit" class="btn-secondary">Cari</button>
                @if(request('search'))
                    <a href="{{ route('categories.index') }}" class="btn-ghost">Reset</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="table-container">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="table-header">Nama Kategori</th>
                        <th class="table-header">Deskripsi</th>
                        <th class="table-header text-center">Jumlah Produk</th>
                        <th class="table-header text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="table-row">
                            <td class="table-cell">
                                <p class="font-medium text-slate-800">{{ $category->name }}</p>
                            </td>
                            <td class="table-cell text-slate-500">{{ Str::limit($category->description, 50) ?? '-' }}</td>
                            <td class="table-cell text-center">
                                <span class="badge bg-primary-50 text-primary-700">{{ $category->products_count }} Produk</span>
                            </td>
                            <td class="table-cell text-right">
                                <div class="flex items-center justify-end gap-1">
                                    @can('category.edit')
                                    <a href="{{ route('categories.edit', $category) }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                    </a>
                                    @endcan

                                    @can('category.delete')
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table-cell text-center py-12 text-slate-400">Tidak ada kategori ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div>{{ $categories->withQueryString()->links() }}</div>
    </div>
</x-layouts.app>
