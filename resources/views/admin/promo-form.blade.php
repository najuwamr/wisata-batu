{{-- resources/views/admin/promo-form.blade.php --}}
@extends('layouts.admin')

@section('title', $isEdit ? '| Edit Promo' : '| Tambah Promo')

@section('content')
@php
    $promo = $promo ?? null;
    $selectedTiket = old('tickets', []);

    if (empty($selectedTiket) && isset($promo) && isset($promo->tickets)) {
        $selectedTiket = $promo->tickets->pluck('id')->toArray();
    }
@endphp

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-red-50 py-8 px-4"
     x-data="{
         category: '{{ old('category', $promo->category ?? '') }}' || 'periodik'
     }">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-red-600 rounded-t-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">
                        {{ $isEdit ? '✏️ Edit Promo' : '➕ Tambah Promo Baru' }}
                    </h1>
                    <p class="text-blue-100">
                        {{ $isEdit ? 'Perbarui informasi promo Anda' : 'Lengkapi form untuk menambahkan promo baru' }}
                    </p>
                </div>
                <a href="{{ route('admin.promo.get') }}"
                   class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl">
                    ← Kembali
                </a>
            </div>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-b-2xl shadow-2xl">
            <form method="POST"
                  action="{{ $isEdit ? route('admin.promo.update', $promo->id) : route('admin.promo.insert') }}"
                  enctype="multipart/form-data"
                  class="p-8 space-y-8">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        🏷️ Kategori Promo <span class="text-red-500">*</span>
                    </label>
                    <select name="category"
                            x-model="category"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-white" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="periodik">🎫 Periodik</option>
                        <option value="nonperiodik">🅿️ Nonperiodik</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-2">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-6">
                        {{-- Nama Promo --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                📝 Nama Promo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name"
                                value="{{ old('name', $promo->name ?? '') }}"
                                required
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                placeholder="Contoh: Promo Akhir Tahun">
                        </div>

                        {{-- Kode Promo --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                🔢 Kode Promo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="code"
                                value="{{ old('code', $promo->code ?? '') }}"
                                required
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 uppercase focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                placeholder="PROMO123">
                        </div>

                        {{-- Diskon & Max Discount --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    💸 Diskon (%) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="discount_percent" min="1" max="100"
                                    value="{{ old('discount_percent', $promo->discount_percent ?? '') }}"
                                    required
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                    placeholder="20">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    💰 Maksimum Diskon (Rp)
                                </label>
                                <input type="number" name="max_discount_amount"
                                    value="{{ old('max_discount_amount', $promo->max_discount_amount ?? '') }}"
                                    x-bind:disabled="category === 'periodik'"
                                    x-bind:class="category === 'periodik' ? 'bg-gray-100 cursor-not-allowed' : ''"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                    placeholder="Opsional">
                            </div>
                        </div>

                        {{-- Total & Harian (hanya nonperiodik) --}}
                        <div x-show="category === 'nonperiodik'" x-transition>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                📦 Kuota Promo (Nonperiodik)
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input type="number" name="total_qty" min="1"
                                        value="{{ old('total_qty', $promo->total_qty ?? '') }}"
                                        x-bind:required="category === 'nonperiodik'"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                        placeholder="Total Qty">
                                </div>
                                <div>
                                    <input type="number" name="daily_qty" min="1"
                                        value="{{ old('daily_qty', $promo->daily_qty ?? '') }}"
                                        x-bind:required="category === 'nonperiodik'"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                        placeholder="Per Hari">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-6">
                        {{-- Tanggal wajib diisi untuk semua --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">📅 Mulai</label>
                                <input type="date" name="start_date"
                                    value="{{ old('start_date', $promo->start_date ?? '') }}"
                                    required
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">⏰ Berakhir</label>
                                <input type="date" name="end_date"
                                    value="{{ old('end_date', $promo->end_date ?? '') }}"
                                    required
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>
                        </div>

                        {{-- Gambar --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">🖼️ Gambar Promo</label>
                            <div id="imagePreviewContainer" class="mb-3 {{ isset($promo->image) ? '' : 'hidden' }}">
                                <img id="imagePreview"
                                     src="{{ isset($promo->image) ? asset('images/' . $promo->image) : '' }}"
                                     alt="Preview"
                                     class="w-full h-48 object-cover rounded-xl border-4 border-blue-100 shadow-lg">
                            </div>
                            <input type="file" name="image" accept="image/jpeg,image/jpg,image/png"
                                   class="w-full border-2 border-dashed border-gray-300 rounded-xl p-4 hover:border-blue-500 transition-all"
                                   onchange="previewImage(event)">
                        </div>

                        {{-- Tiket --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">🎟️ Tiket Terkait Promo</label>
                            <div class="border-2 border-gray-200 rounded-xl bg-gradient-to-br from-blue-50 to-red-50 max-h-64 overflow-y-auto p-4">
                                @foreach($tickets as $item)
                                    <label class="flex items-center space-x-3 p-3 bg-white rounded-lg hover:bg-blue-50 border border-gray-200 hover:border-blue-300 transition-all duration-200">
                                        <input type="checkbox" name="tickets[]" value="{{ $item->id }}"
                                            {{ in_array($item->id, $selectedTiket) ? 'checked' : '' }}
                                            class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                        <span class="text-gray-700 font-medium">{{ $item->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-4 border-t pt-6">
                    <a href="{{ route('admin.promo.get') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold transition-all duration-300 shadow-md">
                        ❌ Batal
                    </a>
                    <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-red-600 hover:from-blue-700 hover:to-red-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition-all duration-300">
                        {{ $isEdit ? '💾 Perbarui Promo' : '✅ Simpan Promo' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const container = document.getElementById('imagePreviewContainer');
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
