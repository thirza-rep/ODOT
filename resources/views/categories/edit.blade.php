<x-layouts.app title="Edit Kategori">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali
            </a>
        </div>

        <div class="card animate-slide-up">
            <h3 class="text-lg font-semibold text-slate-800 mb-6">Edit Kategori: {{ $category->name }}</h3>

            <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required class="form-input @error('name') !border-red-400 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="form-label">Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <textarea id="description" name="description" rows="3" class="form-input">{{ old('description', $category->description) }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('categories.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
