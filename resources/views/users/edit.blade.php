<x-layouts.app title="Edit User">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali
            </a>
        </div>

        <div class="card animate-slide-up">
            <h3 class="text-lg font-semibold text-slate-800 mb-6">Edit Pengguna: {{ $user->name }}</h3>

            <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="form-input @error('name') !border-red-400 @enderror">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="form-input @error('email') !border-red-400 @enderror">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="form-input">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="role" class="form-label">Role / Hak Akses</label>
                        <select id="role" name="role" required class="form-input">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="branch_id" class="form-label">Cabang</label>
                        <select id="branch_id" name="branch_id" class="form-input">
                            <option value="">Tidak ada cabang</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }} ({{ $branch->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200">
                    <p class="text-sm font-medium text-amber-800 mb-3">Ubah Kata Sandi (kosongkan jika tidak ingin mengubah)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="form-label">Kata Sandi Baru</label>
                            <input id="password" name="password" type="password" class="form-input @error('password') !border-red-400 @enderror">
                            @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="form-label">Konfirmasi</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-input">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
