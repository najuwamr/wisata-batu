@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('keranjang') }}"
                        class="ml-2 text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600 hover:text-blue-700">Keranjang</a>
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('guest.tiket') }}"
                        class="ml-2 text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600 hover:text-blue-700">Checkout</a>
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-2 text-transparent bg-clip-text bg-gradient-to-br from-green-400 to-blue-600">Pembayaran</p>
                </li>
            </ol>
        </nav>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-900 mb-2">Pembayaran</h1>
            <p class="text-gray-600">Pilih metode pembayaran yang paling nyaman untuk Anda</p>
        </div>

        @if(!empty($checkout))
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8"
                x-data="{
                    selected: '',
                    result: null,
                    loading: false,
                    orderId: localStorage.getItem('midtrans_order_id') || sessionStorage.getItem('midtrans_order_id') || '',
                    savedPayment: null,

                    init() {
                        // Cek apakah ada order_id tersimpan
                        if (this.orderId) {
                            console.log('Order ID ditemukan:', this.orderId);
                            // Load saved payment data
                            const saved = localStorage.getItem('payment_data');
                            if (saved) {
                                this.savedPayment = JSON.parse(saved);
                                this.result = this.savedPayment;
                            }
                        }
                    },

                    async submitPayment() {
                        this.loading = true;
                        this.result = null;

                        try {
                            const formData = new FormData(this.$refs.form);
                            const res = await fetch('{{ route('checkout.charge') }}', {
                                method: 'POST',
                                body: formData,
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            });

                            const data = await res.json();
                            this.loading = false;

                            if (data.status === 'success' && (data.type === 'va' || data.type === 'mandiri')) {
                                this.result = data;
                                // Simpan order_id dan payment data
                                if (data.order_id) {
                                    this.orderId = data.order_id;
                                    localStorage.setItem('midtrans_order_id', data.order_id);
                                    sessionStorage.setItem('midtrans_order_id', data.order_id);
                                    localStorage.setItem('payment_data', JSON.stringify(data));
                                    sessionStorage.setItem('payment_data', JSON.stringify(data));
                                }
                            }
                            else if (data.status === 'success' && data.type === 'qris') {
                                this.result = data;
                                // Simpan QRIS data
                                if (data.order_id) {
                                    this.orderId = data.order_id;
                                    localStorage.setItem('midtrans_order_id', data.order_id);
                                    sessionStorage.setItem('midtrans_order_id', data.order_id);
                                    localStorage.setItem('payment_data', JSON.stringify(data));
                                    sessionStorage.setItem('payment_data', JSON.stringify(data));
                                }
                            }
                            else if (data.status === 'redirect') {
                                // Simpan order_id ke localStorage & sessionStorage
                                if (data.order_id) {
                                    this.orderId = data.order_id;
                                    localStorage.setItem('midtrans_order_id', data.order_id);
                                    sessionStorage.setItem('midtrans_order_id', data.order_id);
                                }

                                // Redirect user ke halaman pembayaran Midtrans
                                window.location.href = data.url;
                            }
                            else {
                                alert(data.message || 'Gagal memproses pembayaran.');
                            }
                        } catch (error) {
                            console.error(error);
                            alert('Terjadi kesalahan saat mengirim data.');
                            this.loading = false;
                        }
                    },

                    checkStatus() {
                        if (!this.orderId) {
                            alert('Belum ada transaksi yang dibuat. Silakan pilih metode pembayaran terlebih dahulu.');
                            return;
                        }
                        // Redirect ke halaman status
                        window.location.href = '{{ url('/payment/finish') }}/' + this.orderId;
                    },

                    changePaymentMethod() {
                        if (confirm('Yakin ingin mengubah metode pembayaran? Data pembayaran sebelumnya akan dihapus.')) {
                            // Hapus semua data tersimpan
                            localStorage.removeItem('midtrans_order_id');
                            localStorage.removeItem('payment_data');
                            sessionStorage.removeItem('midtrans_order_id');
                            sessionStorage.removeItem('payment_data');

                            // Reset state
                            this.orderId = '';
                            this.result = null;
                            this.savedPayment = null;
                            this.selected = '';

                            // Scroll ke form pembayaran
                            document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                }">

            <div class="bg-blue-50 rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Informasi Pemesan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-sm md:text-base">
                    <div class="flex flex-col space-y-1 break-words">
                        <p class="text-gray-600">Nama</p>
                        <p class="font-semibold text-gray-900">{{ $checkout['name'] }}</p>
                    </div>

                    <div class="flex flex-col space-y-1 break-words">
                        <p class="text-gray-600">Email</p>
                        <p class="font-semibold text-gray-900 break-all">{{ $checkout['email'] }}</p>
                    </div>

                    <div class="flex flex-col space-y-1 break-words">
                        <p class="text-gray-600">WhatsApp</p>
                        <p class="font-semibold text-gray-900">{{ $checkout['whatsapp'] }}</p>
                    </div>

                    <div class="flex flex-col space-y-1 break-words">
                        <p class="text-gray-600">Tanggal Kunjungan</p>
                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($checkout['date'])->translatedFormat('d F Y') }}</p>
                    </div>

                    @if(!empty($checkout['promo']))
                    <div class="md:col-span-2 flex flex-col space-y-1">
                        <p class="text-gray-600">Kode Promo</p>
                        <p class="font-semibold text-green-600">{{ $checkout['promo'] }}</p>
                    </div>
                    @endif
                </div>
            </div>

            @if(!empty($checkout['cart_items']))
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <h4 class="font-semibold text-gray-900 mb-3">Ringkasan Tiket</h4>
                <div class="space-y-2">
                    @foreach($checkout['cart_items'] as $item)
                    <div class="flex justify-between items-center text-sm">
                        <span>{{ $item['name'] }} ({{ $item['qty'] }}x)</span>
                        <span class="text-right">
                            @if(!empty($item['discount']) && $item['discount'] > 0)
                            <span class="font-semibold text-gray-900">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                <span class="text-gray-400 line-through text-xs font-extralight block">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                            @else
                                <span class="font-semibold text-gray-900">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                            @endif
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-gray-50 rounded-xl p-4 mb-6 flex justify-between items-center text-sm">
                <span>Biaya Layanan</span>
                <span class="font-semibold">Rp {{ number_format($checkout['layanan'] ?? 0, 0, ',', '.') }}</span>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-6 mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-green-900">Total Pembayaran</span>
                    <span class="text-2xl font-bold text-green-900">
                        Rp {{ number_format(($checkout['total'] ?? 0), 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <form x-ref="form" @submit.prevent="submitPayment" class="space-y-6">
                @csrf
                <input type="hidden" name="gross_amount" value="{{ $checkout['total'] }}">
                <input type="hidden" name="customer_name" value="{{ $checkout['name'] }}">
                <input type="hidden" name="customer_email" value="{{ $checkout['email'] }}">
                <input type="hidden" name="customer_phone" value="{{ $checkout['whatsapp'] }}">

                <div>
                    <label class="block text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                        Pilih Metode Pembayaran
                    </label>

                    <div class="grid gap-3">
                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-blue-500 cursor-pointer"
                                @click="selected = 'bca_va'"
                                :class="{'border-blue-500 bg-blue-50': selected === 'bca_va'}">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center"
                                        :class="{'border-blue-500 bg-blue-500': selected === 'bca_va'}">
                                    <div x-show="selected === 'bca_va'" class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">BCA Virtual Account</p>
                                    <p class="text-sm text-gray-600">Transfer via BCA</p>
                                </div>
                                <div class="w-10 h-6 bg-blue-100 rounded flex items-center justify-center">
                                    <span class="text-xs font-bold text-blue-800">BCA</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-green-500 cursor-pointer"
                                @click="selected = 'bni_va'"
                                :class="{'border-green-500 bg-green-50': selected === 'bni_va'}">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center"
                                        :class="{'border-green-500 bg-green-500': selected === 'bni_va'}">
                                    <div x-show="selected === 'bni_va'" class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">BNI Virtual Account</p>
                                    <p class="text-sm text-gray-600">Transfer via BNI</p>
                                </div>
                                <div class="w-10 h-6 bg-green-100 rounded flex items-center justify-center">
                                    <span class="text-xs font-bold text-green-800">BNI</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-yellow-500 cursor-pointer"
                                @click="selected = 'bri_va'"
                                :class="{'border-yellow-500 bg-yellow-50': selected === 'bri_va'}">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center"
                                        :class="{'border-yellow-500 bg-yellow-500': selected === 'bri_va'}">
                                    <div x-show="selected === 'bri_va'" class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">BRI Virtual Account</p>
                                    <p class="text-sm text-gray-600">Transfer via BRI</p>
                                </div>
                                <div class="w-10 h-6 bg-yellow-100 rounded flex items-center justify-center">
                                    <span class="text-xs font-bold text-yellow-800">BRI</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-green-500 cursor-pointer"
                                @click="selected = 'gopay'"
                                :class="{'border-green-500 bg-green-50': selected === 'gopay'}">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center"
                                        :class="{'border-green-500 bg-green-500': selected === 'gopay'}">
                                    <div x-show="selected === 'gopay'" class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">GoPay</p>
                                    <p class="text-sm text-gray-600">Bayar via Gojek App</p>
                                </div>
                                <div class="w-10 h-6 bg-green-100 rounded flex items-center justify-center">
                                    <span class="text-xs font-bold text-green-800">GOPAY</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-orange-500 cursor-pointer"
                                @click="selected = 'shopeepay'"
                                :class="{'border-orange-500 bg-orange-50': selected === 'shopeepay'}">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center"
                                        :class="{'border-orange-500 bg-orange-500': selected === 'shopeepay'}">
                                    <div x-show="selected === 'shopeepay'" class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">ShopeePay</p>
                                    <p class="text-sm text-gray-600">Bayar via Shopee App</p>
                                </div>
                                <div class="w-10 h-6 bg-orange-100 rounded flex items-center justify-center">
                                    <span class="text-xs font-bold text-orange-500">SPAY</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-purple-500 cursor-pointer"
                                @click="selected = 'qris'"
                                :class="{'border-purple-500 bg-purple-50': selected === 'qris'}">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center"
                                        :class="{'border-purple-500 bg-purple-500': selected === 'qris'}">
                                    <div x-show="selected === 'qris'" class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">QRIS</p>
                                    <p class="text-sm text-gray-600">Scan QR Code</p>
                                </div>
                                <div class="w-10 h-6 bg-purple-100 rounded flex items-center justify-center">
                                    <span class="text-xs font-bold text-purple-800">QRIS</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <select name="payment_type" x-model="selected" class="hidden" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="bca_va">BCA Virtual Account</option>
                        <option value="bni_va">BNI Virtual Account</option>
                        <option value="bri_va">BRI Virtual Account</option>
                        <option value="mandiri_bill">Mandiri Bill Payment</option>
                        <option value="gopay">GoPay</option>
                        <option value="shopeepay">ShopeePay</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>

                <template x-if="selected">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-600 mt-0.5 flex-shrink-0">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <div class="text-blue-800 text-sm">
                                <template x-if="selected.includes('_va')">
                                    <p>Setelah klik "Bayar Sekarang", Anda akan mendapatkan nomor Virtual Account untuk melakukan transfer.</p>
                                </template>
                                <template x-if="selected === 'mandiri_bill'">
                                    <p>Setelah klik "Bayar Sekarang", Anda akan mendapatkan Bill Key dan Biller Code untuk pembayaran.</p>
                                </template>
                                <template x-if="selected === 'qris'">
                                    <p>Setelah klik "Bayar Sekarang", Anda akan diarahkan ke halaman QRIS untuk melakukan pembayaran.</p>
                                </template>
                                <template x-if="['gopay', 'shopeepay'].includes(selected)">
                                    <p>Setelah klik "Bayar Sekarang", Anda akan diarahkan ke aplikasi e-wallet pilihan Anda.</p>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl flex items-center justify-center gap-3 text-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="!selected || loading">
                    <template x-if="!loading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                    </template>
                    <template x-if="loading">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="selected ? (loading ? 'Memproses...' : 'Bayar Sekarang') : 'Pilih Metode Pembayaran'"></span>
                </button>
            </form>

            <template x-if="result && result.type === 'va'">
                <div class="mt-6 p-6 bg-green-50 border border-green-300 rounded-2xl">
                    <h3 class="text-xl font-bold text-green-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        Virtual Account Berhasil Dibuat
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Bank:</span>
                            <span class="font-bold text-green-900" x-text="result.bank"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Nomor VA:</span>
                            <div class="flex items-end justify-end gap-2">
                                <span class="font-mono break-all text-2xl text-right font-bold text-blue-600" x-text="result.va_number"></span>
                                <button @click="navigator.clipboard.writeText(result.va_number); alert('Nomor VA berhasil disalin!')"
                                    class="p-2 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors" title="Salin Nomor VA">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-green-200">
                            <span class="text-gray-700">Total:</span>
                           <span class="text-xl font-bold text-green-900">
                                Rp <span x-text="new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(result.amount)"></span>
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-green-200 flex flex-col md:flex-row gap-2">
                        <button @click="checkStatus()"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Cek Status Pembayaran
                        </button>
                        <button @click="changePaymentMethod()"
                            class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-green-600 text-green-700 font-medium rounded-lg hover:bg-green-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Ubah
                        </button>
                    </div>
                </div>
            </template>

            <template x-if="result && result.type === 'qris'">
                <div class="mt-6 p-6 bg-purple-50 border border-purple-300 rounded-2xl">
                    <h3 class="text-xl font-bold text-purple-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        QRIS Berhasil Dibuat
                    </h3>

                    <div class="bg-white rounded-xl p-6 mb-4 text-center">
                        <p class="text-sm text-gray-600 mb-4">Scan QR Code di bawah ini untuk melakukan pembayaran</p>

                        <div class="flex justify-center mb-4">
                            <template x-if="result.qr_string">
                                <img :src="result.qr_string.startsWith('http') ? result.qr_string : 'data:image/png;base64,' + result.qr_string"
                                     alt="QRIS Code"
                                     class="w-64 h-64 border-2 border-purple-300 rounded-lg">
                            </template>
                            <template x-if="!result.qr_string && result.qr_code">
                                <div class="w-64 h-64 border-2 border-purple-300 rounded-lg flex items-center justify-center bg-gray-50">
                                    <p class="text-sm text-gray-500">QR Code tersedia</p>
                                </div>
                            </template>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-700">Order ID:</span>
                                <span class="font-mono font-semibold text-purple-900" x-text="result.order_id"></span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-purple-200">
                                <span class="text-gray-700">Total Pembayaran:</span>
                                <span class="text-xl font-bold text-purple-900">
                                    Rp <span x-text="new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(result.amount)"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-100 border border-purple-200 rounded-lg p-4 mb-4">
                        <h4 class="font-semibold text-purple-900 mb-2 text-sm">Cara Pembayaran:</h4>
                        <ol class="list-decimal list-inside space-y-1 text-sm text-purple-800">
                            <li>Buka aplikasi e-wallet/mobile banking Anda</li>
                            <li>Pilih menu Scan QR atau QRIS</li>
                            <li>Scan QR Code di atas</li>
                            <li>Pastikan nominal pembayaran sudah sesuai</li>
                            <li>Konfirmasi pembayaran</li>
                        </ol>
                    </div>

                    <div class="flex gap-2">
                        <button @click="checkStatus()"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Cek Status Pembayaran
                        </button>
                        <button @click="changePaymentMethod()"
                            class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-purple-600 text-purple-700 font-medium rounded-lg hover:bg-purple-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Ubah
                        </button>
                    </div>
                </div>
            </template>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto text-red-400 mb-4">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Data Tidak Ditemukan</h3>
            <p class="text-gray-600 mb-4">Data checkout tidak tersedia. Silakan kembali ke halaman keranjang.</p>
            <a href="{{ route('keranjang') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium transition-colors">
                Kembali ke Keranjang
            </a>
        </div>
        @endif
    </div>
</div>

<style>

/* Spinner animation */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderId = localStorage.getItem('midtrans_order_id') || sessionStorage.getItem('midtrans_order_id');
    const paymentData = localStorage.getItem('payment_data') || sessionStorage.getItem('payment_data');

    if (orderId) {
        console.log('Order ID tersimpan ditemukan:', orderId);
    }

    if (paymentData) {
        try {
            const data = JSON.parse(paymentData);
            console.log('Payment data ditemukan:', data);
        } catch (e) {
            console.error('Error parsing payment data:', e);
        }
    }
});

window.addEventListener('beforeunload', function() {
    const orderId = localStorage.getItem('midtrans_order_id');
    const paymentData = localStorage.getItem('payment_data');

    if (orderId) {
        sessionStorage.setItem('midtrans_order_id', orderId);
    }

    if (paymentData) {
        sessionStorage.setItem('payment_data', paymentData);
    }
});
</script>
@endsection
