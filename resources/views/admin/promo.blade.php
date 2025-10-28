@extends('layouts.admin')

@section('title', '| Manajemen Promo')

@section('content')
<div class="md:ml-64 min-h-screen bg-gradient-to-br from-gray-50 to-blue-50" x-data="{ showNonAktif: false }">
    <!-- Header Section -->
    <div class="sticky top-0 bg-white/80 backdrop-blur-md shadow-sm z-10 px-6 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">
                    Manajemen Promo
                </h1>

                @php
                    $hour = now()->format('H');
                    if ($hour < 10) {
                        $greeting = 'pagi';
                        $icon = '🌅';
                    } elseif ($hour < 14) {
                        $greeting = 'siang';
                        $icon = '☀️';
                    } elseif ($hour < 17) {
                        $greeting = 'sore';
                        $icon = '🌤️';
                    } else {
                        $greeting = 'malam';
                        $icon = '🌙';
                    }
                @endphp

                <p class="text-gray-600 flex items-center gap-2">
                    <span>{{ $icon }}</span>
                    <span>Selamat {{ $greeting }}, Admin Selecta!</span>
                    <span class="hidden md:inline text-gray-400">•</span>
                    <span class="hidden md:inline text-sm">{{ now()->translatedFormat('l, d F Y') }}</span>
                </p>
            </div>

            <div class="mt-4 md:mt-0 flex gap-3">
                <a href="{{ route('admin.tiket.get') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    <span class="font-semibold">Kelola Tiket</span>
                </a>

                <a href="{{ route('admin.promo.tambah') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="font-semibold">Tambah Promo</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="px-6 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Promo</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $promoAktif->count() + $promoNonAktif->count() }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Semua promo</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Promo Aktif</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $promoAktif->count() }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Sedang berlaku</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-gray-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Promo Nonaktif</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $promoNonAktif->count() }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Tidak ditampilkan</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-4 mb-6">
            <div class="relative">
                <input type="text"
                    id="searchInput"
                    placeholder="Cari promo berdasarkan nama atau kode..."
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
                </svg>
            </div>
        </div>

        <div class="mb-6">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Promo Aktif</h2>
                        <p class="text-sm text-gray-600">Promo yang sedang berlaku</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold border border-green-200">
                        {{ $promoAktif->count() }} Promo
                    </span>
                </div>

                <div class="p-6">
                    @if($promoAktif->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="activePromos">
                            @foreach ($promoAktif as $promo)
                                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 group promo-card" data-name="{{ strtolower($promo->name . ' ' . $promo->code) }}">
                                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                        <img src="{{ asset('images/' . $promo->image) }}"
                                             alt="{{ $promo->name }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-green-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                                Aktif
                                            </span>
                                        </div>
                                        <div class="absolute bottom-3 left-3 right-3">
                                            <h3 class="text-lg font-bold text-white drop-shadow-lg">{{ $promo->name }}</h3>
                                            <p class="text-sm text-white/90 font-medium">Kode: {{ $promo->code }}</p>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Diskon</p>
                                                <p class="text-xl font-bold text-red-600">
                                                    {{ $promo->discount_percent }}%
                                                </p>
                                            </div>
                                            <span class="bg-purple-100 text-purple-700 px-3 py-1.5 rounded-lg text-xs font-semibold border border-purple-200">
                                                {{ ucfirst($promo->category) }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-3 gap-2">
                                            <button onclick='showPromoDetail(@json($promo))'
                                                class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-2 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:scale-105"
                                                title="Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </button>

                                            <a href="{{ route('admin.promo.edit', $promo->id) }}"
                                                class="bg-yellow-50 hover:bg-yellow-100 text-yellow-600 p-2 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:scale-105"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('admin.promo.delete', $promo->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menonaktifkan promo ini?');">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:scale-105"
                                                    title="Nonaktifkan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Promo Aktif</h3>
                            <p class="text-gray-500 mb-6">Mulai tambahkan promo untuk pelanggan</p>
                            <a href="{{ route('admin.promo.tambah') }}"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Promo Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Promo Nonaktif</h2>
                        <p class="text-sm text-gray-600">Promo yang dinonaktifkan sementara</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-semibold border border-gray-200">
                            {{ $promoNonAktif->count() }} Promo
                        </span>
                        <button @click="showNonAktif = !showNonAktif"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg font-medium transition-all duration-200 shadow-sm border border-gray-200">
                            <span x-text="showNonAktif ? 'Sembunyikan' : 'Tampilkan'"></span>
                            <svg class="w-5 h-5 transition-transform duration-300"
                                 :class="{ 'rotate-180': showNonAktif }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="showNonAktif"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-cloak
                 class="p-6">
                @if($promoNonAktif->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($promoNonAktif as $promo)
                            <div class="bg-gray-50 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-300">
                                <div class="relative h-48 overflow-hidden bg-gray-200">
                                    <img src="{{ asset('images/' . $promo->image) }}"
                                         alt="{{ $promo->name }}"
                                         class="w-full h-full object-cover grayscale opacity-60">
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="bg-gray-700 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                            Nonaktif
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <div class="mb-3">
                                        <h3 class="text-lg font-bold text-gray-700">{{ $promo->name }}</h3>
                                        <span class="inline-block bg-gray-200 text-gray-600 px-3 py-1 rounded-lg text-xs font-semibold mt-2">
                                            {{ ucfirst($promo->category) }}
                                        </span>
                                    </div>

                                    <div class="space-y-2">
                                        <form action="{{ route('admin.promo.restore', $promo->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                                Aktifkan Kembali
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.promo.destroy', $promo->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus promo ini secara permanen? Tindakan ini tidak dapat dibatalkan!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">Semua promo dalam kondisi aktif</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="promoModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <div class="relative h-64">
            <img id="modalImage" src="" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

            <div class="absolute bottom-6 left-6 right-6">
                <h2 id="modalName" class="text-3xl font-bold text-white mb-2"></h2>
                <div class="flex items-center gap-3">
                    <span id="modalCode" class="bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-semibold"></span>
                    <span id="modalCategory" class="bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-semibold"></span>
                </div>
            </div>
        </div>

        <div class="p-6 overflow-y-auto max-h-96">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Diskon</p>
                    <p id="modalDiscount" class="text-2xl font-bold text-red-600"></p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Maks. Diskon</p>
                    <p id="modalMaxDisc" class="text-lg font-bold text-blue-600"></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                <div>
                    <p class="text-gray-500 mb-1">Tanggal Mulai</p>
                    <p id="modalStartDate" class="font-semibold text-gray-800"></p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Tanggal Berakhir</p>
                    <p id="modalEndDate" class="font-semibold text-gray-800"></p>
                </div>
            </div>

            <div id="modalStockInfo" class="hidden">
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="font-bold text-gray-800 mb-3">Informasi Stok</h3>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 mb-1">Total</p>
                            <p id="modalTotalQty" class="font-semibold text-gray-800"></p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Harian</p>
                            <p id="modalDailyQty" class="font-semibold text-gray-800"></p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Terpakai</p>
                            <p id="modalUsedQty" class="font-semibold text-gray-800"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-t border-gray-200 flex justify-end">
            <button onclick="closePromoModal()"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                Tutup
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Filter Pencarian Promo
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const promoCards = document.querySelectorAll('.promo-card');

        promoCards.forEach(card => {
            const name = card.getAttribute('data-name');
            card.style.display = name.includes(searchValue) ? '' : 'none';
        });
    });

    // Fungsi untuk menampilkan modal detail promo
    function showPromoDetail(promo) {
        document.getElementById('promoModal').classList.remove('hidden');
        document.getElementById('promoModal').classList.add('flex');

        // Isi data modal
        document.getElementById('modalImage').src = `/images/${promo.image}`;
        document.getElementById('modalName').textContent = promo.name;
        document.getElementById('modalCode').textContent = `Kode: ${promo.code}`;
        document.getElementById('modalCategory').textContent = `Kategori: ${promo.category}`;
        document.getElementById('modalDiscount').textContent = `${promo.discount_percent}%`;
        document.getElementById('modalMaxDisc').textContent = promo.max_disc_amount
            ? `Rp ${Number(promo.max_disc_amount).toLocaleString('id-ID')}`
            : '-';
        document.getElementById('modalStartDate').textContent = formatDate(promo.start_date);
        document.getElementById('modalEndDate').textContent = formatDate(promo.end_date);

        // Stok promo (kalau ada)
        if (promo.total_qty || promo.daily_qty || promo.used_qty) {
            document.getElementById('modalStockInfo').classList.remove('hidden');
            document.getElementById('modalTotalQty').textContent = promo.total_qty ?? '-';
            document.getElementById('modalDailyQty').textContent = promo.daily_qty ?? '-';
            document.getElementById('modalUsedQty').textContent = promo.used_qty ?? '-';
        } else {
            document.getElementById('modalStockInfo').classList.add('hidden');
        }
    }

    // Fungsi menutup modal
    function closePromoModal() {
        document.getElementById('promoModal').classList.add('hidden');
        document.getElementById('promoModal').classList.remove('flex');
    }

    // Fungsi bantu format tanggal ke format Indonesia
    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        return date.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }
</script>
@endpush
