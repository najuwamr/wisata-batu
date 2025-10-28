@extends('layouts.admin')

@section('title', $isEdit ? '| Edit Tiket' : '| Tambah Tiket')

@section('content')
@php
    $ticket = $ticket ?? null;
    $selectedAset = old('aset', []);
    if (empty($selectedAset) && $ticket?->aset) {
        $selectedAset = $ticket->aset->pluck('id')->toArray();
    }
@endphp

<div class="md:ml-64 min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Header Section -->
    <div class="sticky top-0 bg-white/80 backdrop-blur-md shadow-sm z-10 px-6 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">
                    {{ $isEdit ? 'Edit Tiket' : 'Tambah Tiket' }}
                </h1>
                <p class="text-gray-600 text-sm">
                    {{ $isEdit ? 'Perbarui informasi tiket' : 'Lengkapi form untuk menambahkan tiket baru' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Form Content -->
    <div class="px-6 py-6">
        <form method="POST"
            action="{{ $isEdit ? route('admin.tiket.update', $ticket->id) : route('admin.tiket.insert') }}"
            enctype="multipart/form-data">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-6 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></div>
                            Informasi Dasar
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Tiket <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Contoh: Tiket Reguler Weekday"
                                    value="{{ old('name', $ticket->name ?? '') }}" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Harga <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                        <input type="number" name="price" id="price"
                                            class="w-full border border-gray-300 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            placeholder="50000"
                                            value="{{ old('price', $ticket->price ?? '') }}" required>
                                    </div>
                                    @error('price')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <select name="category" id="category"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white"
                                        required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="tiket" {{ old('category', $ticket->category ?? '') == 'tiket' ? 'selected' : '' }}>Tiket</option>
                                        <option value="parkir" {{ old('category', $ticket->category ?? '') == 'parkir' ? 'selected' : '' }}>Parkir</option>
                                        <option value="lainnya" {{ old('category', $ticket->category ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('category')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="5"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                    placeholder="Jelaskan detail tiket, termasuk benefit dan ketentuan..."
                                    required>{{ old('description', $ticket->description ?? '') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-6 bg-gradient-to-b from-green-500 to-emerald-600 rounded-full"></div>
                            Fasilitas
                        </h2>

                        <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-64 overflow-y-auto">
                            <div class="space-y-2">
                                @foreach($aset as $item)
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg hover:bg-blue-50 cursor-pointer transition-all border border-transparent hover:border-blue-200">
                                        <input type="checkbox" name="aset[]" value="{{ $item->id }}"
                                            {{ in_array($item->id, $selectedAset) ? 'checked' : '' }}
                                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                        <span class="text-gray-700 font-medium">{{ $item->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @error('aset')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-6 bg-gradient-to-b from-purple-500 to-pink-600 rounded-full"></div>
                            Gambar Tiket
                        </h2>

                        <div id="preview" class="mb-4 {{ $ticket?->image ? '' : 'hidden' }}">
                            <img id="previewImg"
                                src="{{ $ticket?->image ? asset('images/' . $ticket->image) : '' }}"
                                class="w-full h-64 object-cover rounded-xl border-2 border-gray-200">
                        </div>

                        <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 hover:border-blue-500 transition-all bg-gray-50 text-center">
                            <input type="file" name="image" id="image"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                accept="image/jpeg,image/jpg,image/png"
                                {{ $isEdit ? '' : 'required' }}>
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-600 font-semibold">Klik untuk upload</p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG (Max 2MB)</p>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror

                        <div class="mt-6 space-y-3">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $isEdit ? 'Perbarui Tiket' : 'Simpan Tiket' }}
                            </button>

                            <a href="{{ route('admin.tiket.get') }}"
                                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const img = document.getElementById('previewImg');
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
