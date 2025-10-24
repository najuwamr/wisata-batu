{{-- resources/views/admin/tiket-form.blade.php --}}
@extends('layouts.admin')

@section('title', $isEdit ? '| Edit Tiket' : '| Tambah Tiket')

@section('content')
@php
    $ticket = $ticket ?? null;
    $selectedAset = old('aset', []);

    if (empty($selectedAset) && isset($ticket) && isset($ticket->aset)) {
        $selectedAset = $ticket->aset->pluck('id')->toArray();
    }
@endphp

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-red-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        {{-- Header Card --}}
        <div class="bg-gradient-to-r from-blue-600 to-red-600 rounded-t-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">
                        {{ $isEdit ? '✏️ Edit Tiket' : '➕ Tambah Tiket Baru' }}
                    </h1>
                    <p class="text-blue-100">
                        {{ $isEdit ? 'Perbarui informasi tiket Anda' : 'Lengkapi form untuk menambahkan tiket baru' }}
                    </p>
                </div>
                <a href="{{ route('admin.tiket.get') }}"
                   class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl">
                    ← Kembali
                </a>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-b-2xl shadow-2xl">
            <form method="POST"
                action="{{ $isEdit ? route('admin.tiket.update', $ticket->id) : route('admin.tiket.insert') }}"
                enctype="multipart/form-data"
                class="p-8">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-6">
                        {{-- Nama Tiket --}}
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                                📝 Nama Tiket <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300"
                                placeholder="Contoh: Tiket Reguler"
                                value="{{ old('name', $ticket->name ?? '') }}" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <span class="mr-1">⚠️</span>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label for="price" class="block text-sm font-bold text-gray-700 mb-2">
                                💰 Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                <input type="number" name="price" id="price"
                                    class="w-full border-2 border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300"
                                    placeholder="50000"
                                    value="{{ old('price', $ticket->price ?? '') }}" required>
                            </div>
                            @error('price')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <span class="mr-1">⚠️</span>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label for="category" class="block text-sm font-bold text-gray-700 mb-2">
                                🏷️ Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category" id="category"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 bg-white"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="tiket" {{ old('category', $ticket->category ?? '') == 'tiket' ? 'selected' : '' }}>
                                    🎫 Tiket
                                </option>
                                <option value="parkir" {{ old('category', $ticket->category ?? '') == 'parkir' ? 'selected' : '' }}>
                                    🅿️ Parkir
                                </option>
                                <option value="lainnya" {{ old('category', $ticket->category ?? '') == 'lainnya' ? 'selected' : '' }}>
                                    📦 Lainnya
                                </option>
                            </select>
                            @error('category')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <span class="mr-1">⚠️</span>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Gambar --}}
                        <div>
                            <label for="image" class="block text-sm font-bold text-gray-700 mb-2">
                                🖼️ Gambar Tiket <span class="text-red-500">{{ $isEdit ? '' : '*' }}</span>
                            </label>

                            {{-- Preview Gambar --}}
                            <div id="imagePreviewContainer" class="mb-3 {{ (isset($ticket) && $ticket->image) ? '' : 'hidden' }}">
                                <div class="relative inline-block">
                                    <img id="imagePreview"
                                         src="{{ isset($ticket) && $ticket->image ? asset('images/' . $ticket->image) : '' }}"
                                         alt="Preview"
                                         class="w-full h-48 object-cover rounded-xl border-4 border-blue-100 shadow-lg">
                                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                        Preview
                                    </div>
                                </div>
                            </div>

                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-500 transition-all duration-300 bg-gray-50">
                                <input type="file" name="image" id="image"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       accept="image/jpeg,image/jpg,image/png"
                                       onchange="previewImage(event)"
                                       {{ $isEdit ? '' : 'required' }}>
                                <div class="text-center">
                                    <div class="text-4xl mb-2">📸</div>
                                    <p class="text-sm text-gray-600 font-semibold">Klik untuk upload gambar</p>
                                    <p class="text-xs text-gray-400 mt-1">JPG, JPEG, PNG (Max. 2MB)</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <span class="mr-1">⚠️</span>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-6">
                        {{-- Deskripsi --}}
                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                                📋 Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="8"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 resize-none"
                                placeholder="Jelaskan detail tiket, termasuk benefit dan ketentuan..."
                                required>{{ old('description', $ticket->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <span class="mr-1">⚠️</span>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Fasilitas (Aset) --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                ✨ Fasilitas yang Tersedia
                            </label>

                            <div class="relative border-2 border-gray-200 rounded-xl bg-gradient-to-br from-blue-50 to-red-50">
                                <div class="max-h-64 overflow-y-auto p-4 scroll-smooth">
                                    <div class="grid grid-cols-1 gap-3">
                                        @foreach($aset as $item)
                                            <label class="flex items-center space-x-3 p-3 bg-white rounded-lg hover:bg-blue-50 cursor-pointer transition-all duration-200 border border-gray-200 hover:border-blue-300 hover:shadow-md group">
                                                <input type="checkbox" name="aset[]" value="{{ $item->id }}"
                                                    {{ in_array($item->id, $selectedAset) ? 'checked' : '' }}
                                                    class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                                <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors">
                                                    {{ $item->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            @error('aset')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <span class="mr-1">⚠️</span>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Action Buttons (Fixed) --}}
                <div class="fixed bottom-0 left-0 right-0 bg-white border-t-2 border-gray-200 shadow-2xl z-50">
                    <div class="max-w-4xl mx-auto px-8 py-4">
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.tiket.get') }}"
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-md hover:shadow-lg">
                                ❌ Batal
                            </a>
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-red-600 hover:from-blue-700 hover:to-red-700 text-white px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                {{ $isEdit ? '💾 Perbarui Tiket' : '✅ Simpan Tiket' }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Spacer untuk button fixed --}}
                <div class="h-20"></div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript untuk Preview Gambar --}}
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const container = document.getElementById('imagePreviewContainer');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            container.classList.remove('hidden');
        }

        reader.readAsDataURL(file);
    }
}
</script>

<style>
/* Custom Scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #3b82f6, #ef4444);
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #2563eb, #dc2626);
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}
</style>
@endsection
