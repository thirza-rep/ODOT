<x-layouts.app title="Pergerakan Stok">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Riwayat Pergerakan Stok</h2>
                <p class="text-sm text-slate-500">Log penambahan dan pengurangan stok barang</p>
            </div>
            @can('stock.adjust')
            <a href="{{ route('stock-movements.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Sesuaikan Stok
            </a>
            @endcan
        </div>

        {{-- Search --}}
        <div class="card !p-4">
            <form method="GET" class="flex gap-3">
                <input name="search" value="{{ request('search') }}" type="text" class="form-input max-w-sm" placeholder="Cari nama produk atau SKU...">
                <button type="submit" class="btn-secondary">Cari</button>
                @if(request('search'))
                    <a href="{{ route('stock-movements.index') }}" class="btn-ghost">Reset</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="table-container">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="table-header">Tanggal</th>
                        <th class="table-header">Produk</th>
                        <th class="table-header">Jenis</th>
                        <th class="table-header text-right">Jumlah</th>
                        <th class="table-header">Catatan</th>
                        <th class="table-header">Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $movement)
                        <tr class="table-row">
                            <td class="table-cell whitespace-nowrap">
                                <p class="text-slate-800 font-medium">{{ $movement->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-slate-500">{{ $movement->created_at->format('H:i') }}</p>
                            </td>
                            <td class="table-cell">
                                <p class="font-medium text-slate-800">{{ $movement->product->name }}</p>
                                <p class="text-xs text-slate-400 font-mono">{{ $movement->product->sku }}</p>
                            </td>
                            <td class="table-cell">
                                @if($movement->type === 'in')
                                    <span class="badge bg-green-50 text-green-700">Masuk</span>
                                @elseif($movement->type === 'out')
                                    <span class="badge bg-red-50 text-red-700">Keluar</span>
                                @elseif($movement->type === 'sale')
                                    <span class="badge bg-primary-50 text-primary-700">Penjualan</span>
                                @endif
                            </td>
                            <td class="table-cell text-right font-medium {{ $movement->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                            </td>
                            <td class="table-cell text-slate-500 text-sm max-w-[200px] truncate" title="{{ $movement->notes }}">
                                {{ $movement->notes ?? '-' }}
                            </td>
                            <td class="table-cell">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $movement->user->avatar_url }}" class="w-6 h-6 rounded-md object-cover">
                                    <span class="text-sm text-slate-700">{{ $movement->user->name }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-cell text-center py-12 text-slate-400">Belum ada riwayat pergerakan stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div>{{ $movements->withQueryString()->links() }}</div>
    </div>
</x-layouts.app>
