@extends('layouts.admin')

@section('title', '| Manajemen Promo')

@section('content')
<div class="md:ml-64 min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="sticky top-0 bg-white z-10 shadow-sm">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </h1>
                    @php
                        $hour = now()->format('H');
                        if ($hour < 10) {
                            $greeting = 'pagi';
                        } elseif ($hour < 14) {
                            $greeting = 'siang';
                        } elseif ($hour < 17) {
                            $greeting = 'sore';
                        } else {
                            $greeting = 'malam';
                        }
                    @endphp
                    <p class="text-gray-600 mt-1">Selamat {{ $greeting }}, Admin Selecta! 👋</p>
                </div>
                <a href="{{ route('admin.get.tiket') }}" 
                   class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                    Lihat Tiket
                </a>
            </div>
        </div>
        <div class="w-full h-1 bg-gradient-to-r from-purple-500 to-purple-600"></div>
    </div>

    <!-- Main Content -->
    <div class="p-6">
        <!-- Action Bar -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
            <!-- Search Bar -->
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" 
                       placeholder="Cari promo..." 
                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl bg-white shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 placeholder-gray-500">
            </div>

            <!-- Add Button -->
            <a href="{{ route('admin.tambah.promo') }}" 
               class="flex items-center gap-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Promo
            </a>
        </div>

        <!-- Content Sections -->
        <div class="space-y-8">
            <!-- Active Promos -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                            <span class="w-3 h-8 bg-purple-500 rounded-full"></span>
                            Promo Aktif
                        </h2>
                        <p class="text-gray-600 mt-1">Kelola semua promo yang sedang berjalan</p>
                    </div>
                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $promoAktif->count() }} Promo
                    </span>
                </div>

                @if($promoAktif->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
                        @foreach ($promoAktif as $promo)
                            @include('components.product-card', ['product' => $promo])
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-200">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada promo aktif</h3>
                        <p class="text-gray-600 mb-4">Buat promo menarik untuk pengunjung</p>
                        <a href="{{ route('admin.tambah.promo') }}" 
                           class="inline-flex items-center gap-2 bg-purple-500 hover:bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Promo
                        </a>
                    </div>
                @endif
            </div>

            <!-- Inactive Promos -->
            <div x-data="{ showNonAktif: false }">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                            <span class="w-3 h-8 bg-gray-400 rounded-full"></span>
                            Promo Nonaktif
                        </h2>
                        <p class="text-gray-600 mt-1">Promo yang sudah tidak aktif</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $promoNonAktif->count() }} Promo
                        </span>
                        <button @click="showNonAktif = !showNonAktif"
                                class="flex items-center gap-2 text-purple-600 hover:text-purple-800 font-semibold transition-colors duration-200">
                            <span x-text="showNonAktif ? 'Sembunyikan' : 'Tampilkan'"></span>
                            <svg class="w-4 h-4 transition-transform duration-200" 
                                 :class="{ 'rotate-180': showNonAktif }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div x-show="showNonAktif" x-cloak class="transition-all duration-300">
                    @if($promoNonAktif->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
                            @foreach ($promoNonAktif as $promo)
                                @include('components.product-card', ['product' => $promo])
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-2xl border border-gray-200">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600">Tidak ada promo nonaktif</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection