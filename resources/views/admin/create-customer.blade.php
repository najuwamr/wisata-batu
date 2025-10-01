@extends('layouts.guest')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg mt-10">
    <h1 class="text-xl font-bold mb-4 text-blue-700">Pilih Metode Pembayaran</h1>

    <form method="POST" action="{{ route('payment.charge') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-2">Metode</label>
            <select name="payment_type" class="form-select">
                <option value="bca_va">BCA Virtual Account</option>
                <option value="bni_va">BNI Virtual Account</option>
                <option value="bri_va">BRI Virtual Account</option>
                <option value="mandiri_bill">Mandiri Bill Payment</option>
                <option value="permata_va">Permata Virtual Account</option>
                <option value="cimb_va">CIMB Virtual Account</option>
                <option value="qris">QRIS</option>
                <option value="gopay">GoPay</option>
                <option value="dana">DANA</option>
                <option value="shopeepay">ShopeePay</option>
            </select>
        </div>

        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Bayar Sekarang
        </button>
    </form>
</div>
@endsection
