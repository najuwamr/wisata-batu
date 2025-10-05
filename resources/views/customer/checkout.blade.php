@extends('layouts.guest')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-6 md:p-8 mt-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Checkout</h1>

    <p class="text-gray-700 mb-3">
        <strong>Tanggal Kedatangan:</strong>
        {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
    </p>

    <table class="w-full border rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-blue-900">
            <tr>
                <th class="border p-2 text-left">Nama Tiket</th>
                <th class="border p-2 text-center">Qty</th>
                <th class="border p-2 text-left">Harga</th>
                <th class="border p-2 text-left">Diskon</th>
                <th class="border p-2 text-left">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $item)
                <tr>
                    <td class="border p-2">{{ $item['name'] }}</td>
                    <td class="border p-2 text-center">{{ $item['qty'] }}</td>
                    <td class="border p-2">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td class="border p-2 text-green-700">
                        @if (!empty($item['discount']) && $item['discount'] > 0)
                            -Rp {{ number_format($item['discount'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="border p-2">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach

            @if ($totalDiscount > 0)
                <tr class="bg-green-50">
                    <td colspan="3" class="border p-2 text-right text-green-800 font-semibold">
                        Total Potongan ({{ $promoName }} - {{ $discountPercent }}%)
                    </td>
                    <td colspan="2" class="border p-2 text-green-700">
                        - Rp {{ number_format($totalDiscount, 0, ',', '.') }}
                    </td>
                </tr>
            @endif

            <tr class="bg-gray-100 font-bold">
                <td colspan="4" class="border p-2 text-right">Total Bayar</td>
                <td class="border p-2 text-blue-900">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <form action="{{ route('checkout.store') }}" method="POST" class="mt-8 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" required class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
            <input type="text" name="whatsapp" required placeholder="Contoh: 08123456789" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-400">
        </div>
        <input type="hidden" name="total" value="{{ $total }}">
        <div class="pt-4 border-t mt-6 flex justify-end">
            <button type="submit" class="bg-blue-900 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-all">
                Lanjutkan Pembayaran
            </button>
        </div>
    </form>
</div>
@endsection
