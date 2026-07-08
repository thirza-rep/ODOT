{{-- Sidebar Navigation --}}
<aside class="fixed top-0 left-0 z-50 h-full bg-white border-r border-surface-200 shadow-sm transition-all duration-300 flex flex-col"
       :class="[
           sidebarOpen ? 'w-64' : 'w-20',
           mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
       ]">

    {{-- Logo / Brand --}}
    <div class="flex items-center gap-3 px-5 h-16 border-b border-surface-100 shrink-0">
        <div class="w-9 h-9 flex items-center justify-center shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="ODOT ERP" class="w-full h-full object-contain rounded-lg">
        </div>
        <div x-show="sidebarOpen" x-transition class="overflow-hidden">
            <h1 class="text-lg font-bold text-slate-800 leading-tight">ODOT</h1>
            <p class="text-[10px] text-slate-400 font-medium tracking-wider uppercase -mt-0.5">ERP System</p>
        </div>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
            </svg>
            <span x-show="sidebarOpen" x-transition class="truncate">Dashboard</span>
        </a>

        {{-- Section: Inventaris (Owner) --}}
        @can('product.view')
        <div class="pt-4">
            <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-semibold text-slate-400 uppercase tracking-widest">Inventaris</p>
            <div x-show="!sidebarOpen" class="border-t border-surface-100 mx-2 mb-2"></div>

            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition class="truncate">Kategori</span>
            </a>

            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition class="truncate">Produk & Stok</span>
            </a>

            <a href="{{ route('stock-movements.index') }}" class="nav-link {{ request()->routeIs('stock-movements.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
                </svg>
                <span x-show="sidebarOpen" x-transition class="truncate">Pergerakan Stok</span>
            </a>
        </div>
        @endcan

        {{-- Section: POS (Owner) --}}
        @can('pos.access')
        <div class="pt-4">
            <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-semibold text-slate-400 uppercase tracking-widest">Kasir</p>
            <div x-show="!sidebarOpen" class="border-t border-surface-100 mx-2 mb-2"></div>

            <a href="{{ route('pos.index') }}" class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition class="truncate">Kasir (POS)</span>
            </a>
        </div>
        @endcan

        {{-- Section: Reports (Owner) --}}
        @can('report.view')
        <div class="pt-4">
            <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-semibold text-slate-400 uppercase tracking-widest">Laporan</p>
            <div x-show="!sidebarOpen" class="border-t border-surface-100 mx-2 mb-2"></div>

            <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition class="truncate">Statistik Penjualan</span>
            </a>
        </div>
        @endcan

        {{-- Section: Admin --}}
        @can('user.view')
        <div class="pt-4">
            <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-semibold text-slate-400 uppercase tracking-widest">Administrasi</p>
            <div x-show="!sidebarOpen" class="border-t border-surface-100 mx-2 mb-2"></div>

            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition class="truncate">Manajemen User</span>
            </a>
        </div>
        @endcan

        @can('branch.view')
        <div class="pt-4">
            <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-semibold text-slate-400 uppercase tracking-widest">Cabang</p>
            <div x-show="!sidebarOpen" class="border-t border-surface-100 mx-2 mb-2"></div>

            <a href="{{ route('branches.index') }}" class="nav-link {{ request()->routeIs('branches.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.999 2.999 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.999 2.999 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition class="truncate">Manajemen Cabang</span>
            </a>
        </div>
        @endcan
    </nav>

    {{-- Sidebar Footer: Collapse Toggle --}}
    <div class="border-t border-surface-100 px-3 py-3 shrink-0 hidden lg:block">
        <button @click="sidebarOpen = !sidebarOpen"
                class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-sm text-slate-400 hover:bg-surface-50 hover:text-slate-600 transition-colors cursor-pointer">
            <svg class="w-5 h-5 transition-transform duration-300" :class="sidebarOpen ? '' : 'rotate-180'" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"/>
            </svg>
            <span x-show="sidebarOpen" x-transition class="text-xs">Kecilkan</span>
        </button>
    </div>
</aside>
