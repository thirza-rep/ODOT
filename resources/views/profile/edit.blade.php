<x-layouts.app title="Profil Saya">
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Profile Info --}}
        <div class="card animate-slide-up">
            <h3 class="text-lg font-semibold text-slate-800 mb-6">Informasi Profil</h3>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Avatar --}}
                <div class="flex items-center gap-4" x-data="{ preview: null }">
                    <div class="relative">
                        <img :src="preview || '{{ $user->avatar_url }}'" alt="Avatar"
                             class="w-20 h-20 rounded-2xl object-cover ring-4 ring-surface-100">
                    </div>
                    <div>
                        <label class="btn-secondary cursor-pointer text-sm">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                            Ubah Foto
                            <input type="file" name="avatar" class="hidden" accept="image/*"
                                   @change="preview = URL.createObjectURL($event.target.files[0])">
                        </label>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, WebP. Max 2MB.</p>
                    </div>
                </div>

                {{-- Name --}}
                <div>
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="form-input @error('name') !border-red-400 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="form-input @error('email') !border-red-400 @enderror">
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="form-input" placeholder="081234567890">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="card animate-slide-up" style="animation-delay: 100ms">
            <h3 class="text-lg font-semibold text-slate-800 mb-6">Ubah Kata Sandi</h3>

            <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                    <input id="current_password" name="current_password" type="password" required class="form-input @error('current_password') !border-red-400 @enderror">
                    @error('current_password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="form-label">Kata Sandi Baru</label>
                    <input id="password" name="password" type="password" required class="form-input @error('password') !border-red-400 @enderror">
                    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="form-input">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        Ubah Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
