{{-- Chatbot Widget (Floating) --}}
<div x-data="chatbot()" class="fixed bottom-6 right-6 z-50">
    {{-- Chat Panel --}}
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90 translate-y-4"
         class="absolute bottom-16 right-0 w-80 md:w-96 bg-white rounded-2xl shadow-2xl border border-surface-200 overflow-hidden"
         x-cloak>

        {{-- Chat Header --}}
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-5 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-sm">ODOT Assistant</h3>
                    <p class="text-white/70 text-xs">Siap membantu Anda</p>
                </div>
            </div>
            <button @click="isOpen = false" class="text-white/70 hover:text-white transition-colors cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Chat Messages --}}
        <div class="h-80 overflow-y-auto p-4 space-y-3 bg-surface-50" x-ref="chatMessages">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'bot' ? 'flex gap-2' : 'flex gap-2 justify-end'">
                    {{-- Bot avatar --}}
                    <div x-show="msg.role === 'bot'" class="w-7 h-7 rounded-lg bg-primary-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                    </div>
                    <div :class="msg.role === 'bot'
                        ? 'bg-white text-slate-700 rounded-2xl rounded-tl-md px-4 py-2.5 text-sm shadow-sm max-w-[85%]'
                        : 'bg-primary-500 text-white rounded-2xl rounded-tr-md px-4 py-2.5 text-sm shadow-sm max-w-[85%]'"
                        x-text="msg.text">
                    </div>
                </div>
            </template>
        </div>

        {{-- Chat Input --}}
        <div class="p-3 bg-white border-t border-surface-100">
            <form @submit.prevent="sendMessage" class="flex gap-2">
                <input x-model="input" type="text"
                       placeholder="Ketik pertanyaan..."
                       class="flex-1 px-3.5 py-2.5 rounded-xl bg-surface-50 border border-surface-200 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                <button type="submit"
                        class="p-2.5 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition-colors shrink-0 cursor-pointer shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- Floating Toggle Button --}}
    <button @click="isOpen = !isOpen"
            class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 text-white rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center cursor-pointer group">
        <svg x-show="!isOpen" class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
        </svg>
        <svg x-show="isOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<script>
function chatbot() {
    return {
        isOpen: false,
        input: '',
        messages: [
            { role: 'bot', text: 'Halo! 👋 Saya ODOT Assistant. Ada yang bisa saya bantu hari ini?' },
            { role: 'bot', text: 'Anda bisa bertanya tentang cara menggunakan fitur POS, mengelola stok, atau melihat laporan penjualan.' },
        ],
        sendMessage() {
            if (!this.input.trim()) return;

            // Add user message
            this.messages.push({ role: 'user', text: this.input });
            const userInput = this.input.toLowerCase();
            this.input = '';

            // Scroll to bottom
            this.$nextTick(() => {
                this.$refs.chatMessages.scrollTop = this.$refs.chatMessages.scrollHeight;
            });

            // Simulate bot response (mock)
            setTimeout(() => {
                let reply = 'Terima kasih atas pertanyaan Anda! Fitur AI chatbot akan segera terintegrasi. Sementara ini, silakan gunakan menu sidebar untuk navigasi. 😊';

                if (userInput.includes('stok') || userInput.includes('barang')) {
                    reply = '📦 Untuk mengelola stok, buka menu "Produk & Stok" di sidebar. Anda bisa menambah, mengubah, dan memantau pergerakan barang di sana.';
                } else if (userInput.includes('kasir') || userInput.includes('pos') || userInput.includes('jual')) {
                    reply = '💰 Buka menu "Kasir (POS)" untuk memulai transaksi penjualan. Cari barang, tambahkan ke keranjang, dan proses pembayaran dengan mudah!';
                } else if (userInput.includes('laporan') || userInput.includes('statistik') || userInput.includes('report')) {
                    reply = '📊 Menu "Statistik Penjualan" menampilkan grafik penjualan harian, mingguan, bulanan, serta produk terlaris dan profit kotor Anda.';
                } else if (userInput.includes('user') || userInput.includes('pengguna')) {
                    reply = '👥 Hanya Admin yang bisa mengelola pengguna. Buka menu "Manajemen User" untuk menambah, mengedit, atau menghapus user.';
                } else if (userInput.includes('halo') || userInput.includes('hai') || userInput.includes('hi')) {
                    reply = 'Hai juga! 😊 Ada yang bisa saya bantu tentang ODOT ERP?';
                }

                this.messages.push({ role: 'bot', text: reply });
                this.$nextTick(() => {
                    this.$refs.chatMessages.scrollTop = this.$refs.chatMessages.scrollHeight;
                });
            }, 800);
        }
    }
}
</script>
