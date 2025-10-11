@extends('layouts.guest')

@section('title', 'Status Pembayaran')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-xl shadow-lg text-center">
    <h1 class="text-2xl font-bold mb-4">Status Pembayaran</h1>

    <div class="text-left mb-6">
        <p><strong>Nama:</strong> {{ $customer->name ?? $transaction->customer_name ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $customer->email ?? $transaction->customer_email ?? '-' }}</p>
        <p><strong>No. Telepon:</strong> {{ $customer->telephone ?? $transaction->customer_phone ?? '-' }}</p>
    </div>

    <div class="border-t pt-4 text-left">
        <p><strong>Order ID:</strong> {{ $transaction->midtrans_order_id }}</p>
        <p><strong>Status:</strong>
            <span class="@if($transaction->status === 'paid') text-green-600 @else text-yellow-600 @endif font-semibold">
                {{ ucfirst($transaction->status) }}
            </span>
        </p>
        <p><strong>Total:</strong> Rp {{ number_format($transaction->total_price ?? $transaction->gross_amount, 0, ',', '.') }}</p>
        <p><strong>Metode:</strong> {{ strtoupper($transaction->payment_methode_id->type ?? '-') }}</p>
    </div>

    <div class="mt-6">
        @if($transaction->status === 'success')
            <a href="{{ route('eticket.download', $transaction->id) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Download E-Ticket 🎟️
            </a>
        @else
            <a href="{{ route('Beranda') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Kembali ke Beranda
            </a>
        @endif
    </div>
</div>
@endsection
