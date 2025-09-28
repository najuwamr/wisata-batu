@extends('layouts.admin')

@section('title', 'Tambah Tiket Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-blue-900">Tambah Promo</h1>

    <form method="POST"
          action="{{ route('admin.insert.promo') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- Nama --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror"
                required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kode Promo --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Kode Promo</label>
            <input type="text"
                name="code"
                value="{{ old('code') }}"
                class="w-full border rounded px-3 py-2 @error('code') border-red-500 @enderror"
                required>
            @error('code')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Besar Diskon (%)</label>
            <input type="number"
                name="discount_percent"
                value="{{ old('discount_percent') }}"
                class="w-full border rounded px-3 py-2 @error('discount_percent') border-red-500 @enderror"
                min="0" max="100"
                required>
            @error('discount_percent')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Jumlah Kuota</label>
            <input type="number"
                name="qty"
                value="{{ old('qty') }}"
                class="w-full border rounded px-3 py-2 @error('qty') border-red-500 @enderror"
                min="1"
                required>
            @error('qty')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Periode Promo</label>
            <input type="date"
                name="valid_until"
                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                class="w-full border rounded px-3 py-2 @error('valid_until') border-red-500 @enderror"
                required>
            @error('valid_until')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Deskripsi</label>
            <textarea name="description"
                rows="4"
                class="w-full border rounded px-3 py-2 @error('description') border-red-500 @enderror"
                required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gambar --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Gambar</label>
            <input type="file"
                name="image"
                accept="image/*"
                onchange="previewImage(event)"
                class="w-full border rounded p-2 bg-transparent @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            {{-- Tempat preview --}}
            <div class="mt-3">
                <img id="image-preview" class="hidden max-h-48 rounded shadow">
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.get.tiket') }}"
               class="px-4 py-2 rounded border border-gray-400 text-gray-600 hover:bg-gray-100">
                Batal
            </a>
            <button type="submit"
                    class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-900">
                Simpan
            </button>
        </div>

        <script>
            function previewImage(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('image-preview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        preview.src = reader.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>
    </form>
</div>
@endsection
