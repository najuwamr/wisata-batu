@extends('layouts.loket')

@section('content')
<div class="md:ml-64">
    <div class="sticky top-0 bg-white">
        <h1 class="pt-10 ml-2 text-3xl font-bold mb-2">
            {{ now()->translatedFormat('l, d F Y') }}
        </h1>

        @php
            $hour = now()->format('H');
            if ($hour < 10) {
                $greeting = 'pagi';
            } elseif ($hour < 14) {
                $greeting = 'siang';
            } elseif ($hour < 17) {
                $greeting = 'sore';
            } else {
                $greeting = 'malam';
            }
        @endphp

        <p class="underline ml-2">Selamat {{ $greeting }} admin Selecta!</p>
        <div class="w-full h-2 rounded-lg bg-gray-200 my-4"></div>
    </div>

    <h1 class="text-2xl font-bold mb-4">Scan QR Code Tiket</h1>

    {{-- Bagian kamera --}}
    <div id="reader" style="width: 400px;"></div>

    {{-- Form upload file QR --}}
    <form id="manual-form" method="POST" action="{{ route('loket.scan.decode') }}" enctype="multipart/form-data" class="mt-4">
        @csrf
        <input type="file" name="qr_image" accept="image/*" class="border p-2 rounded">
        <button class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Upload & Decode</button>
    </form>

    {{-- Tampilkan pesan error --}}
    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Hasil Scan --}}
    @isset($transaction)
        <div class="bg-white p-4 rounded shadow mt-6">
            <h2 class="text-xl font-semibold mb-3">Hasil Scan</h2>
            <p><strong>Kode Transaksi:</strong> {{ $transaction->code }}</p>
            <p><strong>Nama:</strong> {{ $transaction->customer->name }}</p>
            <p><strong>Email:</strong> {{ $transaction->customer->email }}</p>
            <p><strong>Status:</strong> {{ ucfirst($transaction->status ?? '-') }}</p>
            <p><strong>Total Tiket:</strong> {{ $transaction->transactionDetail->count() }}</p>
        </div>
    @endisset
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
const scanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
scanner.render((decodedText) => {
    // Kirim hasil scan langsung ke backend tanpa reload penuh
    fetch("{{ route('loket.scan.decode') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ code: decodedText })
    })
    .then(res => res.text())
    .then(html => {
        document.body.innerHTML = html; // replace page dengan hasil baru
    });
});
</script>
@endsection
