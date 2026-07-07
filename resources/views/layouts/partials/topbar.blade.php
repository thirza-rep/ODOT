{{-- Topbar --}}
<header class="sticky top-0 z-30 h-16 bg-white/80 backdrop-blur-lg border-b border-surface-100 flex items-center justify-between px-4 md:px-6 lg:px-8">
    {{-- Left: Mobile menu toggle + Page title --}}
    <div class="flex items-center gap-3">
        <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-surface-100 transition-colors cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
        </button>

        <div>
            <h2 class="text-lg font-semibold text-slate-800">{{ $title ?? 'Dashboard' }}</h2>
            @if(auth()->user()->branch)
                <p class="text-xs text-slate-400 -mt-0.5">{{ auth()->user()->branch->name }}</p>
            @endif
        </div>
    </div>

    {{-- Right: Actions + Profile --}}
    <div class="flex items-center gap-2 md:gap-3">
        {{-- Notifications (placeholder) --}}
        <button class="relative p-2 rounded-xl text-slate-500 hover:bg-surface-100 transition-colors cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            {{-- Notification dot --}}
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        {{-- Profile Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.outside="open = false"
                    class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-xl hover:bg-surface-50 transition-colors cursor-pointer">
                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                     class="w-8 h-8 rounded-lg object-cover ring-2 ring-surface-100">
                <div class="hidden md:block text-left">
                    <p class="text-sm font-medium text-slate-700 leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 capitalize">{{ auth()->user()->roles->first()?->name ?? 'User' }}</p>
                </div>
                <svg class="w-4 h-4 text-slate-400 hidden md:block transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-surface-200 py-1.5 z-50"
                 x-cloak>

                <div class="px-4 py-2.5 border-b border-surface-100">
                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-600 hover:bg-surface-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    Profil Saya
                </a>

                <div class="border-t border-surface-100 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
