@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Tambah Tiket</h2>

    <form action="{{ route('admin.tiket.insert') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama Tiket --}}
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Nama Tiket</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2"
                value="{{ old('name') }}">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label for="description" class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Harga --}}
        <div class="mb-4">
            <label for="price" class="block font-semibold mb-1">Harga</label>
            <input type="number" name="price" id="price" class="w-full border rounded px-3 py-2"
                value="{{ old('price') }}">
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-4">
            <label for="category" class="block font-semibold mb-1">Kategori</label>
            <select name="category" id="category" class="w-full border rounded px-3 py-2">
                <option value="">-- Pilih Kategori --</option>
                <option value="tiket" {{ old('category') == 'tiket' ? 'selected' : '' }}>Tiket</option>
                <option value="parkir" {{ old('category') == 'parkir' ? 'selected' : '' }}>Parkir</option>
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gambar --}}
        <div class="mb-4">
            <label for="image" class="block font-semibold mb-1">Gambar Tiket</label>
            <input type="file" name="image" id="image" class="w-full border rounded px-3 py-2">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fasilitas (Aset) --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Fasilitas yang Tersedia</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($assets as $asset)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="aset[]" value="{{ $asset->id }}"
                            {{ in_array($asset->id, old('aset', [])) ? 'checked' : '' }}>
                        <span>{{ $asset->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('aset')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan Tiket
            </button>
        </div>
    </form>
</div>
@endsection
