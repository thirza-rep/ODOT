<x-layouts.app title="Coming Soon">
    <div class="flex flex-col items-center justify-center min-h-[calc(100vh-10rem)] text-center animate-fade-in">
        <div class="w-24 h-24 mb-6 rounded-3xl bg-primary-50 flex items-center justify-center text-primary-500 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 mb-4 tracking-tight">
            Segera Hadir
        </h1>
        
        <p class="text-lg text-slate-500 max-w-md mx-auto leading-relaxed mb-8">
            Kami sedang menyiapkan fitur ini khusus untuk Anda di *production environment* Vercel. Harap kembali lagi nanti!
        </p>

        <a href="{{ route('home') }}" class="btn-primary py-3 px-8 text-base shadow-lg shadow-primary-500/30">
            Kembali ke Beranda
        </a>
    </div>
</x-layouts.app>
