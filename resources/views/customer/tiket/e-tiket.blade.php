@extends('layouts.guest')

@section('title', 'E-Ticket')

@section('content')
<section class="flex justify-center items-center min-h-screen bg-gray-100 py-10">
    <div class="bg-white w-full max-w-4xl border-1 border-black p-10 shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold">E-Ticket</h1>
            </div>
            <!-- Logo -->
            <div>
                <img src="{{ asset('assets/customer/selecta-logo1.png') }}" alt="Logo Selecta" class="h-20">
            </div>
            <div class="text-right">
                <p class="text-3xl font-extrabold tracking-wider">ABC123</p>
            </div>
        </div>

        <div class="w-full h-0.5 rounded-lg bg-black mb-8"></div>


        <!-- Informasi Pengguna -->
        <div class="grid grid-cols-2 gap-x-10 mb-8 text-xl">
            <div>
                <p><span class="font-semibold">Nama</span> : Najwa Maulida</p>
                <p><span class="font-semibold">Email</span> : najwamaulida@gmail.com</p>
                <p><span class="font-semibold">No.Telp</span> : 08123456789</p>
            </div>
            <div class="flex justify-center">
                <img src="{{ asset('images/qr-placeholder.png') }}" alt="QR Code" class="h-40 w-40">
            </div>
        </div>

        <!-- Detail Tiket -->
        <div class="border border-gray-300 rounded-md mb-6 overflow-hidden text-base">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-2">Item</th>
                        <th class="px-4 py-2">Qty</th>
                        <th class="px-4 py-2 text-right">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-4 py-2">Tiket Reguler</td>
                        <td class="px-4 py-2">3x</td>
                        <td class="px-4 py-2 text-right">Rp. 150.000</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">Paket Wahana</td>
                        <td class="px-4 py-2">3x</td>
                        <td class="px-4 py-2 text-right">Rp. 240.000</td>
                    </tr>
                    <tr class="border-b bg-green-50">
                        <td class="px-4 py-2">Mobil</td>
                        <td class="px-4 py-2">1x</td>
                        <td class="px-4 py-2 text-right">Rp. 10.000</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">PROMO</td>
                        <td class="px-4 py-2 font-semibold text-green-700">BANKBCA</td>
                        <td class="px-4 py-2 text-right text-green-700">- Rp. 10.000</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td colspan="2" class="px-4 py-2 font-bold text-right">TOTAL</td>
                        <td class="px-4 py-2 font-bold text-right">Rp. 390.000</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tata Cara Penggunaan -->
        <div class="text-sm leading-relaxed mb-6">
            <p class="font-semibold mb-2">TATA CARA PENGGUNAAN :</p>
            <ol class="list-decimal list-inside space-y-1">
                <li>Tunjukkan e-ticket ini kepada petugas tiket saat tiba di area Taman Rekreasi Selecta.</li>
                <li>Posisikan QR Code pada e-ticket dengan benar agar dapat dipindai oleh sistem.</li>
                <li>Petugas tiket akan melakukan pemindaian QR Code untuk memverifikasi tiket Anda.</li>
                <li>Setelah QR Code diverifikasi, Anda dapat langsung masuk ke area wisata.</li>
                <li>Pihak Selecta tidak bertanggung jawab atas kehilangan kode QR ini maupun e-ticket yang sudah diverifikasi.</li>
            </ol>
        </div>

        <!-- Catatan -->
        <div class="text-sm border-t border-gray-300 pt-4">
            <p class="font-semibold mb-2">Note :</p>
            <ul class="list-disc list-inside space-y-1">
                <li>E-tiket berlaku 7 hari sejak tanggal kunjungan.</li>
                <li>E-tiket hanya berlaku untuk satu kali kunjungan.</li>
                <li>Refund tiket tidak diperkenankan.</li>
                <li>Reschedule tidak diperkenankan.</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="mt-6 border-t border-black pt-4 text-center text-xs text-gray-800">
            <p>Silahkan Hubungi Kami Jika Terdapat Kendala 0341591025 atau (email marketing)</p>
        </div>
    </div>
</section>
@endsection
