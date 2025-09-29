@extends('layouts.admin')

@section('title', 'Tambah Tiket Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-blue-900">Tambah Tiket</h1>

    <form method="POST"
          action="{{ route('admin.insert.tiket') }}"
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

        {{-- Harga --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Harga</label>
            <input type="number"
                name="price"
                value="{{ old('price') }}"
                class="w-full border rounded px-3 py-2 @error('price') border-red-500 @enderror"
                required>
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Kategori</label>
            <select name="category"
                class="w-full border rounded px-3 py-2 @error('category') border-red-500 @enderror"
                required>
                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih Kategori</option>
                <option value="tiket" {{ old('category') === 'tiket' ? 'selected' : '' }}>Tiket</option>
                <option value="parkir" {{ old('category') === 'parkir' ? 'selected' : '' }}>Parkir</option>
            </select>
            @error('category')
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

@push('scripts')
<script src="https://cdn.tiny.cloud/1/kpp26jmqwgc3jwyaal4x0hord83c38xbqbn4zqqrgu2z33jf/tinymce/6/tinymce.min.js" crossorigin="anonymous"></script>
<script>
    tinymce.init({
        selector: 'textarea[name=description]',
        plugins: 'link image media table code lists',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | code',
        menubar: false,
        setup: function (editor) {
            editor.on('change blur', function () {
                editor.save();
            });
        }
    });
</script>
@endpush
