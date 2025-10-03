@extends('layouts.guest')

@section('title', 'Daftar Tiket Selecta')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br  pt-32 pb-28">
    {{-- Background Image --}}
    <div class="absolute inset-0">
        <img src="{{ asset('assets/customer/hortensia.jpeg') }}"
             alt="Tiket Selecta"
             class="w-full h-full object-cover brightness-75">
        <div class="absolute inset-0 bg-black/30"></div>
    </div>

    {{-- Content --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight drop-shadow-lg">
            Pilihan <span class="text-yellow-300">Tiket</span>
        </h1>
        <p class="text-lg md:text-2xl text-blue-100 max-w-3xl mx-auto mb-10 leading-relaxed">
            Nikmati pengalaman tak terlupakan dengan tiket pilihan terbaik di <span class="font-semibold text-blue-500">Selecta</span>
        </p>

        {{-- Highlight Features --}}
        <div class="flex flex-wrap justify-center gap-6 text-blue-100 text-base md:text-lg font-medium">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                <span>Harga Terjangkau</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                <span>Instant Confirm</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                <span>Bisa Refund</span>
            </div>
        </div>
    </div>
</section>


<!-- Tickets Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Pilihan <span class="text-blue-600">Tiket Masuk</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Temukan tiket yang sesuai dengan kebutuhan Anda untuk pengalaman terbaik di Selecta
            </p>
        </div>

        <!-- Tickets Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" id="tickets-container">
            @forelse($tiket as $ticket)
                <div class="ticket-card bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-3">
                    <!-- Image Section -->
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/' . $ticket->image) }}" alt="{{ $ticket->name }}"
                            class="w-full h-64 object-cover transition-transform duration-700 hover:scale-110">

                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                        <!-- Price Badge -->
                        <div class="absolute top-6 right-6 bg-white/95 backdrop-blur-sm rounded-2xl px-4 py-3 shadow-2xl">
                            <span class="text-2xl font-bold text-blue-600">
                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Category Badge -->
                        <div class="absolute top-6 left-6">
                            <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                Tiket Masuk
                            </span>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-8">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 leading-tight">
                            {{ $ticket->name }}
                        </h3>



                        <!-- Features -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Instant Confirm</p>
                                    <p class="text-sm text-gray-500">Konfirmasi langsung</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Bisa Refund</p>
                                    <p class="text-sm text-gray-500">Syarat berlaku</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">7 Hari</p>
                                    <p class="text-sm text-gray-500">Masa berlaku</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Semua Usia</p>
                                    <p class="text-sm text-gray-500">Dewasa & Anak</p>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div class="flex gap-4">
                            <a href="{{ route('guest.tiket.detail', $ticket->id) }}"
                               class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-lg font-bold py-4 px-6 rounded-2xl text-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl flex items-center justify-center gap-3">
                                <span>Pilih Tiket</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>

                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="bg-white rounded-3xl shadow-2xl p-16 text-center">
                        <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-700 mb-4">Belum Ada Tiket Tersedia</h3>
                        <p class="text-xl text-gray-500 mb-8 max-w-md mx-auto">
                            Saat ini belum ada tiket yang tersedia. Silakan kembali lagi nanti untuk melihat tiket terbaru.
                        </p>
                        <a href="/"
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-lg font-bold rounded-2xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Pertanyaan <span class="text-blue-600">Umum</span>
            </h2>
            <p class="text-xl text-gray-600">Informasi penting seputar tiket Selecta</p>
        </div>

        <div class="space-y-6">
            @foreach([
                [
                    'question' => 'Bagaimana cara membeli tiket?',
                    'answer' => 'Anda dapat membeli tiket secara online melalui website ini atau langsung di lokasi. Pembelian online disarankan untuk menghindari antrian.'
                ],
                [
                    'question' => 'Apakah tiket bisa refund?',
                    'answer' => 'Tiket dapat direfund dengan syarat dan ketentuan tertentu. Silakan hubungi customer service untuk informasi lebih lanjut.'
                ],
                [
                    'question' => 'Berapa lama tiket berlaku?',
                    'answer' => 'Tiket berlaku untuk satu hari kunjungan pada tanggal yang dipilih.'
                ]
            ] as $faq)
            <div class="bg-gradient-to-r from-gray-50 to-white rounded-3xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $faq['question'] }}</h3>
                <p class="text-lg text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>



@endsection
