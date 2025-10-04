@extends('layouts.guest')

@section('title', 'Detail Tiket - ' . $ticket->name)

@section('content')
<section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="/" class="text-blue-600 hover:text-blue-800 transition-colors">
                            Beranda
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('guest.tiket') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                            Tiket
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-600 font-medium truncate max-w-xs">
                            {{ Str::limit($ticket->name, 30) }}
                        </span>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Image & Basic Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Image -->
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/' . $ticket->image) }}"
                             alt="{{ $ticket->name }}"
                             class="w-full h-80 object-cover transition-transform duration-700 group-hover:scale-105">

                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>

                        <!-- Price Badge -->
                        <div class="absolute top-6 right-6">
                            <div class="bg-white/95 backdrop-blur-sm rounded-2xl px-6 py-4 shadow-2xl transform hover:scale-105 transition-transform duration-300">
                                <span class="text-3xl font-bold text-blue-600">
                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                </span>
                                <p class="text-sm text-gray-500 mt-1">per orang</p>
                            </div>
                        </div>

                        <!-- Category Badge -->
                        <div class="absolute top-6 left-6">
                            <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                Tiket Masuk
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="bg-white rounded-3xl shadow-2xl p-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                        <div class="w-2 h-8 bg-gradient-to-b from-blue-500 to-purple-600 rounded-full"></div>
                        Tentang Tiket Ini
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        {{ $ticket->description }}
                    </p>

                    <!-- Fasilitas -->
                    <div class="mt-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Fasilitas yang Bisa Dinikmati
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(['Kolam Renang', 'Akuarium', 'Taman Lumut', 'Water Park', 'Taman Bunga'] as $fasilitas)
                            <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-blue-50 to-green-50 rounded-xl border border-blue-100">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">{{ $fasilitas }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Booking & Info -->
            <div class="space-y-6">
                <!-- Booking Card -->
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl shadow-2xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-6 text-center">Pesan Sekarang</h3>

                    <!-- Features -->
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Instant Confirmation</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Bisa Refund</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Masa Berlaku 7 Hari</span>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <form action="{{ route('keranjang.tambah') }}" method="POST" class="cursor-pointer w-full bg-white text-blue-600 font-bold py-4 px-6 rounded-2xl hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl flex items-center justify-center gap-3 text-lg">
                        @csrf
                        <input type="hidden" name="ticket_id" value= "{{ $ticket->id }}">
                        <input type="hidden" name="qty" value="1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <button class="cursor-pointer">Pesan Tiket Sekarang</button>
                    </form>

                    <p class="text-center text-blue-100 text-sm mt-4">
                        ✅ Pembayaran aman & terjamin
                    </p>
                </div>

                <!-- Info Card -->
                <div class="bg-white rounded-3xl shadow-2xl p-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-4">Informasi Penting</h4>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-1 flex-shrink-0">
                                <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600">Tiket berlaku untuk 1 hari kunjungan</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-1 flex-shrink-0">
                                <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600">Dapat akses ke semua fasilitas umum</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-1 flex-shrink-0">
                                <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600">Tunjukkan e-tiket di lokasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Tickets -->
        <div class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Lihat Tiket Lainnya</h2>
                <a href="{{ route('guest.tiket') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2 transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Paket Wahana Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-red-500 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white/90 text-orange-600 px-3 py-1 rounded-full text-sm font-bold">Paket Wahana</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Paket Wahana Lengkap</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">Nikmati semua wahana seru dengan paket lengkap yang hemat...</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-orange-600">Rp 75.000</span>
                            <button class="text-orange-600 hover:text-orange-700 font-semibold text-sm flex items-center gap-1 transition-colors">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Outbound Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-blue-500 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white/90 text-green-600 px-3 py-1 rounded-full text-sm font-bold">Outbound</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">OUTBOUND SELECTA</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">Pengalaman outbound seru dengan berbagai aktivitas team building...</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-green-600">Rp 100.000</span>
                            <button class="text-green-600 hover:text-green-700 font-semibold text-sm flex items-center gap-1 transition-colors">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Family Package Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-pink-500 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white/90 text-purple-600 px-3 py-1 rounded-full text-sm font-bold">Keluarga</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Paket Keluarga</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">Special deal untuk keluarga dengan diskon spesial...</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-purple-600">Rp 200.000</span>
                            <button class="text-purple-600 hover:text-purple-700 font-semibold text-sm flex items-center gap-1 transition-colors">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
