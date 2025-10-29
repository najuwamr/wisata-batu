@extends('layouts.guest')

@section('title', 'Keranjang')

@section('content')

{{-- Flash Message --}}
@if (session('success'))
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed top-6 right-6 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 transition transform"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed top-6 right-6 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 transition transform"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2">
        {{ session('error') }}
    </div>
@endif

    <div class="p-4 md:p-8">
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-900 mb-2">Pilih Tiket & Tanggal</h1>
            <p class="text-sm md:text-base text-gray-600 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                Jangan lupa tambahkan jenis kendaraan bila membawa ya!
            </p>
        </div>

        {{-- Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri: Kalender dan Keranjang --}}
            <div class="lg:col-span-1 flex flex-col space-y-6 order-1 lg:order-1">
                {{-- Kalender --}}
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Pilih Tanggal
                    </h3>
                    @include('components.kalender')
                </div>

                {{-- Keranjang --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 relative">
                    <!-- Decorative Icon -->
                    <h2 class="font-bold text-xl md:text-2xl text-blue-900 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        Keranjang Anda
                        @if(count($cart) > 0)
                            <span class="bg-blue-500 text-white text-sm font-medium px-2 py-1 rounded-full">
                                {{ count($cart) }} item
                            </span>
                        @endif
                    </h2>
    
                    @if (count($cart) > 0)
                        {{-- Daftar item dalam keranjang --}}
                        <div class="space-y-3 mb-6 max-h-80 overflow-y-auto pr-2">
                            @foreach ($cart as $id => $item)
                                <div class="bg-gradient-to-r from-blue-50 to-white border border-blue-100 rounded-xl p-4 hover:shadow-md transition-all duration-300">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
                                                    <path d="M13 5v2"/>
                                                    <path d="M13 17v2"/>
                                                    <path d="M13 11v2"/>
                                                </svg>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="font-semibold text-gray-900 text-sm truncate">{{ $item['name'] }}</p>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="text-xs text-gray-500">
                                                        {{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="flex items-center gap-2">
                                            <span class="text-blue-600 font-medium text-sm whitespace-nowrap">
                                                Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                            </span>
                                            <form action="{{ route('keranjang.hapus', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Hapus"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m0 16H5V5h14v14M17 8.4L13.4 12l3.6 3.6l-1.4 1.4l-3.6-3.6L8.4 17L7 15.6l3.6-3.6L7 8.4L8.4 7l3.6 3.6L15.6 7L17 8.4Z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
    
                        {{-- Total Belanja --}}
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 mb-6">
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-gray-700 text-sm">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-700 text-sm">
                                    <span>Biaya Layanan</span>
                                    <span>Rp {{ number_format($layanan, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-blue-200 pt-2 mt-2">
                                    <div class="flex justify-between items-center font-bold text-blue-900">
                                        <span>Total</span>
                                        <span class="text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        {{-- Form Checkout --}}
                        <form action="{{ route('keranjang.checkout') }}" method="POST"
                            x-data="{
                                date: localStorage.getItem('selectedDate') || '',
                                promo: ''
                            }"
                            @date-selected.window="
                                date = $event.detail.date;
                                localStorage.setItem('selectedDate', date);
                            "
                            class="space-y-4">
                            @csrf
    
                            <input type="hidden" name="date" id="selected-date" x-model="date">
    
                            <div>
                                <label for="promo" class="block text-sm font-medium text-gray-700 mb-2">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 15l6-6"></path>
                                            <circle cx="9" cy="9" r="7"></circle>
                                            <circle cx="15" cy="15" r="7"></circle>
                                        </svg>
                                        Kode Promo (opsional)
                                    </div>
                                </label>
                                <input type="text" id="promo" name="promo" x-model="promo"
                                    placeholder="Masukkan kode promo"
                                    class="w-full rounded-xl border-2 border-green-200 bg-green-50 text-green-800 placeholder-green-600 px-3 py-2 text-sm focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-200 transition-all" />
                            </div>
    
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-4 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                        <path d="M2.75 4.75h10.5v9.5H2.75z" />
                                        <path d="M5.75 7.75c0 1.5 1 2.5 2.25 2.5s2.25-1 2.25-2.5m-7.5-3l1.5-3h7.5l1.5 3" />
                                    </g>
                                </svg>
                                Pesan Sekarang
                            </button>
                        </form>
                    @else
                        {{-- Jika keranjang kosong --}}
                        <div class="text-center py-8">
                            <div class="bg-blue-50 rounded-xl p-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto text-blue-400 mb-3">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <p class="text-gray-600 mb-3 text-sm">Keranjang Anda masih kosong <br> Tambahkan tiket untuk melanjutkan pemesanan</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kolom Kanan: Daftar Tiket --}}
            <div class="lg:col-span-2 order-2 lg:order-3">
                {{-- Daftar Tiket --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-bold text-xl md:text-2xl text-blue-900">Daftar Tiket</h2>
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                            {{ $tiket->count() }} tiket tersedia
                        </span>
                    </div>

                    @if ($tiket->count() > 0)
                        <div class="space-y-6">
                            @foreach ($tiket->groupBy('category') as $category => $items)
                                <div class="mb-8">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                                        <h3 class="font-semibold text-lg text-blue-800 capitalize">{{ $category }}</h3>
                                    </div>
                                    <div class="grid gap-4">
                                        @foreach ($items as $ticket)
                                            @php
                                                $inCart = isset($cart[$ticket->id]);
                                                $quantity = $inCart ? $cart[$ticket->id]['qty'] : 0;
                                            @endphp
                                            <div class="bg-gradient-to-r from-blue-50 to-white border border-blue-100 rounded-xl p-4 hover:shadow-md transition-all duration-300">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-start justify-between mb-2">
                                                            <h4 class="font-semibold text-gray-900 text-lg">{{ $ticket->name }}</h4>
                                                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                                            </span>
                                                        </div>

                                                        @if ($ticket->description)
                                                            <div class="mb-3">
                                                                <p class="text-gray-600 text-sm leading-relaxed">
                                                                    {{ Str::limit(strip_tags($ticket->description), 120) }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="flex items-center justify-between pt-3 border-t border-blue-100">
                                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                        Tersedia
                                                    </div>

                                                    @if ($inCart)
                                                        <div class="flex items-center gap-3 bg-white border border-blue-200 rounded-xl px-4 py-2">
                                                            <form action="{{ route('keranjang.update', $ticket->id) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="qty" value="{{ $quantity - 1 }}">
                                                                <button type="submit"
                                                                    class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                                                    {{ $quantity <= 1 ? 'disabled' : '' }}>
                                                                    <span class="font-bold">−</span>
                                                                </button>
                                                            </form>
                                                            <span class="w-8 text-center font-semibold text-gray-900 text-lg">{{ $quantity }}</span>
                                                            <form action="{{ route('keranjang.update', $ticket->id) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="qty" value="{{ $quantity + 1 }}">
                                                                <button type="submit"
                                                                    class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                                                    <span class="font-bold">+</span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('keranjang.tambah') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                            <input type="hidden" name="qty" value="1">
                                                            <button type="submit"
                                                                class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium transition-colors shadow-md hover:shadow-lg flex items-center gap-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                    <circle cx="9" cy="21" r="1"></circle>
                                                                    <circle cx="20" cy="21" r="1"></circle>
                                                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                                                </svg>
                                                                Tambah
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto text-gray-400 mb-4">
                                <path d="m9.5 7.5-2 2a4.95 4.95 0 1 0 7 7l2-2m-7-7 2-2a4.95 4.95 0 1 1 7 7l-2 2m-7-7 7 7"/>
                            </svg>
                            <p class="text-gray-500 text-lg">Tidak ada tiket tersedia saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('tanggal_kedatangan');
    const savedDate = localStorage.getItem('selectedDate');

    // Kalau sebelumnya user sudah pilih tanggal, isi kembali
    if (savedDate) {
        input.value = savedDate;
    }

    // Update input & simpan ke localStorage kalau user pilih tanggal baru
    window.addEventListener('date-selected', (event) => {
        const selectedDate = event.detail.date;
        input.value = selectedDate;
        localStorage.setItem('selectedDate', selectedDate);
    });
});
</script>
@endsection
