<x-layouts.app title="Manajemen User">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Manajemen Pengguna</h2>
                <p class="text-sm text-slate-500">Kelola semua pengguna sistem ODOT ERP</p>
            </div>
            <a href="{{ route('users.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Tambah User
            </a>
        </div>

        {{-- Search --}}
        <div class="card !p-4">
            <form method="GET" class="flex gap-3">
                <input name="search" value="{{ request('search') }}" type="text" class="form-input max-w-xs" placeholder="Cari nama atau email...">
                <button type="submit" class="btn-secondary">Cari</button>
                @if(request('search'))
                    <a href="{{ route('users.index') }}" class="btn-ghost">Reset</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="table-container">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="table-header">User</th>
                        <th class="table-header">Email</th>
                        <th class="table-header">Role</th>
                        <th class="table-header">Cabang</th>
                        <th class="table-header">Bergabung</th>
                        <th class="table-header text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="table-row">
                            <td class="table-cell">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar_url }}" alt="" class="w-9 h-9 rounded-lg object-cover ring-2 ring-surface-100">
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $user->phone ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="table-cell text-slate-500">{{ $user->email }}</td>
                            <td class="table-cell">
                                @foreach($user->roles as $role)
                                    <span class="badge {{ $role->name === 'admin' ? 'bg-primary-100 text-primary-700' : 'bg-accent-100 text-accent-700' }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="table-cell text-slate-500">{{ $user->branch?->name ?? '-' }}</td>
                            <td class="table-cell text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="table-cell text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('users.edit', $user) }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-cell text-center py-12 text-slate-400">Tidak ada user ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div>{{ $users->withQueryString()->links() }}</div>
    </div>
</x-layouts.app>
