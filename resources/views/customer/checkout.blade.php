@extends('layouts.guest')

@section('title', 'Checkout')

@section('content')
<div class="p-4 md:p-8">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Checkout</h1>

    <p>
        <strong>Tanggal Kedatangan:</strong>
        {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
    </p>

    <table class="w-full border mt-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">Nama Tiket</th>
                <th class="border p-2">Qty</th>
                <th class="border p-2">Harga</th>
                <th class="border p-2">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $cartTotal = 0; @endphp
            @foreach ($cart as $item)
                @php
                    $subtotal = $item['qty'] * $item['price'];
                    $cartTotal += $subtotal;
                @endphp
                <tr>
                    <td class="border p-2">{{ $item['name'] }}</td>
                    <td class="border p-2 text-center">{{ $item['qty'] }}</td>
                    <td class="border p-2">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td class="border p-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Kalau ada promo --}}
            @if (!empty($discountPercent) && $discountPercent > 0)
                <tr>
                    <td colspan="3" class="border p-2 text-right">Diskon ({{ $discountPercent }}%)</td>
                    <td class="border p-2 text-red-600">
                        - Rp {{ number_format($discountAmount, 0, ',', '.') }}
                    </td>
                </tr>
            @endif

            {{-- Total akhir --}}
            <tr class="bg-gray-100 font-bold">
                <td colspan="3" class="border p-2 text-right">Total</td>
                <td class="border p-2">
                    Rp {{ number_format($total ?? $cartTotal, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
