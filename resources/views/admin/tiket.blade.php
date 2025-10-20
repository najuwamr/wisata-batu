@extends('layouts.admin')

@section('title', '| Manajemen Tiket')

@section('content')
<div class="md:ml-64 min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ 
    showNonAktif: false,
    showDetailModal: false,
    showEditModal: false,
    showDeleteModal: false,
    showTambahModal: false,
    selectedTicket: null
}">
    <!-- Header Section -->
    <div class="sticky top-0 bg-white z-20 shadow-sm border-b border-gray-200">
        <div class="px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Kolom kiri: tanggal + sapaan -->
            <div class="flex flex-col text-left min-w-[250px]">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
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
            <div class="text-center md:text-right flex-1">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-red-600 to-blue-600 bg-clip-text text-transparent">
                    Manajemen Tiket
                </h1>
                <p class="text-gray-600 mt-1 text-sm">Kelola tiket wisata Taman Selecta</p>
            </div>

            <!-- Kolom kanan: tombol -->
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.promo.get') }}" 
                class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Promo
                </a>
                <button @click="showTambahModal = true"
                        class="flex items-center gap-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Tiket
                </button>
            </div>
        </div>
        <div class="w-full h-1 bg-gradient-to-r from-red-500 via-purple-500 to-blue-500"></div>
    </div>

    <!-- Main Content -->
    <div class="p-6">
        <!-- Search Bar -->
        <div class="mb-8">
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari tiket berdasarkan nama..." 
                       class="block w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            </div>
        </div>

        <!-- Active Tickets Section -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-8 bg-gradient-to-b from-red-500 to-blue-500 rounded-full"></div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Tiket Aktif</h2>
                        <p class="text-sm text-gray-500">Tiket yang sedang tersedia untuk dijual</p>
                    </div>
                </div>
                <span class="bg-gradient-to-r from-red-100 to-blue-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">
                    {{ $tiketAktif->count() }} Tiket
                </span>
            </div>

            @if($tiketAktif->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($tiketAktif as $tiket)
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group border border-gray-100">
                            <!-- Image -->
                            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                <img src="{{ asset('images/' . $tiket->image) }}" 
                                     alt="{{ $tiket->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-3 right-3">
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                        Aktif
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <div class="mb-3">
                                    <h3 class="text-lg font-bold text-gray-800 mb-1 line-clamp-1">{{ $tiket->name }}</h3>
                                    <p class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($tiket->description, 30) }}</p>
                                </div>

                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Harga</p>
                                        <p class="text-xl font-bold bg-gradient-to-r from-red-600 to-blue-600 bg-clip-text text-transparent">
                                            Rp {{ number_format($tiket->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 mb-1">Kategori</p>
                                        <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-xs font-semibold">
                                            {{ ucfirst($tiket->category) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('admin.tiket.edit', $tiket->id) }}"
                                    class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded-lg text-sm font-medium flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.tiket.edit', $tiket->id) }}"
                                    class="flex-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 px-3 py-2 rounded-lg text-sm font-medium flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                                                    a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    {{-- Hapus (soft delete) --}}
                                    <form action="{{ route('admin.tiket.delete', $tiket->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit"
                                                class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg text-sm font-medium flex items-center justify-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0
                                                        01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1
                                                        0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-200">
                    <div class="max-w-md mx-auto">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Tiket Aktif</h3>
                        <p class="text-gray-500 mb-6">Mulai tambahkan tiket pertama untuk ditampilkan kepada pengunjung</p>
                        <button @click="showTambahModal = true"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-red-500 to-blue-500 hover:from-red-600 hover:to-blue-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Tiket Sekarang
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Inactive Tickets Section -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-8 bg-gray-400 rounded-full"></div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Tiket Nonaktif</h2>
                        <p class="text-sm text-gray-500">Tiket yang dinonaktifkan sementara</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-semibold">
                        {{ $tiketNonAktif->count() }} Tiket
                    </span>
                    <button @click="showNonAktif = !showNonAktif"
                            class="flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200 px-4 py-2 rounded-lg hover:bg-gray-100">
                        <span x-text="showNonAktif ? 'Sembunyikan' : 'Tampilkan'"></span>
                        <svg class="w-5 h-5 transition-transform duration-300" 
                             :class="{ 'rotate-180': showNonAktif }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="showNonAktif" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-cloak>
                @if($tiketNonAktif->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($tiketNonAktif as $tiket)
                            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 opacity-75">
                                <!-- Image with Overlay -->
                                <div class="relative h-48 overflow-hidden bg-gray-200">
                                    <img src="{{ asset('images/' . $tiket->image) }}" 
                                         alt="{{ $tiket->name }}"
                                         class="w-full h-full object-cover grayscale">
                                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                        <span class="bg-gray-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                            Nonaktif
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-5">
                                    <div class="mb-3">
                                        <h3 class="text-lg font-bold text-gray-600 mb-1 line-clamp-1">{{ $tiket->name }}</h3>
                                        <p class="text-sm text-gray-400 line-clamp-2">{{ Str::limit($tiket->description, 60) }}</p>
                                    </div>

                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <p class="text-xs text-gray-400 mb-1">Harga</p>
                                            <p class="text-xl font-bold text-gray-500">
                                                Rp {{ number_format($tiket->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-gray-400 mb-1">Kategori</p>
                                            <span class="inline-block bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                                {{ ucfirst($tiket->category) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Restore Button -->
                                    <form action="{{ route('admin.tiket.restore', $tiket->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Aktifkan Kembali
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">Semua tiket dalam kondisi aktif</p>
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