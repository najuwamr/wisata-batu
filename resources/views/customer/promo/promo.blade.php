@extends('layouts.guest')

@section('title', '| Daftar Promo')

@section('content')
    <section class="py-12 md:py-20 bg-gradient-to-b from-blue-50 via-green-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="text-center mb-16">

                <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-br from-blue-500 to-blue-400 tracking-tight mb-4">
                    Promo & Penawaran Spesial
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Nikmati berbagai diskon dan penawaran menarik yang sedang berlangsung. Jangan lewatkan kesempatan berhemat!
                </p>
            </div>

            <!-- Promo Counter -->
            @if($promoAktif->count() > 0)
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <span class="text-lg font-semibold text-gray-700">
                        Menampilkan <span class="text-red-600 font-bold">{{ $promoAktif->count() }}</span> promo aktif
                    </span>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Semua promo sedang aktif
                </div>
            </div>
            @endif

            <!-- Promo Grid -->
            @if($promoAktif->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($promoAktif as $promo)
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden border border-gray-100">
                            <!-- Promo Image -->
                            <div class="relative overflow-hidden">
                                <img
                                    src="{{ $promo->image ? asset('images/' . $promo->image) : asset('assets/customer/default-promo.jpg') }}"
                                    alt="{{ $promo->name }}"
                                    class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110"
                                    onerror="this.src='{{ asset('assets/customer/default-promo.jpg') }}'"
                                >

                                <!-- Discount Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white font-bold text-sm shadow-lg transform rotate-3 animate-pulse">
                                        {{ $promo->discount_percent }}% OFF
                                    </span>
                                </div>

                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                <!-- Time Remaining -->
                                @php
                                    $daysRemaining = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($promo->valid_until), false);
                                @endphp

                            </div>

                            <!-- Promo Content -->
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="text-xl font-bold text-gray-900 line-clamp-2 group-hover:text-red-600 transition-colors duration-300 flex-1 mr-2">
                                        {{ $promo->name }}
                                    </h3>
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transform group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </div>
                                </div>

                                <p class="text-gray-600 text-sm mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Berlaku hingga: {{ \Carbon\Carbon::parse($promo->valid_until)->translatedFormat('d F Y') }}
                                </p>

                                <!-- Promo Code Preview -->
                                <div class="bg-gray-50 rounded-lg p-3 mb-4 border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 font-medium">Kode Promo:</span>
                                        <span class="font-mono text-sm font-bold text-red-600 bg-white px-2 py-1 rounded border border-red-200">
                                            {{ $promo->code }}
                                        </span>
                                    </div>
                                </div>

                                <!-- CTA Button -->
                                <div class="mt-4">
                                    <a href="{{ route('promo.show', $promo->id) }}"
                                       class="block w-full text-center px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white font-semibold rounded-lg hover:from-blue-500 hover:to-blue-700 transition-all transform group-hover:scale-105 shadow-md hover:shadow-lg">
                                        Lihat Detail Promo
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-2xl p-12 shadow-lg text-center border border-gray-100">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Promo Saat Ini</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Maaf, saat ini belum ada promo atau penawaran spesial yang tersedia.
                            Silakan cek kembali nanti untuk mendapatkan penawaran menarik.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="/"
                               class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Kembali ke Beranda
                            </a>
                            <button onclick="window.location.reload()"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors border border-gray-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh Halaman
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Additional Info Section -->
            @if($promoAktif->count() > 0)
            <div class="mt-16 bg-gradient-to-r from-blue-50 to-green-50 rounded-2xl p-8 border border-blue-100">
                <div class="text-center max-w-3xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Tips Menggunakan Promo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Salin Kode Promo</h4>
                            <p class="text-sm text-gray-600">Salin kode promo sebelum melakukan pembayaran</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Tempel Saat Checkout</h4>
                            <p class="text-sm text-gray-600">Tempel kode di kolom promo saat checkout</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Dapatkan Diskon</h4>
                            <p class="text-sm text-gray-600">Nikmati diskon yang berlaku sesuai syarat & ketentuan</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </section>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
