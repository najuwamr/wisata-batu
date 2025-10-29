@extends('layouts.loket')

@section('content')
<div class="md:ml-64 min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Header Section -->
    <div class="sticky top-0 bg-white/80 backdrop-blur-md shadow-sm z-10 px-6 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">
                    Scan QR Code Tiket
                </h1>

                @php
                    $hour = now()->format('H');
                    if ($hour < 10) {
                        $greeting = 'pagi';
                        $icon = '🌅';
                    } elseif ($hour < 14) {
                        $greeting = 'siang';
                        $icon = '☀️';
                    } elseif ($hour < 17) {
                        $greeting = 'sore';
                        $icon = '🌤️';
                    } else {
                        $greeting = 'malam';
                        $icon = '🌙';
                    }
                @endphp

                <p class="text-gray-600 flex items-center gap-2">
                    <span>{{ $icon }}</span>
                    <span>Selamat {{ $greeting }}, Petugas Loket!</span>
                    <span class="hidden md:inline text-gray-400">•</span>
                    <span class="hidden md:inline text-sm">{{ now()->translatedFormat('l, d F Y') }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="px-6 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Scanner Section -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1 h-8 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Scan dengan Kamera</h2>
                        <p class="text-sm text-gray-600">Arahkan kamera ke QR code tiket</p>
                    </div>
                </div>

                <!-- QR Scanner -->
                <div id="reader" class="rounded-xl overflow-hidden border-2 border-gray-200"></div>

                <!-- Manual Upload -->
                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Atau Upload Gambar QR Code</h3>
                    <form id="uploadForm" method="POST" action="{{ route('loket.scan.decode') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="flex gap-2">
                            <input type="file"
                                name="qr_image"
                                id="qr_image"
                                accept="image/*"
                                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Result Section -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1 h-8 bg-gradient-to-b from-green-500 to-emerald-600 rounded-full"></div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Hasil Scan</h2>
                        <p class="text-sm text-gray-600">Detail informasi tiket</p>
                    </div>
                </div>

                <div id="resultContainer">
                    @if(session('error'))
                        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @elseif(session('success'))
                        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @elseif(isset($transaction))
                        <!-- Ticket Display -->
                        <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-gradient-to-br from-blue-50 to-indigo-50">
                            <!-- Header -->
                            <div class="text-center mb-6 pb-6 border-b-2 border-dashed border-gray-300">
                                <div class="inline-block bg-white px-6 py-3 rounded-xl shadow-md mb-3">
                                    <h3 class="text-2xl font-bold text-gray-800">{{ $transaction->code }}</h3>
                                </div>

                                @php
                                    $statusConfig = [
                                        'paid' => [
                                            'bg' => 'bg-green-500',
                                            'text' => 'Lunas - Siap Digunakan',
                                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                        ],
                                        'pending' => [
                                            'bg' => 'bg-yellow-500',
                                            'text' => 'Menunggu Pembayaran',
                                            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                        ],
                                        'failed' => [
                                            'bg' => 'bg-red-500',
                                            'text' => 'Gagal / Kadaluarsa',
                                            'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                        ],
                                        'redeemed' => [
                                            'bg' => 'bg-purple-500',
                                            'text' => session('success')
                                                ? 'Berhasil - Silakan Masuk'
                                                : 'Sudah Pernah Di-redeem',
                                            'icon' => session('success')
                                                ? 'M5 13l4 4L19 7' // centang
                                                : 'M6 18L18 6M6 6l12 12', // silang
                                        ],
                                    ];

                                    $status = $statusConfig[$transaction->status]
                                        ?? ['bg' => 'bg-gray-500', 'text' => ucfirst($transaction->status), 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
                                @endphp

                                <div class="inline-flex items-center gap-2 {{ $status['bg'] }} text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"/>
                                    </svg>
                                    {{ $status['text'] }}
                                </div>
                            </div>

                            <!-- Customer Info -->
                            <div class="space-y-4 mb-6">
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Nama Pemesan</p>
                                    <p class="text-lg font-bold text-gray-800">{{ $transaction->customer->name ?? '-' }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white rounded-xl p-4 shadow-sm">
                                        <p class="text-xs text-gray-500 mb-1">Email</p>
                                        <p class="text-sm font-semibold text-gray-800">{{ $transaction->customer->email ?? '-' }}</p>
                                    </div>
                                    <div class="bg-white rounded-xl p-4 shadow-sm">
                                        <p class="text-xs text-gray-500 mb-1">No. WA</p>
                                        <p class="text-sm font-semibold text-gray-800">{{ $transaction->customer->no_wa ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Tanggal Kedatangan</p>
                                    <p class="text-lg font-bold text-blue-600">
                                        {{ $transaction->tanggal_kedatangan ? $transaction->tanggal_kedatangan->translatedFormat('d F Y') : '-' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Tickets -->
                            <div class="bg-white rounded-xl p-4 shadow-sm mb-6">
                                <p class="text-xs text-gray-500 mb-3">Detail Tiket</p>
                                <div class="space-y-2">
                                    @foreach($transaction->transactionDetail as $detail)
                                        <div class="flex justify-between items-center bg-blue-50 p-3 rounded-lg">
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $detail->ticket->name ?? '-' }}</p>
                                                <p class="text-xs text-gray-500">{{ $detail->quantity }}x tiket</p>
                                            </div>
                                            <p class="text-sm font-bold text-blue-600">Rp{{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl p-4 shadow-lg mb-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm opacity-90">Total Pembayaran</p>
                                        <p class="text-3xl font-bold">Rp{{ number_format($transaction->total_price ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm opacity-90">Total Tiket</p>
                                        <p class="text-3xl font-bold">{{ $transaction->transactionDetail->sum('quantity') }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Action Button -->
                            @if($transaction->status === 'paid')
                                <form id="redeemForm" method="POST" action="{{ route('loket.redeem', $transaction->id) }}">
                                    @csrf
                                    <button type="button" 
                                        onclick="confirmRedeem()"
                                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Redeem Tiket Sekarang
                                    </button>
                                </form>
                            @elseif($transaction->status === 'redeemed')
                                <div class="bg-purple-100 border-2 border-purple-300 text-purple-800 px-6 py-4 rounded-xl text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-bold text-lg">Tiket Sudah Digunakan</p>
                                    <p class="text-sm mt-1">{{ $transaction->redeemed_at ? $transaction->redeemed_at->translatedFormat('d F Y, H:i') : '-' }}</p>
                                </div>
                            @else
                                <div class="bg-yellow-100 border-2 border-yellow-300 text-yellow-800 px-6 py-4 rounded-xl text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <p class="font-bold text-lg">Tiket Tidak Dapat Digunakan</p>
                                    <p class="text-sm mt-1">Status: {{ ucfirst($transaction->status) }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <svg class="w-24 h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Scan</h3>
                            <p class="text-gray-500">Scan QR code untuk melihat detail tiket</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
const html5QrCode = new Html5Qrcode("reader");

async function startCamera() {
    try {
        const devices = await Html5Qrcode.getCameras();
        if (devices && devices.length > 0) {
            const cameraId = devices[0].id;

            await html5QrCode.start(
                cameraId,
                { fps: 10, qrbox: 250 },
                (decodedText) => {
                    html5QrCode.stop();

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("loket.scan.decode") }}';

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';

                    const code = document.createElement('input');
                    code.type = 'hidden';
                    code.name = 'code';
                    code.value = decodedText;

                    form.appendChild(csrf);
                    form.appendChild(code);
                    document.body.appendChild(form);
                    form.submit();
                },
            );
        } else {
            document.getElementById('reader').innerHTML =
                "<p class='text-red-500 text-center'>Tidak ada kamera yang terdeteksi.</p>";
        }
    } catch (err) {
        document.getElementById('reader').innerHTML =
            "<p class='text-red-500 text-center'>Gagal memulai kamera.</p>";
        console.error(err);
    }
}

document.addEventListener("DOMContentLoaded", startCamera);

document.getElementById('qr_image')?.addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        const fileName = e.target.files[0].name;
        console.log('File selected:', fileName);
    }
});

function confirmRedeem() {
    if (confirm('Yakin ingin melakukan redeem tiket ini?\n\nTiket yang sudah di-redeem tidak dapat digunakan lagi.')) {
        document.getElementById('redeemForm').submit();
    }
}
</script>
@endsection
