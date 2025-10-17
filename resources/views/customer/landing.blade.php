@extends('layouts.guest')

@section('title', '| Taman Rekreasi, Hotel, & Resto')




@section('content')
    <section class="relative md:w-full md:h-screen h-1/2 overflow-hidden">
        <video autoplay muted loop playsinline webkit-playsinline preload="auto"
            class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="{{ asset('assets/customer/vid-profil.mp4') }}" type="video/mp4">
            Browser Anda tidak mendukung video.
        </video>
        <div class="absolute inset-0 bg-black/30 z-10 "></div>
        <div class="relative flex flex-col justify-center items-center h-full z-20">
            <img src="{{ asset('assets/customer/truly6.png') }}" alt="Truly Picnic" class="w-1/2 md:w-1/3 mb-6">
        </div>
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-20 sm:block hidden">
            <svg class="block w-full h-[100px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100"
                preserveAspectRatio="none">
                <path fill="currentColor" class="text-blue-50" d="M0,30 C360,90 1080,-30 1440,60 L1440,100 L0,100Z"></path>
            </svg>
        </div>
    </section>

    <section class="w-full bg-gradient-to-br from-blue-50 to-indigo-50 py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="order-2 lg:order-1" data-aos="fade-right">
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-white shadow-sm border border-blue-100 mb-6">
                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-2 animate-pulse"></span>
                        <span class="text-sm font-medium text-blue-600">Tersedia Sekarang</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Pilihan</span>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-br from-blue-500 to-blue-600 ">Tiket
                            Terbaik</span>
                    </h2>
                    <p class="text-md text-gray-400 max-w-md mb-8 leading-relaxed">
                        Temukan pengalaman tak terlupakan dengan tiket pilihan kami.
                        Pilih yang sesuai dengan kebutuhan Anda dan nikmati momen spesial.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mb-10">
                        <a href="{{ route('guest.tiket') }}"
                            class="group relative inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all hover:from-red-600 hover:to-red-700 transform hover:-translate-y-1">
                            <span>Lihat Semua Tiket</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-2 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <div class="flex items-center gap-6 text-sm text-gray-500">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Harga Terjangkau</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Instant Confirm</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <button
                            class="swiper-button-prev-features group w-14 h-14 bg-white rounded-full items-center justify-center shadow-lg hover:shadow-xl border border-gray-100 transition-all duration-300 hover:bg-blue-50 hover:scale-105 hidden md:flex">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-700 group-hover:text-blue-600 transition-colors" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button
                            class="swiper-button-next-features group w-14 h-14 bg-white rounded-full items-center justify-center shadow-lg hover:shadow-xl border border-gray-100 transition-all duration-300 hover:bg-blue-50 hover:scale-105 hidden md:flex">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-700 group-hover:text-blue-600 transition-colors" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <span class="text-sm text-gray-500 ml-2 hidden md:inline">Geser untuk melihat lebih banyak</span>
                    </div>
                </div>
                <div class="order-1 lg:order-2 relative max-w-8xl" data-aos="fade-left">
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-yellow-100 rounded-full opacity-70 blur-xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-purple-100 rounded-full opacity-60 blur-xl"></div>
                    <div class="relative z-10">
                        <div class="swiper mySwiperFeatures">
                            <div class="swiper-wrapper">
                                @forelse($tiketAktif as $tiket)
                                    <div class="swiper-slide">
                                        <div
                                            class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 h-full flex flex-col transform hover:-translate-y-2 w-full">
                                            <div class="relative overflow-hidden">
                                                <img src="{{ asset('images/' . $tiket->image) }}" alt="{{ $tiket->name }}"
                                                    class="w-full h-[200px] object-cover transition-transform duration-700 group-hover:scale-110">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                </div>
                                                <div
                                                    class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-xl px-3 py-2 shadow-lg">
                                                    <span class="text-lg font-bold text-blue-600">
                                                        Rp {{ number_format($tiket->price, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="p-5 flex flex-col max-w-4xl">
                                                <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                                                    {{ $tiket->name }}</h3>
                                                <a href="{{ route('guest.tiket.detail', $tiket->id) }}"
                                                    class="mt-auto group/btn w-1/2 md:w-1/3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition-all duration-300 shadow-md hover:shadow-lg transform group-hover:scale-105">
                                                    <span>Pilih Tiket</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24"
                                                        class="transition-transform group-hover/btn:translate-x-1">
                                                        <path fill="currentColor"
                                                            d="M9 10a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-1-1Zm12 1a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1a1 1 0 0 1 0 2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1a1 1 0 0 1 0-2Zm-1-1.82a3 3 0 0 0 0 5.64V17H10a1 1 0 0 0-2 0H4v-2.18a3 3 0 0 0 0-5.64V7h4a1 1 0 0 0 2 0h10Z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <div
                                            class="bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100 h-full flex flex-col justify-center items-center">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada tiket tersedia
                                            </h3>
                                            <p class="text-gray-500">Silakan kembali lagi nanti untuk melihat tiket
                                                terbaru.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="flex justify-center mt-6">
                            <div class="swiper-pagination-features flex space-x-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <section
        class="bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden rounded-t-[1rem] md:rounded-t-[2rem] z-0">

        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-16" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    class="fill-white/10"></path>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center relative z-10">
            <div class="w-full">
                <div class="relative">
                    <div class="swiper mySwiperPromo rounded-3xl">
                        <div class="swiper-wrapper">
                            @foreach ($promo as $item)
                                <div class="swiper-slide">
                                    <div
                                        class="bg-white/10 backdrop-blur-lg rounded-3xl p-1 border border-white/20 shadow-2xl h-full">
                                        <div
                                            class="bg-gradient-to-br from-white to-gray-50 rounded-2xl overflow-hidden h-full">
                                            <div class="relative">
                                                <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->name }}"
                                                    class="w-full h-64 sm:h-72 md:h-80 object-cover" />
                                                <div class="absolute top-4 right-4">
                                                    <div
                                                        class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-4 py-2 rounded-full font-bold text-lg shadow-lg animate-pulse">
                                                        {{ $item->discount_percent }}% OFF
                                                    </div>
                                                </div>
                                                <div class="absolute top-4 left-4">
                                                    <div
                                                        class="bg-black/70 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm">
                                                        ⏳ {{ \Carbon\Carbon::parse($item->valid_until)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-6 sm:p-8">
                                                <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3">
                                                    {{ $item->name }}</h3>
                                                <p><strong>Deskripsi:</strong></p>
                                                <div id="detailDeskripsi-{{ $item->id }}">
                                                    {!! $item->description !!}
                                                </div>

                                                <div class="flex items-center justify-between">
                                                    <div class="text-sm text-gray-500">
                                                        Berakhir:
                                                        {{ \Carbon\Carbon::parse($item->valid_until)->translatedFormat('d F Y') }}
                                                    </div>
                                                    <a href="{{ route('promo.show', $item->id) }}"
                                                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center gap-2">
                                                        Lihat Detail
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M13 7l5 5m0 0l-5 5"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($promo->count() === 0)
                                <div class="swiper-slide">
                                    <div
                                        class="bg-white/10 backdrop-blur-lg rounded-3xl p-1 border border-white/20 shadow-2xl h-full">
                                        <div
                                            class="bg-gradient-to-br from-white to-gray-50 rounded-2xl overflow-hidden h-full">
                                            <div class="h-80 flex items-center justify-center">
                                                <div class="text-center">
                                                    <div
                                                        class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-gray-500">Belum ada promo tersedia</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div
                            class="swiper-button-next-promo absolute top-1/2 right-4 transform -translate-y-1/2 z-10 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all duration-300 cursor-pointer">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="swiper-button-prev-promo absolute top-1/2 left-4 transform -translate-y-1/2 z-10 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all duration-300 cursor-pointer">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </div>
                        <div class="swiper-pagination-promo mt-6 flex justify-center space-x-2"></div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-center text-center lg:text-left space-y-6">
                <div
                    class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/20 mx-auto lg:mx-0">
                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                    <span class="text-white font-semibold text-sm">Promo Terbatas</span>
                </div>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight">
                    Promo
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-orange-400 to-red-500">
                        Spesial 🔥
                    </span>
                </h2>
                <p class="text-lg text-white/80 max-w-md mx-auto lg:mx-0 leading-relaxed">
                    Dapatkan penawaran terbaik untuk pengalaman tak terlupakan di Selecta! Diskon menarik menanti Anda.
                </p>
                <div class="flex flex-wrap gap-6 justify-center lg:justify-start">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $promo->count() }}+</div>
                        <div class="text-white/60 text-sm">Promo Aktif</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $promo->max('discount_percent') ?? 0 }}%</div>
                        <div class="text-white/60 text-sm">Diskon Tertinggi</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div class="text-white/60 text-sm">Tersedia</div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('guest.promo') }}"
                        class="group bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl flex items-center justify-center gap-3 text-lg">
                        <span>Lihat Semua Promo</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full overflow-hidden rotate-180">
            <svg class="relative block w-full h-16" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    class="fill-white/10"></path>
            </svg>
        </div>
    </section>

    <section class="relative w-full overflow-hidden rounded-t-[2rem] -mt-7 ">
        <div class="flex flex-col md:flex-row w-full max-w-screen-7xl mx-auto">
            <div class="relative w-full md:w-full flex justify-end items-end">
                <div class="relative w-full">
                    <div class="relative">
                        <img src="{{ asset('assets/customer/awan4.jpg') }}" alt="Background Peta"
                            class="absolute inset-0 w-full h-full object-cover z-0">
                        <div class="absolute inset-0 bg-gradient-to-bl from-black/10 to-transparent z-0">
                        </div>
                        <img src="{{ asset('assets/customer/peta1.png') }}" alt="Peta Wahana Selecta"
                            class="relative w-full h-auto object-cover z-10" loading="lazy">
                    </div>
                    <div class="hidden lg:block">
                        <div class="absolute top-[40%] left-[43%] z-20">
                            <div class="group relative cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 24 24" class="relative z-10">
                                    <path fill="currentCOlor" class="text-blue-400"
                                        d="M13 9h-2V7h2m0 10h-2v-6h2m-1-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2Z" />
                                </svg>
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-in-out origin-bottom bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl p-4 border border-amber-300/50 pointer-events-none group-hover:z-30">
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/95">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Kolam Renang</h3>
                                    <img src="{{ asset('assets/customer/kolamrenang.jpg') }}" alt="Kolam Renang"
                                        class="w-full h-36 object-cover rounded-lg mt-2 shadow-md" loading="lazy">
                                    <p class="mt-3 text-sm text-slate-700">3 kolam renang dengan kedalaman mulai 0.5 meter
                                        hingga 3 meter. Hati-hati ya karena air di sini dingin sekali!</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute top-[38%] left-[50%] z-20">
                            <div class="group relative cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 24 24" class="relative z-10">
                                    <path fill="currentCOlor" class="text-blue-400"
                                        d="M13 9h-2V7h2m0 10h-2v-6h2m-1-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2Z" />
                                </svg>
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-in-out origin-bottom bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl p-4 border border-amber-300/50 pointer-events-none group-hover:z-30">
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/95">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Dinosaurus</h3>
                                    <img src="{{ asset('assets/customer/kolamrenang.jpg') }}" alt="Kolam Renang"
                                        class="w-full h-36 object-cover rounded-lg mt-2 shadow-md" loading="lazy">
                                    <p class="mt-3 text-sm text-slate-700">3 kolam renang dengan kedalaman mulai 0.5 meter
                                        hingga 3 meter. Hati-hati ya karena air di sini dingin sekali!</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute top-[33%] left-[17%] z-20">
                            <div class="group relative cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 24 24" class="relative z-10">
                                    <path fill="currentCOlor" class="text-blue-400"
                                        d="M13 9h-2V7h2m0 10h-2v-6h2m-1-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2Z" />
                                </svg>
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-in-out origin-bottom bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl p-4 border border-amber-300/50 pointer-events-none group-hover:z-30">
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/95">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Sky Bike</h3>
                                    <img src="{{ asset('assets/customer/kolamrenang.jpg') }}" alt="Kolam Renang"
                                        class="w-full h-36 object-cover rounded-lg mt-2 shadow-md" loading="lazy">
                                    <p class="mt-3 text-sm text-slate-700">3 kolam renang dengan kedalaman mulai 0.5 meter
                                        hingga 3 meter. Hati-hati ya karena air di sini dingin sekali!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="w-full md:w-1/2 bg-gradient-to-br from-blue-950 to-blue-950 flex flex-col justify-center text-white p-8 md:p-16 shadow-[2rem] ">
                <div class="text-center md:text-left">
                    <h1
                        class="font-black text-5xl md:text-6xl text-transparent bg-clip-text bg-gradient-to-br from-green-200 via-blue-200 to-lime-200  mb-2">
                        Peta Selecta
                    </h1>
                    <div
                        class="w-full h-1 bg-gradient-to-r from-green-100 via-blue-300 to-blue-600 rounded-full mx-auto md:mx-0 mb-4">
                    </div>
                    <p class="text-lg text-blue-100/80 mt-4 max-w-sm mx-auto md:mx-0">
                        Jelajahi setiap sudut dan temukan semua wahana seru yang kami tawarkan.
                    </p>
                </div>

                <!-- Grid Fasilitas -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-6 w-full mt-8">
                    <!-- Security -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M12 2L4 5v6c0 5.55 3.58 10.74 8 12c4.42-1.26 8-6.45 8-12V5l-8-3zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V13H5V6.3l7-3.11v9.8z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Security</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 17 16">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M11.777 15.974h-6.29s3.013-5.98-1.474-5.98V8.001h11.966s.087 1.217-2.112 2.686c-3.387 2.26-2.09 5.287-2.09 5.287zM8 6h7.979v.979H8zM3.012.009v6.974H7V.009H3.012zM6 3.036H5V1h1v2.036z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Toilet</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M4 22V8a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1h10v-1a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v14h-2v-7a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v7H4zm-2-14l10-6l10 6" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Mushola</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M13 9h-2V7h2m0 10h-2v-6h2m-1-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2Z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Informasi</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Kedai</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M7 2h10v3h3v4h2v2h-1v9h1v2H2v-2h1v-9H2V9h2V5h3V2Zm2 3h6V4H9v1Zm-4 6v9h3v-6h8v6h3v-9H5Zm13-2V7H6v2h12Zm-4 11v-4h-4v4h4Z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Paseban</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48"
                                fill="currentColor" class="text-blue-300">
                                <g fill="none">
                                    <path d="M39 32H13L8 12h36l-5 20Z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="4" d="M3 6h3.5L8 12m0 0l5 20h26l5-20H8Z" />
                                    <circle cx="13" cy="39" r="3" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                                    <circle cx="39" cy="39" r="3" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                                </g>
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Souvenir</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path d="M9 10V8a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2M7 10h14" />
                                    <path
                                        d="M3 22V4a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v2m-4 8h.01M14 14h.01M18 14h.01M9 18h.01M14 18h.01M19 18h.01M8 22h.01M14 22h.01M20 22h.01" />
                                </g>
                            </svg>
                        </div>
                        <span
                            class="text-xs transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Kamar
                            Mandi Air Panas</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 650 800">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M648 256q0 2 1 3t0 3v20q0 10-7 17t-17 7h-46v324q0 10-6 16t-17 7H93q-10 0-17-7t-7-16V306H23q-10 0-16-7t-7-17v-20q0-4 1-6L60 39q5-16 17-25t28-9h439q16 0 28 9t16 25zm-138 50H139v127q0 5 4 8t8 4h347q5 0 9-4t3-8V306z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-amber-300 group-hover:font-medium">Pasar
                            Wisata</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path d="M9 10V8a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2M7 10h14" />
                                    <path
                                        d="M3 22V4a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v2m-4 8h.01M14 14h.01M18 14h.01M9 18h.01M14 18h.01M19 18h.01M8 22h.01M14 22h.01M20 22h.01" />
                                </g>
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Kamar
                            Bilas</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 1024 1024">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M839.2 278.1a32 32 0 0 0-30.4-22.1H736V144c0-17.7-14.3-32-32-32H320c-17.7 0-32 14.3-32 32v112h-72.8a31.9 31.9 0 0 0-30.4 22.1L112 502v378c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V502l-72.8-223.9zM360 184h304v72H360v-72zm480 656H184V513.4L244.3 328h535.4L840 513.4V840zM652 572H544V464c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v108H372c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h108v108c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V636h108c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8z" />
                            </svg>
                        </div>
                        <span
                            class="text-xs transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">P3K
                            & Laktasi</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M18.92 5.01C18.72 4.42 18.16 4 17.5 4h-11c-.66 0-1.21.42-1.42 1.01L3 11v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 15c-.83 0-1.5-.67-1.5-1.5S5.67 12 6.5 12s1.5.67 1.5 1.5S7.33 15 6.5 15zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5s1.5.67 1.5 1.5s-.67 1.5-1.5 1.5zM5 10l1.5-4.5h11L19 10H5z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Parkir</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Resto</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M19 6h-3V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v1H5a3 3 0 0 0-3 3v9a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3Zm-9-1h4v1h-4Zm10 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-5.61L8.68 14A1.19 1.19 0 0 0 9 14h6a1.19 1.19 0 0 0 .32-.05L20 12.39Zm0-7.72L14.84 12H9.16L4 10.28V9a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1Z" />
                            </svg>
                        </div>
                        <span
                            class="text-xs transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Penitipan
                            Barang</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Area
                            Terbuka</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M15.5 14.69h-1.25V7.78a.62.62 0 0 0-.25-.47L8.4 2.7a.65.65 0 0 0-.81 0L2 7.31a.62.62 0 0 0-.22.47v6.91H.5V7.78a1.87 1.87 0 0 1 .68-1.44l5.62-4.6a1.88 1.88 0 0 1 2.39 0l5.63 4.6a1.87 1.87 0 0 1 .68 1.44z" />
                                <path fill="currentColor" class="text-blue-300"
                                    d="M11.05 12.11H9.8A1.72 1.72 0 0 0 8 10.49a1.72 1.72 0 0 0-1.8 1.62H5a3 3 0 0 1 3-2.87a3 3 0 0 1 3.05 2.87zm-6.1 0H6.2v2.58H4.95zm4.85 0h1.25v2.58H9.8z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Gazebo</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M12 3v10.55c-.59-.34-1.27-.55-2-.55c-2.21 0-4 1.79-4 4s1.79 4 4 4s4-1.79 4-4V7h4V3h-6z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Live
                            Music</span>
                    </div>
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Foto</span>
                    </div>
                </div>
                <div class="mt-12 text-center md:text-left">
                    <button
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl active:scale-95">
                        Lihat Peta Lengkap
                    </button>
                </div>
            </div>
        </div>
    </section>


    {{-- Selecta 360 --}}
    <section
        class="bg-gradient-to-bl from-blue-900 via-blue-950 to-slate-950 min-h-screen flex items-center justify-center py-12 font-poppins rounded-t-[2rem] -mt-7 overflow-hidden z-0">

        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-16" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    class="fill-white/10"></path>
            </svg>
        </div>
        <div class="w-full max-w-4xl px-4">
            <div class="text-center mb-10">
                <div class="flex items-center justify-center mb-4">

                    <h1
                        class="text-4xl md:text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-red-600 via-red-500 to-amber-500">
                        Selecta <span
                            class="text-transparent bg-clip-text bg-gradient-to-br from-blue-500 via-blue-600 to-violet-700">
                            360
                        </span>

                    </h1>
                </div>
                <p class="text-slate-500 text-lg md:max-w-1/2 mx-auto">
                    Jelajahi keindahan Selecta dengan pengalaman virtual 360 derajat yang menyenangkan.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-2 mb-8 ring-1 ring-slate-200">
                <div
                    class="image-container w-full h-[400px] md:h-[500px] bg-slate-100 rounded-xl overflow-hidden relative">
                    <div id="loading" class="absolute inset-0 flex items-center justify-center bg-white z-10">
                        <div class="text-center">
                            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-sky-500 mx-auto mb-4"></div>
                            <p class="text-slate-500 tracking-wider">Memuat virtual tour...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-4 text-sm text-slate-600 mb-10">
                <div class=" bg-amber-50 rounded-full px-4 py-2 border border-slate-200">
                    <span>Drag untuk melihat sekitar</span>
                </div>
                <div class=" gap-3 bg-sky-50 rounded-full px-4 py-2 border border-slate-200">
                    <span>Scroll untuk zoom</span>
                </div>
                <div class=" gap-3 bg-violet-50 rounded-full px-4 py-2 border border-slate-200">
                    <span>Otomatis berputar</span>
                </div>
            </div>

            <div class="flex justify-center gap-4 mb-12">
                <button
                    class="bg-white hover:bg-blue-600 hover:text-white  font-bold px-8 py-3 rounded-full transition-all duration-300 transform hover:scale-105 border-2 border-blue-500 flex items-center gap-2 text-blue-500">

                    <span>Lihat 360 Lainnya</span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 24 24">
                        <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M14 12H4m10 0l-4 4m4-4l-4-4m10-4v16" />
                    </svg>
                </button>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div
                    class="bg-white border border-slate-200 rounded-xl p-6 text-center transition-all duration-300 hover:border-sky-400 hover:shadow-lg transform hover:-translate-y-2">
                    <div
                        class="w-12 h-12 bg-sky-100 text-sky-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M12 7C6.48 7 2 9.24 2 12c0 2.24 2.94 4.13 7 4.77v2.02c0 .45.54.67.85.35l2.79-2.79c.2-.2.2-.51 0-.71l-2.79-2.79a.5.5 0 0 0-.85.36v1.52c-3.15-.56-5-1.9-5-2.73c0-1.06 3.04-3 8-3s8 1.94 8 3c0 .66-1.2 1.68-3.32 2.34c-.41.13-.68.51-.68.94c0 .67.65 1.16 1.28.96C20.11 15.36 22 13.79 22 12c0-2.76-4.48-5-10-5z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-lg mb-2">Interaktif 360°</h3>
                    <p class="text-slate-500 text-sm">Jelajahi setiap sudut dengan kebebasan penuh</p>
                </div>

                <div
                    class="bg-white border border-slate-200 rounded-xl p-6 text-center transition-all duration-300 hover:border-violet-400 hover:shadow-lg transform hover:-translate-y-2">
                    <div
                        class="w-12 h-12 bg-violet-100 text-violet-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                            <path fill="currentColor"
                                d="M8 5C6.172 5 4.996 6.074 4.5 7.063c-.2.394-.305.769-.375 1.093C2.906 8.54 2 9.664 2 11v13c0 1.645 1.355 3 3 3h7c1.32 0 2.52-.797 3.063-2h1.874A3.38 3.38 0 0 0 20 27h7c1.645 0 3-1.355 3-3V11c0-1.336-.906-2.46-2.125-2.844a4.5 4.5 0 0 0-.375-1.094C27.004 6.079 25.82 5 24 5zm0 2h16c1.148 0 1.457.422 1.719.938L25.75 8H6.25l.031-.063C6.54 7.426 6.84 7 8 7zm-3 3h22c.566 0 1 .434 1 1v13c0 .566-.434 1-1 1h-7a1.361 1.361 0 0 1-1.25-.844l-1.031-2.75v-.031l-.032-.031a1.871 1.871 0 0 0-1.718-1.157a1.91 1.91 0 0 0-1.75 1.157l-.031.031v.063l-.938 2.718A1.365 1.365 0 0 1 12 25H5c-.566 0-1-.434-1-1V11c0-.566.434-1 1-1zm5 3c-2.2 0-4 1.8-4 4s1.8 4 4 4s4-1.8 4-4s-1.8-4-4-4zm12 0c-2.2 0-4 1.8-4 4s1.8 4 4 4s4-1.8 4-4s-1.8-4-4-4zm-12 2c1.117 0 2 .883 2 2s-.883 2-2 2s-2-.883-2-2s.883-2 2-2zm12 0c1.117 0 2 .883 2 2s-.883 2-2 2s-2-.883-2-2s.883-2 2-2zm-6.031 7.438l.219.562h-.407z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-lg mb-2">Mode VR</h3>
                    <p class="text-slate-500 text-sm">Rasakan pengalaman yang lebih nyata dan imersif</p>
                </div>

                <div
                    class="bg-white border border-slate-200 rounded-xl p-6 text-center transition-all duration-300 hover:border-amber-400 hover:shadow-lg transform hover:-translate-y-2">
                    <div
                        class="w-12 h-12 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5"
                                d="M8.496 4.439L4.247 6.91a1 1 0 0 0-.497.864V18.26a1 1 0 0 0 1.503.865l3.243-1.887a1.5 1.5 0 0 1 1.508 0l3.992 2.322a1.5 1.5 0 0 0 1.508 0l4.249-2.472a1 1 0 0 0 .497-.864V5.739a1 1 0 0 0-1.503-.865l-3.243 1.887a1.5 1.5 0 0 1-1.508 0L10.004 4.44a1.5 1.5 0 0 0-1.508 0Zm.754.311v11.8m5.5-9.1v11.8" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-lg mb-2">Panduan Tur</h3>
                    <p class="text-slate-500 text-sm">Temukan semua spot menarik dengan mudah</p>
                </div>
            </div>

            <div class="bg-sky-50 rounded-full p-5 border border-sky-200">
                <div class="flex items-start gap-4">
                    <i class="fas fa-lightbulb text-sky-500 text-xl mt-1"></i>
                    <div>
                        <p class="text-sky-800 font-semibold mb-1">Tips untuk pengalaman terbaik</p>
                        <p class="text-sky-700/80 text-sm">Gunakan headphone untuk audio yang jernih dan pastikan koneksi
                            internet Anda stabil.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <section
        class="relative bg-gradient-to-br from-[#daf5fe] via-white to-indigo-50 py-16 md:py-24 overflow-hidden md:rounded-t-[2rem] -mt-6">
        <div class="absolute inset-0 overflow-hidden z-0">
            <div
                class="absolute -top-24 -right-24 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse delay-1000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse delay-500">
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-12 lg:mb-16">
                <div class="flex-1 mb-6 lg:mb-0">
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-white text-blue-800 text-sm font-medium mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                        UPDATE TERBARU
                    </div>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-4">
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-green-500 to-blue-500">Berita</span>
                        <span
                            class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600">Selecta!</span>
                    </h1>
                    <div class="w-24 h-1.5 bg-gradient-to-r from-green-400 to-blue-500 rounded-full mb-4"></div>
                    <p class="text-lg text-gray-600 max-w-2xl">
                        Temukan informasi terbaru, promo spesial, dan acara menarik di Taman Rekreasi Selecta. Selalu ada
                        yang baru untuk pengalaman liburan tak terlupakan!
                    </p>
                </div>
                <a href="#"
                    class="group flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform transition-all duration-300 hover:-translate-y-1 hover:scale-105">
                    <span>Lihat Semua Berita</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 group">
                    <div
                        class="bg-white rounded-3xl shadow-lg overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl h-full flex flex-col">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('assets/customer/berita1.webp') }}" alt="Wahana Baru Selecta"
                                class="w-full h-64 md:h-80 object-cover transform group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">BARU!</span>
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                        <div class="p-6 md:p-8 flex flex-col flex-grow">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                2 Hari Lalu
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">"Sekarang Selecta Punya Wahana
                                Baru yang Seru!"</h3>
                            <p class="text-gray-600 mb-6 flex-grow">
                                Rasakan sensasi petualangan baru dengan wahana terbaru kami. Didesain khusus untuk
                                memberikan pengalaman tak terlupakan bagi seluruh keluarga.
                            </p>
                            <div class="flex justify-between items-center">
                                <a href="#"
                                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg hover:shadow-md transform transition-all duration-300 hover:-translate-y-0.5">
                                    Baca Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <div class="flex space-x-2">
                                    <span
                                        class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Wahana</span>
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Baru</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-8">
                    <div class="group">
                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl h-full">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('assets/customer/berita2.webp') }}" alt="Family Time di Selecta"
                                    class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-700">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center text-xs text-gray-500 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    5 Hari Lalu
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">"Taman Cantik Sayang Kalau Tidak
                                    Foto-Foto!"</h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    Jelajahi spot foto terbaik di Selecta yang Instagramable. Dapatkan momen terindah
                                    bersama keluarga.
                                </p>
                                <div class="flex justify-between items-center">
                                    <a href="#"
                                        class="text-blue-600 font-medium text-sm hover:text-blue-800 transition-colors">
                                        Baca Selengkapnya
                                    </a>
                                    <span
                                        class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">Foto</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group">
                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl h-full">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('assets/customer/berita3.jpg') }}" alt="Promo Selecta"
                                    class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-700">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center text-xs text-gray-500 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    1 Minggu Lalu
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">"50K Dapat Apa Saja Sih di Selecta?"</h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    Temukan semua yang bisa Anda nikmati dengan budget terjangkau. Banyak wahana seru dengan
                                    harga hemat.
                                </p>
                                <div class="flex justify-between items-center">
                                    <a href="#"
                                        class="text-blue-600 font-medium text-sm hover:text-blue-800 transition-colors">
                                        Baca Selengkapnya
                                    </a>
                                    <span
                                        class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Promo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-16 text-center">
                <p class="text-gray-600 mb-6">Masih penasaran dengan berita dan promo lainnya?</p>
                <a href="#"
                    class="inline-flex items-center px-8 py-3 border-2 border-blue-600 text-blue-600 font-bold rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:-translate-y-1">
                    Lihat Semua Berita
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <section
        class="bg-gray-50 py-10 md:py-20 px-4 md:px-6 overflow-hidden md:min-h-screen items-center rounded-t-[2rem] md:-mt-10">
        <div class="container mx-auto pt-10">
            <h2 class=" text-4xl md:text-7xl font-poppins font-bold text-center text-transparent bg-clip-text bg-gradient-to-br from-blue-500 to-blue-700 mb-8 md:mb-12 leading-snug"
                data-aos="fade-left">
                Apa kata mereka tentang <span
                    class="text-transparent bg-clip-text bg-gradient-to-br from-green-400 to-[#6ECCFF]">Selecta?</span>
            </h2>
            <div class="swiper mySwiperReview">
                <div class="swiper-wrapper">
                    @foreach ($review as $item)
                        <div class="swiper-slide">
                            <div
                                class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center text-center h-full transition-all hover:scale-105">
                                <img src="{{ $item['image'] }}" alt="{{ $item['user'] }}"
                                    class="w-16 h-16 rounded-full object-cover mb-4">
                                <h3 class="font-semibold text-gray-800">{{ $item['user'] }}</h3>
                                <p class="text-gray-600 text-sm mt-3 leading-relaxed">
                                    "{{ $item['komen'] }}"
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-6"></div>
            </div>
        </div>
    </section>
@endsection
