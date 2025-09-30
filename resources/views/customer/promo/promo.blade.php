@extends('layouts.guest')

@section('title', '| Promo Menarik Taman Rekreasi')

@section('content')
    <section class="py-16 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- BAGIAN HEADER --}}
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Temukan <span class="text-red-600">Promo Terbaik</span> Hari Ini!
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Nikmati berbagai penawaran spesial untuk membuat liburan Anda lebih hemat dan menyenangkan.
                </p>
            </div>

            {{-- BAGIAN PENCARIAN --}}
            <div class="flex justify-center mb-12">
                <div class="relative w-full max-w-lg">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Cari berdasarkan nama promo..."
                        class="w-full pl-12 pr-4 py-3 rounded-full border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                </div>
            </div>

            {{-- BAGIAN GRID PROMO --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- Perulangan untuk setiap promo, semua kartu dibuat sama --}}
                @forelse ($promoAktif as $promo)
                    <div class="group">
                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden h-full flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                            <div class="relative">
                                {{-- Gunakan gambar default jika tidak ada gambar promo --}}
                                <img src="{{ $promo->image ? asset('images/' . $promo->image) : asset('assets/customer/default-promo.jpg') }}"
                                    alt="{{ $promo->name }}" class="w-full h-full object-cover">
                                <div
                                    class="absolute top-3 right-3 bg-red-600 text-white text-sm font-bold px-3 py-1 rounded-full shadow-md">
                                    Diskon {{ $promo->discount_percent }}%
                                </div>
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="font-bold text-xl text-gray-800 leading-tight">{{ $promo->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Berlaku hingga {{ \Carbon\Carbon::parse($promo->valid_until)->translatedFormat('d F Y') }}
                                </p>
                                <div class="mt-auto pt-4">
                                    <span class="text-sm font-mono bg-gray-100 px-3 py-2 rounded-lg shadow-inner">
                                        KODE: <strong class="font-bold text-red-600">{{ $promo->code }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Tampilan jika tidak ada promo yang tersedia --}}
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                        <div class="bg-white p-8 rounded-2xl shadow-md">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-2xl font-bold text-gray-800">Oops! Belum Ada Promo</h3>
                            <p class="mt-2 text-gray-600">Saat ini belum ada promo yang tersedia. Silakan kembali lagi
                                nanti!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
