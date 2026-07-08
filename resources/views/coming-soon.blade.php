<x-layouts.guest title="Coming Soon">
    <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 md:p-12 text-center animate-fade-in max-w-lg mx-auto">
        <div class="w-24 h-24 mx-auto mb-6 rounded-3xl bg-primary-50 flex items-center justify-center text-primary-500 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-4 tracking-tight">
            Segera Hadir
        </h1>
        
        <p class="text-slate-500 max-w-md mx-auto leading-relaxed mb-8">
            Kami sedang menyiapkan fitur ini khusus untuk Anda di lingkungan <i>production</i>. Harap kembali lagi nanti!
        </p>

        <a href="{{ route('home') }}" class="btn-primary inline-flex py-3 px-8 text-base shadow-lg shadow-primary-500/30">
            Kembali ke Beranda
        </a>
    </div>
</x-layouts.guest>
