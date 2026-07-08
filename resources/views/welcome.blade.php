<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ODOT ERP - Belajar Berkembang Bertumbuh Bersama</title>
    
    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #4F7DF3, #00C9A7);
        }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased selection:bg-primary-500 selection:text-white" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    {{-- Navbar --}}
    <nav :class="{'bg-white shadow-sm py-3': scrolled, 'bg-transparent py-5': !scrolled}" class="fixed top-0 w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="ODOT ERP Logo" class="h-16 md:h-20 w-auto">
                <span class="font-bold text-2xl tracking-tight text-slate-900 hidden sm:block">ODOT</span>
            </div>
            
            <div class="hidden md:flex space-x-8">
                <a href="#features" class="text-slate-600 hover:text-primary-600 font-medium transition-colors">Fitur</a>
                <a href="#trends" class="text-slate-600 hover:text-primary-600 font-medium transition-colors">Tren Pasar</a>
                <a href="#about" class="text-slate-600 hover:text-primary-600 font-medium transition-colors">Tentang Kami</a>
            </div>

            <div>
                <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full bg-slate-900 text-white font-medium hover:bg-primary-600 transition-colors shadow-lg shadow-primary-500/20">
                    Masuk ke Sistem
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        {{-- Background decorative shapes --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-primary-100/50 blur-3xl opacity-50 z-0"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-accent-100/50 blur-3xl opacity-50 z-0"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">
                Kelola Bisnis, <br>
                <span class="gradient-text">Tanpa Batas.</span>
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-slate-500 max-w-3xl mx-auto font-light leading-relaxed">
                ODOT ERP adalah platform manajemen bisnis all-in-one yang menyatukan Point of Sale, Inventaris, dan Analitik dalam satu ekosistem cloud yang cerdas.
            </p>
            
            <div class="mt-10 mb-4">
                <p class="text-primary-600 font-semibold text-lg tracking-wide uppercase">
                    Belajar <span class="mx-2 text-slate-300">•</span> Berkembang <span class="mx-2 text-slate-300">•</span> Bertumbuh Bersama
                </p>
            </div>

            <div class="mt-8 flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-full bg-primary-600 text-white font-bold text-lg hover:bg-primary-700 transition-colors shadow-xl shadow-primary-500/30 transform hover:-translate-y-1">
                    Mulai Sekarang
                </a>
                <a href="#features" class="px-8 py-4 rounded-full bg-white text-slate-700 border border-slate-200 font-bold text-lg hover:bg-slate-50 transition-colors shadow-sm transform hover:-translate-y-1">
                    Pelajari Fitur
                </a>
            </div>
            
            {{-- App Preview Dashboard --}}
            <div class="mt-20 max-w-5xl mx-auto relative group perspective">
                <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent z-10 bottom-0 top-1/2"></div>
                <div class="rounded-2xl border border-slate-200 shadow-2xl bg-white overflow-hidden transform transition-transform duration-700 hover:scale-[1.02]">
                    <div class="h-8 bg-slate-100 border-b border-slate-200 flex items-center px-4 gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    </div>
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Dashboard Preview" class="w-full h-auto object-cover opacity-90 blur-[2px] group-hover:blur-0 transition-all duration-500">
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-slate-900 mb-6">Segala yang Anda Butuhkan</h2>
                <p class="text-lg text-slate-600">Satu aplikasi untuk menggantikan puluhan aplikasi terpisah. ODOT ERP dirancang untuk mempercepat operasional dari hulu ke hilir.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-primary-50 flex items-center justify-center mb-6 text-primary-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.999 2.999 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.999 2.999 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Multi-Cabang & Gudang</h3>
                    <p class="text-slate-600 leading-relaxed">Pantau seluruh cabang bisnis Anda dari satu layar. Perpindahan stok antar toko menjadi transparan dan akurat.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-accent-50 flex items-center justify-center mb-6 text-accent-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">POS Super Kilat</h3>
                    <p class="text-slate-600 leading-relaxed">Sistem kasir cerdas dan responsif. Dirancang untuk antrean panjang, memproses transaksi hanya dalam hitungan detik.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center mb-6 text-indigo-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Analitik Real-time</h3>
                    <p class="text-slate-600 leading-relaxed">Keputusan berbasis data. Dapatkan wawasan instan tentang produk terlaris, profitabilitas, dan arus kas harian Anda.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Market Trend Reader Section --}}
    <section id="trends" class="py-24 bg-white overflow-hidden" x-data="trendVisualizer()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                
                {{-- Text Content --}}
                <div class="lg:w-1/2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-50 text-accent-700 text-sm font-semibold mb-6">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-accent-500"></span>
                        </span>
                        Live AI Insights
                    </div>
                    <h2 class="text-3xl md:text-5xl font-bold text-slate-900 mb-6 leading-tight">Pembaca Trend Pasar Masa Depan.</h2>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        Di dunia bisnis yang bergerak cepat, insting saja tidak cukup. Mesin cerdas ODOT mengolah ribuan transaksi Anda untuk mendeteksi <span class="font-bold text-primary-600">puncak permintaan</span>, memprediksi produk mana yang akan habis, dan kapan waktu terbaik untuk promosi.
                    </p>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-slate-700 font-medium">Prediksi kekosongan stok otomatis</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-slate-700 font-medium">Pemetaan jam sibuk (Rush Hour Heatmap)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-slate-700 font-medium">Analisis tren produk musiman</span>
                        </li>
                    </ul>
                </div>

                {{-- Chart UI --}}
                <div class="lg:w-1/2 w-full">
                    <div class="bg-slate-900 rounded-3xl p-6 shadow-2xl relative">
                        {{-- UI Decoration --}}
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h4 class="text-white font-bold text-lg">Proyeksi Penjualan AI</h4>
                                <p class="text-slate-400 text-sm">Update 2 detik yang lalu</p>
                            </div>
                            <div class="px-3 py-1 rounded bg-green-500/20 text-green-400 text-xs font-bold border border-green-500/30">
                                +34.5% Growth
                            </div>
                        </div>

                        {{-- Chart Container --}}
                        <div class="h-64 w-full">
                            <canvas id="trendChart"></canvas>
                        </div>
                        
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-4 hidden sm:flex">
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Jam Sibuk Prediksi</p>
                                <p class="text-xl font-black text-slate-900">18:00 - 20:00</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Call To Action --}}
    <section class="py-20 bg-gradient-to-br from-primary-600 to-primary-800 text-center relative overflow-hidden">
        {{-- Deco --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-white opacity-5 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-accent-400 opacity-20 blur-3xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Siap untuk Bertumbuh?</h2>
            <p class="text-primary-100 text-lg mb-10">
                Bergabunglah dan biarkan ODOT ERP mengambil alih kerumitan operasional Anda. <br class="hidden sm:block">Fokus pada pertumbuhan, kami yang mengurus sistemnya.
            </p>
            <a href="{{ route('login') }}" class="inline-block px-10 py-5 rounded-full bg-white text-primary-700 font-bold text-xl hover:bg-slate-50 transition-colors shadow-2xl transform hover:scale-105">
                Mulai Gunakan ODOT ERP
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-900 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="ODOT" class="h-12 md:h-14 w-auto grayscale opacity-70">
                <span class="text-xl font-bold text-slate-400">ODOT ERP</span>
            </div>
            
            <p class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} ODOT ERP. Belajar Berkembang Bertumbuh Bersama.
            </p>
            
            <div class="flex gap-4">
                <a href="#" class="text-slate-500 hover:text-white transition-colors">Bantuan</a>
                <a href="#" class="text-slate-500 hover:text-white transition-colors">Privasi</a>
                <a href="#" class="text-slate-500 hover:text-white transition-colors">Syarat Ketentuan</a>
            </div>
        </div>
    </footer>

    {{-- Trend Market Chart Script --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('trendVisualizer', () => ({
                chart: null,
                
                init() {
                    this.initChart();
                    
                    // Animate data every 3 seconds to simulate "Live AI"
                    setInterval(() => {
                        this.updateData();
                    }, 3000);
                },
                
                initChart() {
                    const ctx = document.getElementById('trendChart').getContext('2d');
                    
                    // Create a beautiful gradient for the line
                    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(0, 201, 167, 0.5)'); // Mint Green
                    gradient.addColorStop(1, 'rgba(0, 201, 167, 0.0)');
                    
                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'],
                            datasets: [{
                                label: 'Volume Penjualan',
                                data: [12, 19, 35, 25, 22, 45, 60],
                                borderColor: '#00C9A7',
                                backgroundColor: gradient,
                                borderWidth: 3,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#00C9A7',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    padding: 10,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.y + ' Transaksi';
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false, drawBorder: false },
                                    ticks: { color: '#64748b' }
                                },
                                y: {
                                    grid: { color: 'rgba(255, 255, 255, 0.05)', borderDash: [5, 5] },
                                    ticks: { display: false }
                                }
                            }
                        }
                    });
                },
                
                updateData() {
                    if (!this.chart) return;
                    
                    // Shift labels
                    let labels = this.chart.data.labels;
                    let lastHour = parseInt(labels[labels.length - 1].split(':')[0]);
                    let nextHour = (lastHour + 1 > 23 ? 0 : lastHour + 1).toString().padStart(2, '0') + ':00';
                    
                    labels.shift();
                    labels.push(nextHour);
                    
                    // Shift data and generate new trend point
                    let data = this.chart.data.datasets[0].data;
                    let lastVal = data[data.length - 1];
                    let newVal = Math.max(10, lastVal + (Math.floor(Math.random() * 30) - 10)); // Upward bias
                    
                    data.shift();
                    data.push(newVal);
                    
                    this.chart.update('none'); // Update without full animation for smooth streaming effect
                }
            }));
        });
    </script>
</body>
</html>
