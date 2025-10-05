@extends('layouts.guest')

@section('title', 'Keranjang')

@section('content')
<div class="p-4 md:p-8">
    <h1 class="pb-0 text-2xl md:text-3xl font-bold text-blue-900">Pilih Tiket & Tanggal</h1>
    <p class="text-sm md:text-base font-thin text-gray-700">
        Notes: Jangan lupa tambahkan jenis kendaraan bila membawa ya!
    </p>

    {{-- Grid Layout --}}
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 lg:grid-rows-2 gap-4">

        {{-- Kalender --}}
        <div class="bg-gradient-to-br from-blue-300 to-blue-200 text-blue-900 rounded-xl p-3 order-1">
            @include('components.kalender')
        </div>

        {{-- Daftar Tiket --}}
        <div class="bg-white rounded-xl shadow p-4 md:col-span-2 md:row-span-2 order-2">
            <h2 class="font-bold text-xl md:text-2xl text-blue-900 mb-2">Daftar Tiket</h2>

            @if($tiket->count() > 0)
                <div class="space-y-4">
                    @foreach($tiket->groupBy('category') as $category => $items)
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg text-blue-800 mb-3 capitalize">{{ $category }}</h3>
                            <div class="space-y-3">
                                @foreach($items as $ticket)
                                    @php
                                        $inCart = isset($cart[$ticket->id]);
                                        $quantity = $inCart ? $cart[$ticket->id]['qty'] : 0;
                                    @endphp
                                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $ticket->name }}</h4>
                                            @if($ticket->description)
                                                <p class="text-sm text-gray-600 mt-1">{{ $ticket->description }}</p>
                                            @endif
                                            <p class="text-blue-700 font-semibold mt-2">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                                        </div>

                                        <div class="flex items-center">
                                            @if($inCart)
                                                <div class="flex items-center space-x-3 bg-blue-50 px-3 py-2 rounded-lg">
                                                    <form action="{{ route('keranjang.update', $ticket->id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="qty" value="{{ $quantity - 1 }}">
                                                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded-full hover:bg-gray-100">
                                                            <span class="text-lg font-bold text-gray-700">-</span>
                                                        </button>
                                                    </form>
                                                    <span class="w-8 text-center font-medium text-gray-900">{{ $quantity }}</span>
                                                    <form action="{{ route('keranjang.update', $ticket->id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="qty" value="{{ $quantity + 1 }}">
                                                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded-full hover:bg-gray-100">
                                                            <span class="text-lg font-bold text-gray-700">+</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <form action="{{ route('keranjang.tambah') }}" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                    <input type="hidden" name="qty" value="1">
                                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
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
                <p class="text-gray-500 text-sm">Belum ada daftar tiket ditampilkan.</p>
            @endif
        </div>

        {{-- Keranjang --}}
        <div class="relative bg-white rounded-xl shadow p-4 mt-6 order-3 md:row-start-2">
            <!-- Icon di atas -->
            <div class="absolute -top-7 right-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 16 16">
                    <path fill="none" stroke="#162456" stroke-linecap="round"
                        d="M9.5 4v7.7c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V3C6.5 1.6 7.6.5 9 .5s2.5 1.1 2.5 2.5v9c0 1.9-1.6 3.5-3.5 3.5S4.5 13.9 4.5 12V4" />
                </svg>
            </div>

            <h2 class="font-bold text-xl md:text-2xl pb-2 border-b text-blue-900 mb-3">
                Keranjang Anda
            </h2>

            @if(count($cart) > 0)
                {{-- Daftar item dalam keranjang --}}
                <ul class="divide-y divide-gray-200 bg-gray-50 rounded-md">
                    @foreach ($cart as $id => $item)
                        <li class="p-3 flex justify-between items-center hover:bg-gray-100">
                            <!-- Kiri: Nama & Qty -->
                            <div>
                                <p class="font-semibold text-gray-900 text-sm md:text-base">
                                    {{ $item['name'] }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Qty: {{ $item['qty'] }}
                                </p>
                            </div>

                            <!-- Kanan: Hapus & Harga -->
                            <div class="flex items-center gap-3">
                                <!-- Tombol Hapus -->
                                <form action="{{ route('keranjang.hapus', $id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m0 16H5V5h14v14M17 8.4L13.4 12l3.6 3.6l-1.4 1.4l-3.6-3.6L8.4 17L7 15.6l3.6-3.6L7 8.4L8.4 7l3.6 3.6L15.6 7L17 8.4Z" />
                                        </svg>
                                    </button>
                                </form>

                                <!-- Harga -->
                                <p class="text-gray-900 font-medium text-sm md:text-base">
                                    Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Total Belanja --}}
                <div class="mt-4 border-t pt-3 flex justify-between font-bold text-blue-900 text-sm md:text-base">
                    <span>Total</span>
                    <span>
                        Rp {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['qty']), 0, ',', '.') }}
                    </span>
                </div>

                {{-- Form Checkout --}}
                <form action="{{ route('keranjang.checkout') }}" method="POST"
                    x-data="{ date: '', promo: '' }"
                    @date-selected.window="date = $event.detail.date"
                    class="mt-4 space-y-3">
                    @csrf

                    <!-- Input tanggal dari kalender -->
                    <input type="hidden" name="date" x-model="date" required>

                    <!-- Input kode promo -->
                    <div>
                        <label for="promo" class="block text-sm font-medium text-gray-700 mb-1">
                            Kode Promo (opsional)
                        </label>
                        <input type="text"
                            id="promo"
                            name="promo"
                            x-model="promo"
                            placeholder="Masukkan kode promo Anda"
                            class="w-full rounded-lg border border-green-300 bg-green-50 text-green-700 placeholder-green-600 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400" />
                    </div>

                    <!-- Tombol Checkout -->
                    <div class="flex justify-center">
                        <button type="submit"
                            class="flex items-center justify-center gap-2 bg-blue-900 text-white py-2 px-6 rounded-lg font-semibold hover:bg-blue-800 transition text-sm md:text-base w-full md:w-auto">
                            Pesan Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                                <g fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="1.5">
                                    <path d="M2.75 4.75h10.5v9.5H2.75z"/>
                                    <path d="M5.75 7.75c0 1.5 1 2.5 2.25 2.5s2.25-1 2.25-2.5m-7.5-3l1.5-3h7.5l1.5 3"/>
                                </g>
                            </svg>
                        </button>
                    </div>
                </form>
            @else
                {{-- Jika keranjang kosong --}}
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500 mb-2">
                        Belum ada tiket dipilih.
                    </p>
                    <a href="{{ route('guest.tiket') }}"
                    class="inline-block text-blue-700 font-medium hover:underline">
                        Pilih Tiket Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
