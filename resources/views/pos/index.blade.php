<x-layouts.app title="Point of Sale">
    <div class="h-[calc(100vh-8rem)] flex flex-col lg:flex-row gap-6" 
         x-data="posApp()">
        
        {{-- Left: Products Grid --}}
        <div class="flex-1 flex flex-col min-h-0 bg-white rounded-3xl border border-surface-200 shadow-sm overflow-hidden">
            {{-- Header/Filters --}}
            <div class="p-4 border-b border-surface-200 flex flex-col sm:flex-row gap-4 items-center justify-between bg-surface-50">
                <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto hide-scrollbar pb-1 sm:pb-0">
                    <button @click="activeCategory = null" 
                            :class="!activeCategory ? 'bg-primary-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-surface-100 border border-surface-200'"
                            class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors">
                        Semua
                    </button>
                    @foreach($categories as $category)
                        <button @click="activeCategory = {{ $category->id }}" 
                                :class="activeCategory === {{ $category->id }} ? 'bg-primary-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-surface-100 border border-surface-200'"
                                class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-colors">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
                <div class="relative w-full sm:w-64 shrink-0">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="text" x-model="searchQuery" class="form-input pl-9 w-full !bg-white" placeholder="Cari produk...">
                </div>
            </div>

            {{-- Products Area --}}
            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar bg-surface-50/30">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <button @click="addToCart(product)" 
                                :disabled="product.stock <= 0"
                                class="text-left group relative bg-white border border-surface-200 rounded-2xl p-3 hover:border-primary-300 hover:shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            
                            <div class="aspect-square rounded-xl bg-surface-100 mb-3 overflow-hidden relative">
                                <template x-if="product.image_url">
                                    <img :src="product.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </template>
                                <template x-if="!product.image_url">
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                    </div>
                                </template>
                                
                                <template x-if="product.stock <= 0">
                                    <div class="absolute inset-0 bg-slate-900/60 flex items-center justify-center backdrop-blur-[2px]">
                                        <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">Habis</span>
                                    </div>
                                </template>
                            </div>
                            
                            <h4 class="font-semibold text-slate-800 text-sm mb-1 truncate" x-text="product.name"></h4>
                            <div class="flex items-center justify-between">
                                <p class="text-primary-600 font-bold text-sm" x-text="formatCurrency(product.sell_price)"></p>
                                <span class="text-[10px] text-slate-400 font-medium bg-surface-100 px-1.5 py-0.5 rounded" x-text="'Stok: ' + product.stock"></span>
                            </div>
                        </button>
                    </template>
                </div>
                
                <template x-if="filteredProducts.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-slate-400">
                        <svg class="w-12 h-12 mb-2 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p>Tidak ada produk ditemukan.</p>
                    </div>
                </template>
            </div>
        </div>

        {{-- Right: Cart --}}
        <div class="w-full lg:w-[400px] flex flex-col bg-white rounded-3xl border border-surface-200 shadow-sm overflow-hidden shrink-0">
            <div class="p-5 border-b border-surface-200 bg-surface-50 flex items-center justify-between">
                <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                    Pesanan Saat Ini
                </h3>
                <button @click="clearCart()" x-show="cart.length > 0" class="text-sm font-medium text-red-500 hover:text-red-600">
                    Kosongkan
                </button>
            </div>

            {{-- Cart Items --}}
            <div class="flex-1 overflow-y-auto p-2 custom-scrollbar">
                <template x-if="cart.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-slate-400 space-y-3">
                        <div class="w-16 h-16 bg-surface-50 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                        </div>
                        <p class="text-sm">Belum ada item di keranjang.</p>
                    </div>
                </template>

                <div class="space-y-1">
                    <template x-for="(item, index) in cart" :key="item.id">
                        <div class="p-3 bg-white rounded-xl hover:bg-surface-50 transition-colors group">
                            <div class="flex justify-between items-start mb-2">
                                <div class="pr-2">
                                    <h5 class="font-medium text-slate-800 text-sm leading-tight" x-text="item.name"></h5>
                                    <p class="text-primary-600 font-semibold text-sm mt-0.5" x-text="formatCurrency(item.sell_price)"></p>
                                </div>
                                <button @click="removeFromCart(index)" class="text-slate-300 hover:text-red-500 transition-colors p-1 -m-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3 bg-surface-100 rounded-lg p-1">
                                    <button @click="updateQuantity(index, item.quantity - 1)" class="w-7 h-7 rounded bg-white text-slate-600 shadow-sm hover:text-primary-600 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/></svg>
                                    </button>
                                    <span class="w-4 text-center font-semibold text-sm text-slate-800" x-text="item.quantity"></span>
                                    <button @click="updateQuantity(index, item.quantity + 1)" :disabled="item.quantity >= item.stock" class="w-7 h-7 rounded bg-white text-slate-600 shadow-sm hover:text-primary-600 flex items-center justify-center disabled:opacity-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    </button>
                                </div>
                                <span class="font-bold text-slate-800" x-text="formatCurrency(item.sell_price * item.quantity)"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Checkout Area --}}
            <div class="p-5 border-t border-surface-200 bg-white">
                <div class="space-y-3 mb-5">
                    <div class="flex justify-between text-sm text-slate-500">
                        <span>Subtotal</span>
                        <span class="font-medium text-slate-800" x-text="formatCurrency(subtotal)"></span>
                    </div>
                    {{-- Future: Diskon & Pajak --}}
                    <div class="flex justify-between text-lg font-bold text-slate-800 pt-3 border-t border-dashed border-surface-200">
                        <span>Total Tagihan</span>
                        <span class="text-primary-600" x-text="formatCurrency(total)"></span>
                    </div>
                </div>

                <button @click="openPaymentModal()" 
                        :disabled="cart.length === 0"
                        class="w-full btn-primary py-3.5 text-base shadow-lg shadow-primary-500/20 disabled:shadow-none">
                    Lanjutkan Pembayaran
                </button>
            </div>
        </div>

        {{-- Payment Modal --}}
        <div x-show="isPaymentModalOpen" 
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center px-4">
            
            <div x-show="isPaymentModalOpen" 
                 x-transition.opacity
                 @click="isPaymentModalOpen = false"
                 class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

            <div x-show="isPaymentModalOpen"
                 x-transition.scale.origin.bottom
                 class="bg-white rounded-3xl shadow-xl w-full max-w-md relative z-10 overflow-hidden flex flex-col max-h-[90vh]">
                 
                <div class="p-5 border-b border-surface-200 flex items-center justify-between bg-surface-50">
                    <h3 class="font-bold text-lg text-slate-800">Proses Pembayaran</h3>
                    <button @click="isPaymentModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto custom-scrollbar space-y-6">
                    <div class="text-center p-4 bg-primary-50 rounded-2xl border border-primary-100">
                        <p class="text-sm text-primary-600 font-medium mb-1">Total Tagihan</p>
                        <p class="text-3xl font-bold text-primary-700" x-text="formatCurrency(total)"></p>
                    </div>

                    <div>
                        <label class="form-label text-sm">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 gap-3 mt-2">
                            <label class="cursor-pointer">
                                <input type="radio" x-model="paymentMethod" value="cash" class="peer sr-only">
                                <div class="px-4 py-3 rounded-xl border border-surface-200 text-center peer-checked:bg-primary-50 peer-checked:border-primary-500 peer-checked:text-primary-700 transition-all">
                                    <svg class="w-6 h-6 mx-auto mb-1 opacity-70" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                    <span class="font-medium text-sm">Tunai</span>
                                </div>
                            </label>
                            {{-- Other methods are marked coming soon in UI, so they are disabled --}}
                            <label class="cursor-not-allowed opacity-50 relative" title="Coming Soon">
                                <input type="radio" disabled class="peer sr-only">
                                <div class="px-4 py-3 rounded-xl border border-surface-200 text-center bg-slate-50">
                                    <svg class="w-6 h-6 mx-auto mb-1 opacity-70" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z"/></svg>
                                    <span class="font-medium text-sm">QRIS</span>
                                </div>
                                <span class="absolute top-1 right-1 text-[8px] font-bold uppercase bg-slate-200 text-slate-500 px-1 rounded">Soon</span>
                            </label>
                        </div>
                    </div>

                    <div x-show="paymentMethod === 'cash'" x-transition>
                        <label class="form-label text-sm mb-2">Jumlah Uang Diterima</label>
                        
                        {{-- Quick amount buttons --}}
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            <button @click="amountPaid = total" class="py-2 rounded-lg bg-surface-100 hover:bg-surface-200 text-slate-700 font-medium text-sm transition-colors border border-surface-200">Uang Pas</button>
                            <button @click="addAmount(50000)" class="py-2 rounded-lg bg-surface-100 hover:bg-surface-200 text-slate-700 font-medium text-sm transition-colors border border-surface-200">+50K</button>
                            <button @click="addAmount(100000)" class="py-2 rounded-lg bg-surface-100 hover:bg-surface-200 text-slate-700 font-medium text-sm transition-colors border border-surface-200">+100K</button>
                        </div>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 font-bold pointer-events-none">Rp</span>
                            <input type="number" x-model.number="amountPaid" class="form-input pl-12 text-lg font-bold text-slate-800" placeholder="0">
                        </div>

                        {{-- Change calculation --}}
                        <div class="mt-4 p-4 rounded-xl border border-dashed border-surface-200 flex justify-between items-center"
                             :class="change < 0 ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200'">
                            <span class="text-sm font-medium" :class="change < 0 ? 'text-red-600' : 'text-green-700'">Kembalian</span>
                            <span class="text-xl font-bold" :class="change < 0 ? 'text-red-600' : 'text-green-700'" x-text="formatCurrency(change < 0 ? 0 : change)"></span>
                        </div>
                    </div>

                </div>

                <div class="p-5 border-t border-surface-200 bg-white">
                    <button @click="submitOrder()" 
                            :disabled="isLoading || change < 0"
                            class="w-full btn-primary py-3.5 text-base flex justify-center items-center">
                        <template x-if="isLoading">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </template>
                        <span x-text="isLoading ? 'Memproses...' : 'Selesaikan Transaksi'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script id="pos-products-data" type="application/json">
        {!! json_encode($products) !!}
    </script>
    <script>
        document.addEventListener('alpine:init', () => {
            const initialProducts = JSON.parse(document.getElementById('pos-products-data').textContent);
            
            Alpine.data('posApp', () => ({
                products: initialProducts,
                searchQuery: '',
                activeCategory: null,
                cart: [],
                
                isPaymentModalOpen: false,
                paymentMethod: 'cash',
                amountPaid: 0,
                isLoading: false,

                get filteredProducts() {
                    let result = this.products;
                    if (this.activeCategory) {
                        result = result.filter(p => p.category_id === this.activeCategory);
                    }
                    if (this.searchQuery) {
                        const lowerCaseQuery = this.searchQuery.toLowerCase();
                        result = result.filter(p => p.name.toLowerCase().includes(lowerCaseQuery) || (p.sku && p.sku.toLowerCase().includes(lowerCaseQuery)));
                    }
                    return result;
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.sell_price * item.quantity), 0);
                },

                get total() {
                    return this.subtotal;
                },

                get change() {
                    return this.amountPaid - this.total;
                },

                addToCart(product) {
                    const existingIndex = this.cart.findIndex(item => item.id === product.id);
                    if (existingIndex > -1) {
                        if (this.cart[existingIndex].quantity < product.stock) {
                            this.cart[existingIndex].quantity++;
                        } else {
                            alert('Stok tidak mencukupi!');
                        }
                    } else {
                        this.cart.push({ ...product, quantity: 1 });
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                updateQuantity(index, newQty) {
                    if (newQty < 1) {
                        this.removeFromCart(index);
                        return;
                    }
                    if (newQty <= this.cart[index].stock) {
                        this.cart[index].quantity = newQty;
                    } else {
                        alert('Stok maksimal hanya ' + this.cart[index].stock);
                    }
                },

                clearCart() {
                    if(confirm('Yakin ingin mengosongkan pesanan?')) {
                        this.cart = [];
                    }
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(amount);
                },

                openPaymentModal() {
                    this.amountPaid = 0;
                    this.isPaymentModalOpen = true;
                },

                addAmount(amount) {
                    this.amountPaid = (this.amountPaid || 0) + amount;
                },

                async submitOrder() {
                    if (this.change < 0) {
                        alert('Uang yang dibayar kurang dari total!');
                        return;
                    }

                    this.isLoading = true;

                    const payload = {
                        items: this.cart.map(i => ({ product_id: i.id, quantity: i.quantity })),
                        payment_method: this.paymentMethod,
                        amount_paid: this.amountPaid,
                        notes: null
                    };

                    try {
                        const response = await fetch('{{ route('pos.checkout') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            window.location.href = result.redirect_url;
                        } else {
                            alert('Gagal memproses transaksi: ' + (result.message || 'Unknown error'));
                            this.isLoading = false;
                        }
                    } catch (error) {
                        alert('Terjadi kesalahan jaringan.');
                        this.isLoading = false;
                    }
                }
            }));
        });
    </script>
    @endpush
</x-layouts.app>
