@extends('layouts.guest')

@section('title', '| Taman Rekreasi, Hotel, & Resto')

@section('content')

<section class="bg-red-50 py-16 px-4 sm:px-6 md:px-12 rounded-b-[2rem] relative  min-h-screen">

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center justify-center pt-10">

            <!-- Kolom Kiri: Swiper Card Promo -->
            <div class="w-full">
                <div class="swiper mySwiperPromo">
                    <div class="swiper-wrapper">
                        @foreach ($promoAktif as $item)
                            <div class="swiper-slide flex justify-center">
                                <div
                                    class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 duration-500 w-full max-w-lg">
                                    <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->name }}"
                                        class="w-full h-56 sm:h-64 md:h-72 object-cover" />
                                    <div class="p-4 sm:p-6">
                                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $item->name }}</h3>
                                        <p class="text-gray-600 mt-2 text-sm sm:text-base">{{ $item->description }}</p>
                                        <p class="text-base sm:text-lg font-semibold text-red-500 mt-4">
                                            Diskon {{ $item->discount_percent }}% • Berlaku sampai
                                            {{ \Carbon\Carbon::parse($item->valid_until)->translatedFormat('d F Y') }}
                                        </p>
                                        <a href=""
                                            class="mt-4 inline-block px-4 sm:px-5 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg shadow hover:from-red-600 hover:to-red-700 transition text-sm sm:text-base">Lihat
                                            SnK</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Text & Navigasi -->
            <div class="flex flex-col justify-center text-center lg:text-left">
                <h2
                    class="text-4xl sm:text-5xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600 leading-tight mb-4 sm:mb-6">
                    Promo <span
                        class="text-transparent bg-clip-text bg-gradient-to-br from-red-400 via-amber-400 to-red-600">
                        Selecta 🔥
                    </span>
                </h2>
                <p class="text-gray-600 text-base sm:text-lg mb-6 sm:mb-8 max-w-md mx-auto lg:mx-0">
                    Pilih promo terbaik untuk liburanmu! Nikmati diskon menarik dan penawaran spesial dari Selecta.
                </p>

                <!-- Tombol Lihat Promo -->
                <a href="{{route('customer.get.promo')}}"
                    class="w-2/3 sm:w-1/2 mx-auto lg:mx-0 bg-gradient-to-r from-red-400 to-red-600 text-white font-semibold px-4 sm:px-6 py-3 rounded-lg shadow-md hover:from-blue-500 hover:to-blue-700 transition flex justify-center items-center gap-2 sm:gap-3 text-sm sm:text-base">
                    Lihat Promo Lainnya
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="text-white">
                            <g fill="none" stroke="currentColor">
                                <path stroke-width="2.5"
                                    d="M10.51 3.665a2 2 0 0 1 2.98 0l.7.782a2 2 0 0 0 1.601.663l1.05-.058a2 2 0 0 1 2.107 2.108l-.058 1.049a2 2 0 0 0 .663 1.6l.782.7a2 2 0 0 1 0 2.981l-.782.7a2 2 0 0 0-.663 1.601l.058 1.05a2 2 0 0 1-2.108 2.107l-1.049-.058a2 2 0 0 0-1.6.663l-.7.782a2 2 0 0 1-2.981 0l-.7-.782a2 2 0 0 0-1.601-.663l-1.05.058a2 2 0 0 1-2.107-2.108l.058-1.049a2 2 0 0 0-.663-1.6l-.782-.7a2 2 0 0 1 0-2.981l.782-.7a2 2 0 0 0 .663-1.601l-.058-1.05A2 2 0 0 1 7.16 5.053l1.049.058a2 2 0 0 0 1.6-.663l.7-.782Z" />
                                <path stroke-linejoin="round" stroke-width="3.75"
                                    d="M9.5 9.5h.01v.01H9.5zm5 5h.01v.01h-.01z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m15 9l-6 6" />
                            </g>
                        </svg>
                    </span>
                </a>

                <!-- Tombol Navigasi -->
                <div class="flex justify-center lg:justify-start space-x-4 mt-6">
                    <button
                        class="swiper-button-prev-promo w-10 sm:w-12 h-10 sm:h-12 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 sm:w-5 h-4 sm:h-5 text-gray-800"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        class="swiper-button-next-promo w-10 sm:w-12 h-10 sm:h-12 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 sm:w-5 h-4 sm:h-5 text-gray-800"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

@endsection



