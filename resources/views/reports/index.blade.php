<x-layouts.app title="Laporan & Statistik">
    <div class="space-y-6">
        {{-- Header & Filter --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Laporan Penjualan</h2>
                <p class="text-sm text-slate-500">Ringkasan performa bisnis Anda</p>
            </div>
            
            <form method="GET" class="flex items-center gap-3">
                <select name="period" class="form-input" onchange="this.form.submit()">
                    <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="this_week" {{ $period === 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="this_month" {{ $period === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="this_year" {{ $period === 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </form>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="card bg-gradient-to-br from-primary-500 to-primary-600 text-white !p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="relative">
                    <p class="text-primary-100 text-sm font-medium mb-1">Total Pendapatan Kutu</p>
                    <h3 class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="card bg-gradient-to-br from-accent-500 to-accent-600 text-white !p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="relative">
                    <p class="text-accent-100 text-sm font-medium mb-1">Total Keuntungan Kotor</p>
                    <h3 class="text-3xl font-bold">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="card bg-white !p-5 border border-surface-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Total Transaksi Selesai</p>
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalOrders, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-surface-100 rounded-2xl flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Recent Orders --}}
            <div class="lg:col-span-2 card overflow-hidden">
                <div class="p-5 border-b border-surface-200">
                    <h3 class="font-bold text-slate-800">Transaksi Terakhir</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-surface-50 border-b border-surface-200">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Invoice</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kasir</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Struk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-100">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-surface-50/50 transition-colors">
                                    <td class="px-5 py-3 whitespace-nowrap text-sm font-medium text-primary-600">
                                        {{ $order->invoice_number }}
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-sm text-slate-600">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-sm font-bold text-slate-800">
                                        {{ $order->formatted_total }}
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-sm text-slate-600">
                                        {{ $order->user->name }}
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-right">
                                        <a href="{{ route('pos.receipt', $order->id) }}" target="_blank" class="text-slate-400 hover:text-primary-600">
                                            <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.724.092m6.588-4.61a1.125 1.125 0 01-2.25 0 1.125 1.125 0 012.25 0zm.66 4.61c.24.03.48.062.724.092m-6.588-4.61a1.125 1.125 0 01-2.25 0 1.125 1.125 0 012.25 0zm10.56-4.61c.24.03.48.062.724.092m-6.588-4.61a1.125 1.125 0 01-2.25 0 1.125 1.125 0 012.25 0zM12 18.75a1.125 1.125 0 110-2.25 1.125 1.125 0 010 2.25z"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-slate-400 text-sm">Tidak ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top Products --}}
            <div class="card overflow-hidden">
                <div class="p-5 border-b border-surface-200">
                    <h3 class="font-bold text-slate-800">Produk Terlaris</h3>
                </div>
                <div class="p-0">
                    @forelse($topProducts as $index => $item)
                        <div class="flex items-center gap-4 p-4 {{ !$loop->last ? 'border-b border-surface-100' : '' }}">
                            <div class="w-8 h-8 rounded-lg bg-surface-100 flex items-center justify-center font-bold text-slate-500 text-sm">
                                #{{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-slate-800 text-sm truncate">{{ $item->product_name }}</h4>
                                <p class="text-xs text-slate-500">{{ $item->total_sold }} Terjual</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-sm text-slate-800">Rp {{ number_format($item->total_revenue * 1000, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400 text-sm">Belum ada data penjualan.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
