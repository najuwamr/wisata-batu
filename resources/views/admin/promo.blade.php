@extends('layouts.admin')

@section('title', '| Manajemen Promo')

@section('content')
<div class="lg:ml-64 min-h-screen bg-gradient-to-br from-gray-50 to-gray-100"
     x-data="{ showNonAktif: false, showDetailModal: false, selectedPromo: null }">

    <!-- Header Section -->
    <div class="sticky top-0 bg-white z-20 shadow-sm border-b border-gray-200">
        <div class="px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Kolom kiri: tanggal + sapaan -->
            <div class="hidden md:flex flex-col text-left min-w-[250px]">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-red-600 to-purple-500 bg-clip-text text-transparent">
                    {{ now()->translatedFormat('l, d F Y') }}
                </h1>
                @php
                    $hour = now()->format('H');
                    if ($hour < 10) $greeting = 'pagi';
                    elseif ($hour < 14) $greeting = 'siang';
                    elseif ($hour < 17) $greeting = 'sore';
                    else $greeting = 'malam';
                @endphp
                <p class="text-gray-600 mt-1">Selamat {{ $greeting }}, Admin Selecta!</p>
            </div>

            <!-- Kolom tengah: judul -->
            <div class="text-right">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-500 to-blue-600 bg-clip-text text-transparent">
                    Manajemen Promo
                </h1>
                <p class="text-gray-600 mt-1 text-sm">Kelola promo Taman Selecta</p>
            </div>
        </div>
        <div class="w-full h-1 bg-gradient-to-r from-red-500 via-purple-500 to-blue-500"></div>
    </div>

    <!-- Main Content -->
    <div class="p-6">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Search Bar -->
            <div class="relative w-full md:max-w-md">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Cari promo berdasarkan nama..."
                    class="block w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            </div>

            <div class="flex flex-row flex-wrap justify-end gap-3 w-full md:w-auto">
                <a href="{{ route('admin.tiket.get') }}"
                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Tiket
                </a>

                <!-- Tombol Tambah -->
                <a href="{{ route('admin.promo.tambah') }}"
                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Promo
                </a>
            </div>
        </div>

        <!-- Promo Aktif -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-8 bg-gradient-to-b from-red-500 to-blue-500 rounded-full"></div>
                    <div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-red-600 to-blue-600 bg-clip-text text-transparent">
                            Promo Aktif
                        </h2>
                        <p class="text-sm text-gray-500">Promo yang sedang berlaku</p>
                    </div>
                </div>
                <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                    {{ $promoAktif->count() }} Promo
                </span>
            </div>

            @if($promoAktif->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($promoAktif as $promo)
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                            <!-- Gambar -->
                            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                <img src="{{ asset('images/' . $promo->image) }}" alt="{{ $promo->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-3 right-3">
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                        Aktif
                                    </span>
                                </div>
                            </div>

                            <!-- Konten -->
                            <div class="p-5">
                                <h3 class="text-lg font-bold bg-gradient-to-r from-red-600 to-blue-600 bg-clip-text text-transparent">
                                    {{ $promo->name }}
                                </h3>
                                <div class="grid grid-cols-2 gap-2 text-sm mb-4">
                                    <div>
                                        <p class="text-gray-500">Kode:</p>
                                        <p class="font-semibold text-blue-600">{{ $promo->code }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-gray-500">Kategori:</p>
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-xs font-semibold">
                                            {{ ucfirst($promo->category) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <!-- Detail -->
                                    <button @click='selectedPromo = @json($promo); showDetailModal = true'
                                            class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded-lg text-sm font-medium flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                                                     9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </button>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.promo.edit', $promo->id) }}"
                                       class="flex-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 px-3 py-2 rounded-lg text-sm font-medium flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0
                                                     002 2h11a2 2 0 002-2v-5m-1.414-9.414
                                                     a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <!-- Nonaktifkan -->
                                    <form action="{{ route('admin.promo.delete', $promo->id) }}" method="POST" class="flex-1"
                                          onsubmit="return confirm('Yakin ingin menonaktifkan promo ini?');">
                                        @csrf
                                        <button type="submit"
                                                class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg text-sm font-medium flex items-center justify-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0
                                                         0116.138 21H7.862a2 2 0
                                                         01-1.995-1.858L5 7m5 4v6m4-6v6"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Modal Detail -->
                <div x-show="showDetailModal" x-cloak
                    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4"
                    x-transition>
                    <div class="bg-white border border-blue-100 rounded-2xl shadow-xl max-w-lg w-full overflow-hidden relative">

                        <!-- Gambar Header -->
                        <div class="relative">
                            <img :src="'/images/' + selectedPromo.image" class="w-full h-56 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent"></div>

                            <button @click="showDetailModal = false"
                                class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Konten -->
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2" x-text="selectedPromo.name"></h2>

                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Kode:</p>
                                    <p class="font-semibold text-blue-600" x-text="selectedPromo.code"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Kategori:</p>
                                    <p class="font-semibold text-purple-600" x-text="selectedPromo.category"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Diskon:</p>
                                    <p class="font-semibold text-red-600" x-text="selectedPromo.discount_percent + '%'"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Maks. Diskon:</p>
                                    <p class="font-semibold text-gray-800"
                                        x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedPromo.max_disc_amount)">
                                    </p>
                                </div>

                                <!-- Tanggal wajib untuk semua kategori -->
                                <div>
                                    <p class="text-gray-500">Tanggal Mulai:</p>
                                    <p class="font-semibold"
                                        x-text="new Date(selectedPromo.start_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })">
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Tanggal Berakhir:</p>
                                    <p class="font-semibold"
                                        x-text="new Date(selectedPromo.end_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })">
                                    </p>
                                </div>

                                <!-- Tambahan stok jika kategori nonperiodik -->
                                <template x-if="selectedPromo.category === 'nonperiodik'">
                                    <div class="col-span-2 mt-2 grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-gray-500">Stok Total:</p>
                                            <p class="font-semibold text-gray-800"
                                                x-text="selectedPromo.total_qty ?? '-'">
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Stok Harian:</p>
                                            <p class="font-semibold text-gray-800"
                                                x-text="selectedPromo.daily_qty ?? '-'">
                                            </p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-200">
                    <p class="text-gray-500">Belum ada promo aktif</p>
                </div>
            @endif
        </div>

        <!-- Promo Nonaktif -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-8 bg-gray-400 rounded-full"></div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Promo Nonaktif</h2>
                        <p class="text-sm text-gray-500">Promo yang telah dinonaktifkan</p>
                    </div>
                </div>
                <button @click="showNonAktif = !showNonAktif"
                        class="flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium transition px-4 py-2 rounded-lg hover:bg-gray-100">
                    <span x-text="showNonAktif ? 'Tutup' : 'Buka'"></span>
                    <svg class="w-5 h-5 transition-transform duration-300"
                         :class="{ 'rotate-180': showNonAktif }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <div x-show="showNonAktif" x-transition x-cloak>
                @if($promoNonAktif->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($promoNonAktif as $promo)
                            <div class="bg-white rounded-2xl shadow-md border border-gray-200 opacity-75">
                                <div class="relative h-48 overflow-hidden bg-gray-200">
                                    <img src="{{ asset('images/' . $promo->image) }}" alt="{{ $promo->name }}"
                                         class="w-full h-full object-cover grayscale">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                        <span class="bg-gray-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                            Nonaktif
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-lg font-bold text-gray-600 mb-1">{{ $promo->name }}</h3>
                                    <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-lg">
                                        {{ ucfirst($promo->category) }}
                                    </span>
                                    <form action="{{ route('admin.promo.restore', $promo->id) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-400 hover:bg-green-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold shadow">
                                            Aktifkan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-gray-200">
                        <p class="text-gray-500 font-medium">Semua promo aktif</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>

<script>
// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('[class*="grid"] > div');

            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection
