<x-layouts.app title="Dashboard">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        {{-- Total Produk --}}
        <div class="stat-card animate-slide-up" style="animation-delay: 0ms">
            <div class="stat-card-icon bg-gradient-to-br from-primary-500 to-primary-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ number_format($totalProducts) }}</p>
                <p class="text-sm text-slate-500">Total Produk Aktif</p>
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="stat-card animate-slide-up" style="animation-delay: 75ms">
            <div class="stat-card-icon bg-gradient-to-br from-amber-400 to-orange-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ number_format($lowStockCount) }}</p>
                <p class="text-sm text-slate-500">Stok Rendah</p>
            </div>
        </div>

        {{-- Today Sales --}}
        <div class="stat-card animate-slide-up" style="animation-delay: 150ms">
            <div class="stat-card-icon bg-gradient-to-br from-accent-500 to-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ number_format($todaySalesCount) }}</p>
                <p class="text-sm text-slate-500">Penjualan Hari Ini</p>
            </div>
        </div>

        {{-- Today Revenue --}}
        <div class="stat-card animate-slide-up" style="animation-delay: 225ms">
            <div class="stat-card-icon bg-gradient-to-br from-violet-500 to-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($todayRevenue * 1000, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-500">Pendapatan Hari Ini</p>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Sales Chart (2/3 width) --}}
        <div class="lg:col-span-2 card animate-slide-up" style="animation-delay: 300ms">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Grafik Penjualan</h3>
                    <p class="text-sm text-slate-500">7 hari terakhir</p>
                </div>
                <span class="badge bg-primary-100 text-primary-700">Harian</span>
            </div>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Best Selling Products (1/3 width) --}}
        <div class="card animate-slide-up" style="animation-delay: 375ms">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Produk Terlaris</h3>
                    <p class="text-sm text-slate-500">Bulan ini</p>
                </div>
                <span class="badge bg-accent-100 text-accent-700">Top 5</span>
            </div>
            <div class="space-y-3">
                @forelse($bestSelling as $index => $item)
                    <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-surface-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ ['from-primary-400 to-primary-500', 'from-accent-400 to-accent-500', 'from-violet-400 to-violet-500', 'from-amber-400 to-amber-500', 'from-rose-400 to-rose-500'][$index] ?? 'from-slate-400 to-slate-500' }} flex items-center justify-center text-white text-xs font-bold shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-slate-700 truncate">{{ $item->product_name }}</p>
                            <p class="text-xs text-slate-400">{{ number_format($item->total_qty) }} terjual</p>
                        </div>
                        <p class="text-sm font-semibold text-slate-700 shrink-0">
                            Rp {{ number_format($item->total_revenue * 1000, 0, ',', '.') }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4"/>
                        </svg>
                        <p class="text-sm text-slate-400">Belum ada data penjualan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Market Research Widget --}}
    <div class="card animate-slide-up" style="animation-delay: 450ms">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">🔥 Riset Pasar — Produk Tren Marketplace</h3>
                <p class="text-sm text-slate-500">Data referensi dari Shopee & Tokopedia (mock data)</p>
            </div>
            <span class="badge bg-orange-100 text-orange-700">Live Trends</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($trendingProducts as $product)
                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-surface-50 border border-surface-100 hover:border-primary-200 hover:shadow-sm transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                        {{ $product['trend'] === 'hot' ? 'bg-red-100 text-red-600' : ($product['trend'] === 'rising' ? 'bg-amber-100 text-amber-600' : 'bg-slate-100 text-slate-500') }}">
                        @if($product['trend'] === 'hot')
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.378 1.602a.75.75 0 00-.756 0 24.764 24.764 0 00-4.86 3.95A20.263 20.263 0 003 14.25c0 5.385 4.365 9.75 9.75 9.75s9.75-4.365 9.75-9.75c0-4.073-1.816-7.728-4.762-10.698a24.764 24.764 0 00-5.36-3.95z"/></svg>
                        @elseif($product['trend'] === 'rising')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/></svg>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-slate-700 truncate">{{ $product['name'] }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-xs text-slate-400">{{ $product['platform'] }}</span>
                            <span class="text-xs text-slate-300">•</span>
                            <span class="text-xs font-medium {{ $product['trend'] === 'hot' ? 'text-red-500' : ($product['trend'] === 'rising' ? 'text-amber-500' : 'text-slate-400') }}">
                                {{ $product['sold'] }} terjual
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Chart.js Script --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    @endpush

    <script id="sales-data" type="application/json">
        {!! json_encode($salesChart) !!}
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart');
        if (!ctx) return;

        const salesData = JSON.parse(document.getElementById('sales-data').textContent);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: salesData.map(d => d.label),
                datasets: [{
                    label: 'Penjualan (Rp ribu)',
                    data: salesData.map(d => d.total),
                    backgroundColor: 'rgba(79, 125, 243, 0.15)',
                    borderColor: 'rgba(79, 125, 243, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        titleColor: '#F8FAFC',
                        bodyColor: '#CBD5E1',
                        borderColor: '#334155',
                        borderWidth: 1,
                        cornerRadius: 12,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y * 1000);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: {
                            color: '#94A3B8',
                            font: { size: 11 },
                            callback: function(value) { return 'Rp ' + value + 'rb'; }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94A3B8', font: { size: 11 } }
                    }
                }
            }
        });
    });
    </script>
</x-layouts.app>
