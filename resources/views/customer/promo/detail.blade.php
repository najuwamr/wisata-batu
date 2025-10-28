@extends('layouts.guest')

@section('title', '| Detail Promo')

@section('content')
    <section class="py-16 md:py-20 bg-gradient-to-br from-blue-100 to-green-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm ">
                        <li>
                            <a href="/"
                                class="text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600">Beranda</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('guest.promo') }}"
                                class="ml-2 text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600">Promo</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span
                                class="ml-2 text-transparent bg-clip-text bg-gradient-to-br from-green-500 via-green-400 to-blue-400 font-medium truncate max-w-xs">{{ Str::limit($promo->name, 30) }}</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Promo Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <!-- Promo Image with Badge -->
                <div class="relative">
                    <img src="{{ $promo->image ? asset('images/' . $promo->image) : asset('assets/customer/default-promo.jpg') }}"
                        alt="{{ $promo->name }}" class="w-full h-80 object-cover">

                    <!-- Discount Badge -->
                    <div class="absolute top-4 right-4">
                        <span
                            class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-bold rounded-full text-lg shadow-lg">
                            {{ $promo->discount_percent }}% OFF
                        </span>
                    </div>

                    <!-- Time Remaining Badge -->

                </div>

                <!-- Promo Content -->
                <div class="p-8">
                    <div class="flex flex-col md:flex-row md:items-start justify-between mb-6">

                        <!-- Promo Code Section -->
                        <div
                            class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-100 rounded-xl p-5 shadow-sm min-w-[250px]">
                            <p class="text-sm font-medium text-gray-700 mb-2">Gunakan kode promo:</p>
                            <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-red-200">
                                <span
                                    class="font-mono font-bold text-lg text-red-600 tracking-wider">{{ $promo->code }}</span>
                                <button onclick="copyPromoCode('{{ $promo->code }}')"
                                    class="text-red-600 hover:text-red-800 transition-colors ml-2" title="Salin kode">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Klik ikon untuk menyalin kode</p>
                        </div>
                    </div>

                    <!-- Promo Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd" class="text-red-500"
                                        d="M9.765 2.998a3 3 0 0 1 4.47 0l.7.782a1 1 0 0 0 .801.332l1.05-.058a3 3 0 0 1 3.16 3.16l-.058 1.05a1 1 0 0 0 .332.8l.783.7a3 3 0 0 1 0 4.471l-.783.7a1 1 0 0 0-.332.801l.058 1.05a3 3 0 0 1-3.16 3.16l-1.05-.058a1 1 0 0 0-.8.332l-.7.783a3 3 0 0 1-4.471 0l-.7-.783a1 1 0 0 0-.801-.332l-1.05.058a3 3 0 0 1-3.16-3.16l.058-1.05a1 1 0 0 0-.332-.8l-.782-.7a3 3 0 0 1 0-4.471l.782-.7a1 1 0 0 0 .332-.801l-.058-1.05a3 3 0 0 1 3.16-3.16l1.05.058a1 1 0 0 0 .8-.332l.7-.782Zm5.942 5.295a1 1 0 0 1 0 1.414l-6 6a1 1 0 0 1-1.414-1.414l6-6a1 1 0 0 1 1.414 0ZM9.5 8A1.5 1.5 0 0 0 8 9.5v.01a1.5 1.5 0 0 0 1.5 1.5h.01a1.5 1.5 0 0 0 1.5-1.5V9.5A1.5 1.5 0 0 0 9.51 8H9.5Zm5 5a1.5 1.5 0 0 0-1.5 1.5v.01a1.5 1.5 0 0 0 1.5 1.5h.01a1.5 1.5 0 0 0 1.5-1.5v-.01a1.5 1.5 0 0 0-1.5-1.5h-.01Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Diskon</h3>
                                <p class="text-gray-600">Anda akan mendapatkan potongan harga sebesar <span
                                        class="font-bold text-red-600">{{ $promo->discount_percent }}%</span> untuk
                                    transaksi yang memenuhi syarat.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Masa Berlaku</h3>
                                <p class="text-gray-600">Promo ini berlaku hingga <span
                                        class="font-bold">{{ \Carbon\Carbon::parse($promo->valid_until)->translatedFormat('d F Y') }}</span>.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions (if available) -->
                    @if ($promo->terms)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Syarat & Ketentuan</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-600 whitespace-pre-line">{{ $promo->terms }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('guest.promo') }}"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-white text-gray-700 font-semibold border border-gray-300 hover:bg-gray-50 transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Promo
                </a>

                <button onclick="sharePromo()"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                        </path>
                    </svg>
                    Bagikan Promo
                </button>
            </div>
        </div>
    </section>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed bottom-4 right-4 bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-16 opacity-0 transition-all duration-300 z-50">
        <div class="flex items-center">
            <svg id="toast-icon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toast-message"></span>
        </div>
    </div>








@endsection
