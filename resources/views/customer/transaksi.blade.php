@extends('layouts.guest')

@section('title', 'Pembayaran')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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

                   
                </ol>
            </nav>
            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pembayaran Tiket</h1>
                <p class="text-gray-600 max-w-md mx-auto">Pilih metode pembayaran yang paling nyaman untuk Anda</p>
            </div>

            @if (!empty($checkout))
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8" x-data="paymentApp()">

                    <!-- Progress Steps -->
                    <div class="bg-white border-b border-gray-200">
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between max-w-md mx-auto">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-semibold">
                                        1
                                    </div>
                                    <div class="ml-2 text-sm font-medium text-blue-600">Checkout</div>
                                </div>
                                <div class="flex-1 h-0.5 bg-blue-600 mx-4"></div>
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-semibold">
                                        2
                                    </div>
                                    <div class="ml-2 text-sm font-medium text-blue-600">Bayar</div>
                                </div>
                                <div class="flex-1 h-0.5 bg-gray-300 mx-4"></div>
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center text-sm font-semibold">
                                        3
                                    </div>
                                    <div class="ml-2 text-sm font-medium text-gray-500">Selesai</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-8">
                        <!-- Informasi Customer -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Informasi Pemesan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600 text-xs font-medium uppercase tracking-wide">Nama</p>
                                    <p class="font-semibold text-gray-900 mt-1">{{ $checkout['name'] }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-xs font-medium uppercase tracking-wide">Email</p>
                                    <p class="font-semibold text-gray-900 mt-1">{{ $checkout['email'] }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-xs font-medium uppercase tracking-wide">WhatsApp</p>
                                    <p class="font-semibold text-gray-900 mt-1">{{ $checkout['whatsapp'] }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-xs font-medium uppercase tracking-wide">Tanggal Kunjungan
                                    </p>
                                    <p class="font-semibold text-gray-900 mt-1">
                                        {{ \Carbon\Carbon::parse($checkout['date'])->translatedFormat('d F Y') }}</p>
                                </div>
                                @if (!empty($checkout['promo']))
                                    <div class="md:col-span-2">
                                        <p class="text-gray-600 text-xs font-medium uppercase tracking-wide">Kode Promo</p>
                                        <p class="font-semibold text-green-600 mt-1">{{ $checkout['promo'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Ringkasan Tiket & Total -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                            <!-- Ringkasan Tiket -->
                            @if (!empty($checkout['cart_items']))
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                    <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Ringkasan Tiket
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach ($checkout['cart_items'] as $item)
                                            <div
                                                class="flex justify-between items-center py-2 border-b border-gray-200 last:border-b-0">
                                                <div>
                                                    <span class="font-medium text-gray-900">{{ $item['name'] }}</span>
                                                    <span class="text-sm text-gray-600 ml-2">({{ $item['qty'] }}x)</span>
                                                </div>
                                                <span class="font-semibold text-gray-900">Rp
                                                    {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Total Pembayaran -->
                            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 text-white">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-bold">Total Pembayaran</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                                <div class="text-3xl font-bold mb-2">Rp
                                    {{ number_format($checkout['total'], 0, ',', '.') }}</div>
                                <p class="text-green-100 text-sm opacity-90">Termasuk semua biaya dan pajak</p>
                            </div>
                        </div>

                        <!-- Form Pembayaran -->
                        <form x-ref="form" @submit.prevent="submitPayment" class="space-y-6">
                            @csrf
                            <input type="hidden" name="gross_amount" value="{{ $checkout['total'] }}">
                            <input type="hidden" name="customer_name" value="{{ $checkout['name'] }}">
                            <input type="hidden" name="customer_email" value="{{ $checkout['email'] }}">
                            <input type="hidden" name="customer_phone" value="{{ $checkout['whatsapp'] }}">

                            <!-- Pilih Metode Pembayaran -->
                            <div>
                                <label class="block text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Pilih Metode Pembayaran
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Virtual Account -->
                                    <template x-for="method in paymentMethods.virtualAccount" :key="method.id">
                                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-blue-500 transition-all cursor-pointer"
                                            @click="selected = method.id"
                                            :class="{ 'border-blue-500 bg-blue-50 shadow-md': selected === method.id }">
                                            <div class="flex items-center gap-3">
                                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
                                                    :class="selected === method.id ? 'border-blue-500 bg-blue-500' :
                                                        'border-gray-300'">
                                                    <div x-show="selected === method.id"
                                                        class="w-2 h-2 bg-white rounded-full"></div>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900" x-text="method.name"></p>
                                                    <p class="text-sm text-gray-600" x-text="method.description"></p>
                                                </div>
                                                <div class="w-12 h-8 rounded flex items-center justify-center shadow-sm"
                                                    :class="method.badgeClass">
                                                    <span class="text-xs font-bold" :class="method.textClass"
                                                        x-text="method.bank"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- E-Wallet -->
                                    <template x-for="method in paymentMethods.ewallet" :key="method.id">
                                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-green-500 transition-all cursor-pointer"
                                            @click="selected = method.id"
                                            :class="{ 'border-green-500 bg-green-50 shadow-md': selected === method.id }">
                                            <div class="flex items-center gap-3">
                                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
                                                    :class="selected === method.id ? 'border-green-500 bg-green-500' :
                                                        'border-gray-300'">
                                                    <div x-show="selected === method.id"
                                                        class="w-2 h-2 bg-white rounded-full"></div>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900" x-text="method.name"></p>
                                                    <p class="text-sm text-gray-600" x-text="method.description"></p>
                                                </div>
                                                <div class="w-12 h-8 rounded flex items-center justify-center shadow-sm"
                                                    :class="method.badgeClass">
                                                    <span class="text-xs font-bold" :class="method.textClass"
                                                        x-text="method.bank"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- QRIS -->
                                    <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-purple-500 transition-all cursor-pointer md:col-span-2"
                                        @click="selected = 'qris'"
                                        :class="{ 'border-purple-500 bg-purple-50 shadow-md': selected === 'qris' }">
                                        <div class="flex items-center gap-3">
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
                                                :class="selected === 'qris' ? 'border-purple-500 bg-purple-500' :
                                                    'border-gray-300'">
                                                <div x-show="selected === 'qris'" class="w-2 h-2 bg-white rounded-full">
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-900">QRIS</p>
                                                <p class="text-sm text-gray-600">Scan QR Code dengan aplikasi e-wallet atau
                                                    mobile banking</p>
                                            </div>
                                            <div
                                                class="w-12 h-8 bg-purple-100 rounded flex items-center justify-center shadow-sm">
                                                <span class="text-xs font-bold text-purple-800">QRIS</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden Select -->
                                <select name="payment_type" x-model="selected" class="hidden" required>
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="bca_va">BCA Virtual Account</option>
                                    <option value="bni_va">BNI Virtual Account</option>
                                    <option value="bri_va">BRI Virtual Account</option>
                                    <option value="gopay">GoPay</option>
                                    <option value="shopeepay">ShopeePay</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>

                            <!-- Pesan Informasi -->
                            <template x-if="selected">
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                    <div class="flex items-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div class="text-blue-800 text-sm">
                                            <template x-if="selected.includes('_va')">
                                                <p>Setelah klik "Bayar Sekarang", Anda akan mendapatkan nomor Virtual
                                                    Account untuk melakukan transfer.</p>
                                            </template>
                                            <template x-if="['gopay', 'shopeepay'].includes(selected)">
                                                <p>Setelah klik "Bayar Sekarang", Anda akan diarahkan ke aplikasi e-wallet
                                                    pilihan Anda.</p>
                                            </template>
                                            <template x-if="selected === 'qris'">
                                                <p>Setelah klik "Bayar Sekarang", Anda akan melihat QR Code yang dapat
                                                    di-scan dengan aplikasi e-wallet atau mobile banking.</p>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Tombol Submit -->
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-4 px-6 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 text-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                :disabled="!selected || loading">
                                <template x-if="!loading">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </template>
                                <template x-if="loading">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </template>
                                <span
                                    x-text="selected ? (loading ? 'Memproses...' : 'Bayar Sekarang') : 'Pilih Metode Pembayaran'"></span>
                            </button>
                        </form>

                        <!-- Hasil Pembayaran -->
                        <template x-if="result">
                            <div class="mt-6 p-6 bg-white border border-green-300 rounded-2xl shadow-lg">
                                <template x-if="result.type === 'va'">
                                    <div>
                                        <h3 class="text-xl font-bold text-green-900 mb-4 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Virtual Account Berhasil Dibuat
                                        </h3>
                                        <div class="space-y-4">
                                            <div class="flex justify-between items-center py-2">
                                                <span class="text-gray-700 font-medium">Bank:</span>
                                                <span class="font-bold text-green-900 text-lg"
                                                    x-text="result.bank"></span>
                                            </div>
                                            <div class="flex justify-between items-center py-2">
                                                <span class="text-gray-700 font-medium">Nomor VA:</span>
                                                <span class="font-mono text-2xl font-bold text-blue-600 tracking-wider"
                                                    x-text="result.va_number"></span>
                                            </div>
                                            <div class="flex justify-between items-center py-3 border-t border-green-200">
                                                <span class="text-gray-700 font-medium">Total Pembayaran:</span>
                                                <span class="text-xl font-bold text-green-900">Rp <span
                                                        x-text="new Intl.NumberFormat('id-ID').format(result.amount)"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="result.type === 'qris'">
                                    <div class="text-center">
                                        <h3
                                            class="text-xl font-bold text-green-900 mb-4 flex items-center gap-2 justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                            </svg>
                                            QRIS Payment
                                        </h3>

                                        <!-- QR Code Container -->
                                        <div class="bg-white p-6 rounded-2xl border-2 border-green-200 inline-block mb-4">
                                            <div class="bg-gray-100 p-4 rounded-xl inline-block">
                                                <!-- Placeholder untuk QR Code -->
                                                <div
                                                    class="w-64 h-64 bg-white flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg">
                                                    <div class="text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-16 w-16 text-gray-400 mx-auto mb-2" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                        </svg>
                                                        <p class="text-gray-500 text-sm">QR Code akan muncul di sini</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Details -->
                                        <div class="bg-green-50 rounded-xl p-4 max-w-md mx-auto">
                                            <div class="space-y-3">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-gray-700">Total:</span>
                                                    <span class="font-bold text-green-900">Rp <span
                                                            x-text="new Intl.NumberFormat('id-ID').format(result.amount)"></span></span>
                                                </div>
                                                <div class="flex justify-between items-center">
                                                    <span class="text-gray-700">Metode:</span>
                                                    <span class="font-semibold text-green-800">QRIS</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Instructions -->
                                        <div class="mt-4 text-sm text-gray-600 max-w-md mx-auto">
                                            <p class="font-semibold mb-2">Cara Pembayaran:</p>
                                            <ol class="list-decimal list-inside space-y-1 text-left">
                                                <li>Buka aplikasi e-wallet atau mobile banking Anda</li>
                                                <li>Pilih fitur scan QR Code</li>
                                                <li>Arahkan kamera ke QR Code di atas</li>
                                                <li>Konfirmasi pembayaran di aplikasi Anda</li>
                                            </ol>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-400 mx-auto mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Data Tidak Ditemukan</h3>
                    <p class="text-gray-600 mb-6">Data checkout tidak tersedia. Silakan kembali ke halaman keranjang.</p>
                    <a href="{{ route('keranjang') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium transition-colors shadow-lg hover:shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Keranjang
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function paymentApp() {
            return {
                selected: '',
                result: null,
                loading: false,
                paymentMethods: {
                    virtualAccount: [{
                            id: 'bca_va',
                            name: 'BCA Virtual Account',
                            description: 'Transfer via BCA',
                            bank: 'BCA',
                            badgeClass: 'bg-blue-100',
                            textClass: 'text-blue-800'
                        },
                        {
                            id: 'bni_va',
                            name: 'BNI Virtual Account',
                            description: 'Transfer via BNI',
                            bank: 'BNI',
                            badgeClass: 'bg-green-100',
                            textClass: 'text-green-800'
                        },
                        {
                            id: 'bri_va',
                            name: 'BRI Virtual Account',
                            description: 'Transfer via BRI',
                            bank: 'BRI',
                            badgeClass: 'bg-yellow-100',
                            textClass: 'text-yellow-800'
                        }
                    ],
                    ewallet: [{
                            id: 'gopay',
                            name: 'GoPay',
                            description: 'Bayar via Gojek App',
                            bank: 'GOPAY',
                            badgeClass: 'bg-green-100',
                            textClass: 'text-green-800'
                        },
                        {
                            id: 'shopeepay',
                            name: 'ShopeePay',
                            description: 'Bayar via Shopee App',
                            bank: 'SPAY',
                            badgeClass: 'bg-orange-100',
                            textClass: 'text-orange-800'
                        }
                    ]
                },
                async submitPayment() {
                    this.loading = true;
                    this.result = null;

                    try {
                        const formData = new FormData(this.$refs.form);
                        const res = await fetch('{{ route('checkout.charge') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                        });

                        const data = await res.json();
                        this.loading = false;

                        if (data.status === 'success' && (data.type === 'va' || data.type === 'qris')) {
                            this.result = data;
                            // Scroll ke hasil pembayaran
                            this.$nextTick(() => {
                                this.$el.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            });
                        } else if (data.status === 'redirect') {
                            localStorage.setItem('midtrans_order_id', data.order_id);
                            window.location.href = data.url;
                        } else {
                            alert(data.message || 'Gagal memproses pembayaran.');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Terjadi kesalahan saat mengirim data.');
                        this.loading = false;
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom animations */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom shadow for depth */
        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Gradient text animation */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
@endsection
