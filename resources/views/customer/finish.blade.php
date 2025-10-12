@extends('layouts.guest')

@section('title', 'Status Pembayaran')

@section('content')
<div class="max-w-2xl mx-auto mt-6 sm:mt-10 bg-white p-4 sm:p-6 md:p-8 rounded-xl shadow-lg">
    <div class="text-center mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Status Pembayaran</h1>
        <p class="text-sm text-gray-600">Detail transaksi dan e-ticket Anda</p>
    </div>

    {{-- Informasi Pemesan --}}
    <div class="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6">
        <h2 class="font-semibold text-gray-900 mb-3 text-lg">Informasi Pemesan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
            <div>
                <span class="font-medium text-gray-700">Nama:</span>
                <p class="text-gray-900">{{ $transaction->customer->name }}</p>
            </div>
            <div>
                <span class="font-medium text-gray-700">Email:</span>
                <p class="text-gray-900 break-all">{{ $transaction->customer->email }}</p>
            </div>
            <div>
                <span class="font-medium text-gray-700">No. Telepon:</span>
                <p class="text-gray-900">{{ $transaction->customer->telephone ?? '-' }}</p>
            </div>
            <div>
                <span class="font-medium text-gray-700">Tanggal Kunjungan:</span>
                <p class="text-gray-900">{{ \Carbon\Carbon::parse($transaction->tanggal_kedatangan)->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Status Pembayaran --}}
    <div class="border border-gray-200 rounded-lg p-4 sm:p-6 mb-6">
        <h2 class="font-semibold text-gray-900 mb-4 text-lg">Detail Transaksi</h2>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between items-center">
                <span class="font-medium text-gray-700">Order ID:</span>
                <span class="text-gray-900 font-mono">{{ $transaction->midtrans_order_id }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-medium text-gray-700">Status:</span>
                <span class="@if($transaction->status === 'paid') text-green-600 @elseif($transaction->status === 'pending') text-yellow-600 @else text-red-600 @endif font-semibold capitalize">
                    {{ $transaction->status }}
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-medium text-gray-700">Total:</span>
                <span class="text-gray-900 font-semibold">Rp {{ number_format($transaction->total_price ?? $transaction->gross_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-medium text-gray-700">Metode Pembayaran:</span>
                <span class="text-gray-900 uppercase">{{ $transaction->payment_methode_id->type ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Jika belum paid --}}
    @if($transaction->status !== 'paid')
        <div class="text-center p-4 bg-yellow-50 rounded-lg border border-yellow-200 mb-6">
            <div class="flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <p class="text-yellow-800 font-medium">Menunggu Pembayaran</p>
            </div>
            <p class="text-sm text-yellow-700 mb-4">
                Status pembayaran Anda saat ini adalah <strong class="capitalize">{{ $transaction->status }}</strong>.
                Silakan selesaikan pembayaran untuk mendapatkan e-ticket.
            </p>
            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                <a href="{{ route('Beranda') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200 text-sm font-medium">
                    Kembali ke Beranda
                </a>
                @if($transaction->status === 'pending')
                    <button onclick="window.location.reload()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 text-sm font-medium">
                        Cek Status Terbaru
                    </button>
                @endif
            </div>
        </div>
    @endif

    {{-- Jika sudah paid → tampilkan e-ticket --}}
    @if($transaction->status === 'paid')
        <div class="mt-8 border-t pt-6">
            <div class="text-center mb-4">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900">E-Ticket Anda</h2>
                <p class="text-sm text-gray-600">Simpan atau cetak e-ticket ini untuk ditunjukkan di lokasi</p>
            </div>
            @include('customer.tiket.e-tiket', ['transaction' => $transaction, 'qrCode' => $qrCode])
            
            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center mt-6">
                <button onclick="window.print()" class="bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700 transition duration-200 font-medium flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2z"/>
                    </svg>
                    Cetak E-Ticket
                </button>
                <a href="{{ route('Beranda') }}" class="bg-gray-600 text-white px-5 py-2.5 rounded-lg hover:bg-gray-700 transition duration-200 font-medium text-center">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .max-w-2xl, .max-w-2xl * {
            visibility: visible;
        }
        .max-w-2xl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 100%;
            box-shadow: none;
        }
        button, a {
            display: none !important;
        }
    }
</style>
@endsection