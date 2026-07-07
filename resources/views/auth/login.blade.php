<x-layouts.guest title="Login">
    <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 md:p-10 animate-fade-in">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center shadow-lg shadow-primary-500/30">
                <span class="text-white font-bold text-2xl">O</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Selamat Datang</h1>
            <p class="text-slate-500 text-sm mt-1">Masuk ke ODOT ERP untuk melanjutkan</p>
        </div>

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="form-label">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                           class="form-input pl-10 @error('email') !border-red-400 !ring-red-400 @enderror"
                           placeholder="nama@email.com">
                </div>
                @error('email')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="relative" x-data="{ showPassword: false }">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </div>
                    <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required
                           class="form-input pl-10 pr-10 @error('password') !border-red-400 !ring-red-400 @enderror"
                           placeholder="••••••••">
                    <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg x-show="!showPassword" class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <svg x-show="showPassword" class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-surface-300 text-primary-500 focus:ring-primary-500 cursor-pointer">
                    <span class="text-sm text-slate-600">Ingat saya</span>
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-primary w-full py-3 text-base font-semibold shadow-lg shadow-primary-500/25">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                </svg>
                Masuk
            </button>
        </form>

        {{-- Footer --}}
        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; {{ date('Y') }} ODOT ERP. All rights reserved.
        </p>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
</x-layouts.guest>
