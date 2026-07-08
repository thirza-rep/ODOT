<x-layouts.app title="Manajemen Cabang">
    <div class="space-y-6" x-data="branchManagement()">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Manajemen Cabang</h2>
                <p class="text-sm text-slate-500">Kelola daftar cabang atau lokasi usaha</p>
            </div>
            <button @click="openCreateModal()" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Tambah Cabang
            </button>
        </div>

        {{-- Table --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-container">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="table-header">Nama Cabang</th>
                        <th class="table-header">Kode</th>
                        <th class="table-header">Alamat</th>
                        <th class="table-header">Telepon</th>
                        <th class="table-header">Status</th>
                        <th class="table-header text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $branch)
                        <tr class="table-row">
                            <td class="table-cell">
                                <div class="font-medium text-slate-800">{{ $branch->name }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    {{ $branch->users_count }} Pengguna terdaftar
                                </div>
                            </td>
                            <td class="table-cell font-mono text-sm text-slate-600">{{ $branch->code }}</td>
                            <td class="table-cell text-slate-500 max-w-[200px] truncate" title="{{ $branch->address }}">{{ $branch->address ?? '-' }}</td>
                            <td class="table-cell text-slate-500">{{ $branch->phone ?? '-' }}</td>
                            <td class="table-cell">
                                @if($branch->is_active)
                                    <span class="badge bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="badge bg-red-100 text-red-700">Nonaktif</span>
                                @endif
                            </td>
                            <td class="table-cell text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button @click="openEditModal(JSON.parse($el.dataset.branch))" data-branch="{{ $branch->toJson() }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 transition-colors cursor-pointer" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                    </button>
                                    
                                    <form method="POST" action="{{ route('branches.destroy', $branch) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cabang {{ $branch->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-cell text-center py-12 text-slate-400">Belum ada data cabang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal Create/Edit --}}
        <div x-show="isModalOpen" 
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center px-4"
             x-cloak>
            
            <div x-show="isModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"
                 @click="closeModal()"></div>

            <div x-show="isModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative bg-white w-full max-w-lg rounded-2xl shadow-xl border border-surface-200 flex flex-col max-h-[90vh]">
                
                <div class="px-6 py-4 border-b border-surface-200 flex items-center justify-between bg-surface-50 rounded-t-2xl shrink-0">
                    <h3 class="font-bold text-lg text-slate-800" x-text="isEditing ? 'Edit Cabang' : 'Tambah Cabang Baru'"></h3>
                    <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <form :action="formAction" method="POST" id="branchForm">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" x-bind:disabled="!isEditing">

                        <div class="space-y-4">
                            <div>
                                <label class="form-label">Nama Cabang <span class="text-red-500">*</span></label>
                                <input type="text" name="name" x-model="form.name" class="form-input" required placeholder="Contoh: Cabang Sudirman">
                            </div>

                            <div>
                                <label class="form-label">Kode Cabang <span class="text-red-500">*</span></label>
                                <input type="text" name="code" x-model="form.code" class="form-input font-mono" required placeholder="Contoh: SDIR-01">
                                <p class="text-[11px] text-slate-500 mt-1">Gunakan huruf besar dan angka tanpa spasi.</p>
                            </div>

                            <div>
                                <label class="form-label">Alamat</label>
                                <textarea name="address" x-model="form.address" class="form-input" rows="3" placeholder="Alamat lengkap cabang"></textarea>
                            </div>

                            <div>
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone" x-model="form.phone" class="form-input" placeholder="08123456789">
                            </div>

                            <label class="flex items-center gap-3 p-3 rounded-xl border border-surface-200 hover:bg-surface-50 transition-colors cursor-pointer group">
                                <input type="checkbox" name="is_active" value="1" x-model="form.is_active" class="w-5 h-5 rounded border-slate-300 text-primary-600 focus:ring-primary-500 transition-colors">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Status Aktif</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Cabang yang dinonaktifkan tidak akan bisa login.</p>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="px-6 py-4 border-t border-surface-200 bg-surface-50 flex items-center justify-end gap-3 rounded-b-2xl shrink-0">
                    <button type="button" @click="closeModal()" class="btn-secondary">Batal</button>
                    <button type="submit" form="branchForm" class="btn-primary" x-text="isEditing ? 'Simpan Perubahan' : 'Simpan Cabang'"></button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('branchManagement', () => ({
                isModalOpen: false,
                isEditing: false,
                formAction: '{{ route("branches.store") }}',
                
                form: {
                    id: null,
                    name: '',
                    code: '',
                    address: '',
                    phone: '',
                    is_active: true
                },

                openCreateModal() {
                    this.isEditing = false;
                    this.formAction = '{{ route("branches.store") }}';
                    this.form = {
                        id: null,
                        name: '',
                        code: '',
                        address: '',
                        phone: '',
                        is_active: true
                    };
                    this.isModalOpen = true;
                },

                openEditModal(branch) {
                    this.isEditing = true;
                    this.formAction = `{{ url('/branches') }}/${branch.id}`;
                    this.form = {
                        id: branch.id,
                        name: branch.name,
                        code: branch.code,
                        address: branch.address,
                        phone: branch.phone,
                        is_active: branch.is_active
                    };
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                }
            }));
        });
    </script>
    @endpush
</x-layouts.app>
