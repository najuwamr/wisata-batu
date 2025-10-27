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

<div class="md:ml-64 min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="sticky top-0 bg-white/80 backdrop-blur-md shadow-sm z-10 px-6 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">
                    {{ $isEdit ? 'Edit Promo' : 'Tambah Promo' }}
                </h1>
                <p class="text-gray-600 text-sm">
                    {{ $isEdit ? 'Perbarui informasi promo' : 'Lengkapi form untuk menambahkan promo baru' }}
                </p>
            </div>
        </div>
    </div>

    <div class="px-6 py-6">
        <form method="POST"
              action="{{ $isEdit ? route('admin.promo.update', $promo->id) : route('admin.promo.insert') }}"
              enctype="multipart/form-data"
              x-data="promoForm()">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-6 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></div>
                            Informasi Dasar
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kategori Promo <span class="text-red-500">*</span>
                                </label>
                                <select name="category"
                                        x-model="category"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white"
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="periodik">Periodik</option>
                                    <option value="nonperiodik">Nonperiodik</option>
                                </select>
                                @error('category')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Promo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name"
                                    value="{{ old('name', $promo->name ?? '') }}"
                                    required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Contoh: Promo Akhir Tahun">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kode Promo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="code"
                                    value="{{ old('code', $promo->code ?? '') }}"
                                    required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 uppercase focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="PROMO123">
                                @error('code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Diskon (%) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="discount_percent" min="1" max="100"
                                        value="{{ old('discount_percent', $promo->discount_percent ?? '') }}"
                                        required
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="20">
                                    @error('discount_percent')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Maksimum Diskon (Rp)
                                    </label>
                                    <input type="number" name="max_discount_amount"
                                        value="{{ old('max_discount_amount', $promo->max_discount_amount ?? '') }}"
                                        x-bind:disabled="category === 'periodik'"
                                        x-bind:class="category === 'periodik' ? 'bg-gray-100 cursor-not-allowed' : ''"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="Opsional">
                                    @error('max_discount_amount')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mulai</label>
                                    <input type="date" name="start_date"
                                        value="{{ old('start_date', $promo->start_date ?? '') }}"
                                        required
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    @error('start_date')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Berakhir</label>
                                    <input type="date" name="end_date"
                                        value="{{ old('end_date', $promo->end_date ?? '') }}"
                                        required
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    @error('end_date')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div x-show="category === 'nonperiodik'" x-transition>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kuota Promo (Nonperiodik)
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <input type="number" name="total_qty" min="1"
                                            value="{{ old('total_qty', $promo->total_qty ?? '') }}"
                                            x-bind:required="category === 'nonperiodik'"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            placeholder="Total Qty">
                                        @error('total_qty')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <input type="number" name="daily_qty" min="1"
                                            value="{{ old('daily_qty', $promo->daily_qty ?? '') }}"
                                            x-bind:required="category === 'nonperiodik'"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            placeholder="Per Hari">
                                        @error('daily_qty')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-6 bg-gradient-to-b from-green-500 to-emerald-600 rounded-full"></div>
                            Tiket Terkait Promo
                        </h2>

                        <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-64 overflow-y-auto">
                            <div class="space-y-2">
                                @foreach($tickets as $item)
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg hover:bg-blue-50 cursor-pointer transition-all border border-transparent hover:border-blue-200">
                                        <input type="checkbox" name="tickets[]" value="{{ $item->id }}"
                                            {{ in_array($item->id, $selectedTiket) ? 'checked' : '' }}
                                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                        <span class="text-gray-700 font-medium">{{ $item->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @error('tickets')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-6 bg-gradient-to-b from-purple-500 to-pink-600 rounded-full"></div>
                            Gambar Promo
                        </h2>

                        <div id="preview" class="mb-4 {{ isset($promo->image) ? '' : 'hidden' }}">
                            <img id="previewImg"
                                src="{{ isset($promo->image) ? asset('images/' . $promo->image) : '' }}"
                                class="w-full h-64 object-cover rounded-xl border-2 border-gray-200">
                        </div>

                        <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 hover:border-blue-500 transition-all bg-gray-50 text-center">
                            <input type="file" name="image" id="image"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                accept="image/jpeg,image/jpg,image/png">
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
                                {{ $isEdit ? 'Perbarui Promo' : 'Simpan Promo' }}
                            </button>

                            <a href="{{ route('admin.promo.get') }}"
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
function promoForm() {
    return {
        category: '{{ old('category', $promo->category ?? '') }}' || 'periodik',
        init() {
            const imageInput = document.getElementById('image');
            if (imageInput) {
                imageInput.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const preview = document.getElementById('preview');
                            const img = document.getElementById('previewImg');
                            img.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        }
    }
}
</script>
@endsection
