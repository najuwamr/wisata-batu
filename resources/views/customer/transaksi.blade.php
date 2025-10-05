@extends('layouts.guest')

@section('title', 'Pembayaran')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow-lg p-6 mt-6" 
     x-data="paymentForm()" x-cloak>
    <h2 class="text-2xl font-bold mb-4 text-center">Pembayaran</h2>

    <div class="mb-4">
        <p><strong>Nama:</strong> {{ $checkout['name'] }}</p>
        <p><strong>Email:</strong> {{ $checkout['email'] }}</p>
        <p><strong>WhatsApp:</strong> {{ $checkout['whatsapp'] }}</p>
        <p class="mt-2"><strong>Total:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>
    </div>

    {{-- Form --}}
    <form x-ref="form" @submit.prevent="submitPayment" class="space-y-4">
        @csrf
        <input type="hidden" name="gross_amount" value="{{ $total }}">
        <input type="hidden" name="customer_name" value="{{ $checkout['name'] }}">
        <input type="hidden" name="customer_email" value="{{ $checkout['email'] }}">
        <input type="hidden" name="customer_phone" value="{{ $checkout['whatsapp'] }}">

        <div>
            <label class="block font-semibold mb-2">Pilih Metode Pembayaran</label>
            <select name="payment_type" x-model="selected" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Metode --</option>
                <optgroup label="Virtual Account">
                    <option value="bca_va">BCA Virtual Account</option>
                    <option value="bni_va">BNI Virtual Account</option>
                    <option value="bri_va">BRI Virtual Account</option>
                    <option value="mandiri_bill">Mandiri Bill Payment</option>
                </optgroup>
                <optgroup label="E-Wallet">
                    <option value="gopay">GoPay</option>
                    <option value="shopeepay">ShopeePay</option>
                </optgroup>
                <optgroup label="QRIS">
                    <option value="qris">QRIS</option>
                </optgroup>
            </select>
        </div>

        {{-- Pesan Dinamis --}}
        <template x-if="selected">
            <div class="mt-2 text-sm text-gray-600">
                <template x-if="selected.includes('_va')">
                    <p>Setelah klik “Bayar Sekarang”, kamu akan mendapatkan nomor Virtual Account untuk transfer.</p>
                </template>

                <template x-if="selected === 'mandiri_bill'">
                    <p>Setelah klik “Bayar Sekarang”, kamu akan mendapatkan Bill Key dan Biller Code untuk pembayaran.</p>
                </template>

                <template x-if="selected === 'qris'">
                    <p>Setelah klik “Bayar Sekarang”, kamu akan diarahkan ke halaman QRIS untuk melakukan pembayaran.</p>
                </template>

                <template x-if="['gopay', 'shopeepay'].includes(selected)">
                    <p>Setelah klik “Bayar Sekarang”, kamu akan diarahkan ke aplikasi e-wallet pilihanmu.</p>
                </template>
            </div>
        </template>

        {{-- Tombol Submit --}}
        <button type="submit" 
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
                x-bind:disabled="!selected || loading">
            <span x-show="!loading" x-text="selected ? 'Bayar Sekarang' : 'Pilih Metode Pembayaran'"></span>
            <span x-show="loading">Memproses...</span>
        </button>
    </form>

    {{-- Hasil VA --}}
    <template x-if="result && result.type === 'va'">
        <div class="mt-5 p-4 bg-green-50 border border-green-300 rounded">
            <h3 class="text-lg font-semibold mb-2">Nomor Virtual Account</h3>
            <p class="text-gray-700 mb-1">Bank: <span class="font-bold" x-text="result.bank"></span></p>
            <p class="text-gray-700 mb-1">Nomor VA: 
                <span class="font-mono text-blue-600 text-xl" x-text="result.va_number"></span>
            </p>
            <p>Total: Rp <span x-text="result.amount"></span></p>
        </div>
    </template>

    {{-- Hasil Mandiri Bill --}}
    <template x-if="result && result.type === 'mandiri'">
        <div class="mt-5 p-4 bg-yellow-50 border border-yellow-300 rounded">
            <h3 class="text-lg font-semibold mb-2">Mandiri Bill Payment</h3>
            <p>Bill Key: <span class="font-mono text-blue-600" x-text="result.bill_key"></span></p>
            <p>Biller Code: <span class="font-mono text-blue-600" x-text="result.biller_code"></span></p>
            <p>Total: Rp <span x-text="result.amount"></span></p>
        </div>
    </template>
</div>

{{-- Alpine.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
function paymentForm() {
    return {
        selected: '',
        result: null,
        loading: false,

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
                } else if (data.status === 'redirect') {
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
@endsection
