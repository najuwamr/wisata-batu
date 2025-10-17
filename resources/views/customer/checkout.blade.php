@extends('layouts.guest')

@section('title', 'Checkout')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-teal-50 to-sky-50 py-8">
        <div class="max-w-4xl mx-auto px-4">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="/"
                            class="text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600 hover:text-blue-700">Beranda</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('guest.tiket') }}"
                            class="ml-2 text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600 hover:text-blue-700">Tiket</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('keranjang') }}"
                            class="ml-2 text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600 hover:text-blue-700">Keranjang</a>

                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span
                            class="ml-2 text-transparent bg-clip-text bg-gradient-to-br from-green-500 via-green-400 to-blue-400 font-medium truncate max-w-xs">Checkout</span>
                    </li>
                </ol>
            </nav>
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-blue-900 mb-2">Checkout</h1>
                <p class="text-gray-600">Lengkapi data diri Anda untuk melanjutkan pemesanan</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Form Data Diri -->
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                    <h2 class="text-xl font-bold text-blue-900 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Mengisi data diri
                    </h2>

                    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Input hidden untuk data yang diperlukan -->
                        <input type="hidden" name="total" value="{{ $total }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="promo" value="{{ $promoCode ?? '' }}">

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Masukkan nama lengkap" value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                Email
                            </label>
                            <input type="email" name="email" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Masukkan alamat email" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No. WhatsApp -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                    </path>
                                </svg>
                                Nomor WhatsApp
                            </label>
                            <input type="text" name="whatsapp" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Contoh: 08123456789" value="{{ old('whatsapp') }}">
                            @error('whatsapp')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Garis Pemisah -->
                        <div class="border-t border-gray-200 my-6"></div>

                        <!-- Tanggal Kedatangan -->
                        <div class="bg-blue-50 rounded-xl p-4">
                            <p class="text-sm text-blue-800 font-medium">
                                <strong>Tanggal Kedatangan:</strong>
                                {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                            </p>
                        </div>

                        <!-- Informasi Penting -->
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    class="text-yellow-600 mt-0.5 flex-shrink-0">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                <p class="text-sm text-yellow-800">
                                    Pastikan data diri yang Anda isi sudah benar. Tiket yang sudah dibeli tidak dapat
                                    dikembalikan.
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-6 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-lg mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                            </svg>
                            Lanjutkan Pembayaran
                        </button>
                    </form>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                    <h2 class="text-xl font-bold text-blue-900 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        Pesanan Anda
                    </h2>

                    <!-- Tanggal -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                        <p class="text-lg font-semibold text-gray-800 text-center">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <!-- Daftar Item -->
                    <div class="space-y-4 mb-6">
                        @foreach ($cart as $item)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $item['name'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $item['qty'] }}x</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                                    @if (!empty($item['discount']) && $item['discount'] > 0)
                                        <p class="text-sm text-green-600">-Rp
                                            {{ number_format($item['discount'], 0, ',', '.') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Ringkasan Biaya -->
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 space-y-2">
                        <!-- Subtotal -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 font-semibold">Subtotal</span>
                            <span class="text-gray-700 font-semibold">Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <!-- Biaya Layanan -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 font-semibold">Biaya Layanan</span>
                            <span class="text-gray-700 font-semibold">Rp {{ number_format($layanan, 0, ',', '.') }}</span>
                        </div>

                        <!-- Diskon Promo (dinamis) -->
                        @if (!empty($promos) && count($promos) > 0)
                            @foreach ($promos as $promo)
                                <div class="flex justify-between items-center bg-green-50 p-2 rounded">
                                    <div>
                                        <p class="text-green-800 font-semibold">{{ $promo['name'] ?? 'Promo' }}</p>
                                        <p class="text-sm text-green-600">
                                            {{ $promo['description'] ?? '' }} ({{ $promo['percent'] ?? 0 }}%)
                                        </p>
                                    </div>
                                    <span class="text-green-800 font-semibold">-Rp
                                        {{ number_format($promo['discount'] ?? 0, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @endif

                        <!-- Total -->
                        <div
                            class="border-t border-blue-200 pt-2 mt-2 flex justify-between items-center font-bold text-blue-900 text-2xl">
                            <span>Total</span>
                            <span>
                                Rp {{ number_format($subtotal + $layanan, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Info Promo Kode (optional) -->
                    @if ($promoCode)
                        <div class="mt-6 p-4 bg-green-50 rounded-xl">
                            <p class="text-sm text-green-800">
                                <strong>Kode Promo:</strong> {{ $promoCode }}
                            </p>
                            <p class="text-sm text-green-600 mt-1">
                                Diskon {{ $discountPercent ?? 0 }}% berhasil diterapkan
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom styles untuk mempercantik tampilan */
        input:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .shadow-lg {
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection
