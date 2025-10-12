{{-- etiket --}}
<div class="bg-white w-full max-w-4xl mx-auto border border-gray-300 p-6 sm:p-8 md:p-10 shadow-xl rounded-2xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div class="order-2 md:order-1">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">E-Ticket</h1>
            <p class="text-sm text-gray-500 mt-1">Taman Rekreasi Selecta</p>
        </div>
        
        <div class="order-1 md:order-2 mx-auto md:mx-0">
            <img src="{{ asset('assets/customer/selecta-logo1.png') }}" alt="Logo Selecta" 
                 class="h-12 sm:h-16 mx-auto">
        </div>
        
        <div class="order-3 text-center md:text-right w-full md:w-auto">
            <p class="text-xl sm:text-2xl md:text-3xl font-extrabold tracking-widest text-gray-900 break-all">
                {{ $transaction->code }}
            </p>
            <p class="text-xs text-gray-500 mt-1">Kode Pemesanan</p>
        </div>
    </div>

    <div class="w-full h-0.5 rounded-lg bg-gray-300 mb-6 sm:mb-8"></div>

    <!-- Informasi Pengguna -->
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-10 mb-8 text-gray-800">
        <div class="flex-1 space-y-3 text-sm sm:text-base">
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                <span class="font-semibold min-w-24">Nama</span>
                <span>: {{ $transaction->customer->name }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                <span class="font-semibold min-w-24">Email</span>
                <span>: {{ $transaction->customer->email }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                <span class="font-semibold min-w-24">No. Telp</span>
                <span>: {{ $transaction->customer->telephone ?? '-' }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                <span class="font-semibold min-w-24">Tanggal Kunjungan</span>
                <span>: {{ \Carbon\Carbon::parse($transaction->tanggal_kedatangan)->translatedFormat('d F Y') }}</span>
            </div>
        </div>
        
        <div class="flex justify-center items-center">
            @if($transaction->status === 'paid')
                <div class="bg-white p-2 rounded-lg border border-gray-200">
                    {!! QrCode::size(120)->generate($qrCode) !!}
                </div>
            @else
                <div class="h-32 w-32 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                    <span class="text-gray-400 text-xs text-center">QR Code<br>Belum Tersedia</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Detail Tiket -->
    <div class="border border-gray-200 rounded-lg mb-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm sm:text-base">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-semibold text-gray-700">Jenis Tiket</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3 text-center font-semibold text-gray-700">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($transaction->transactionDetail as $detail)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $detail->ticket->name ?? 'Tiket' }}</td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3 text-center font-medium">{{ $detail->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tata Cara Penggunaan -->
    <div class="text-sm leading-relaxed mb-6 text-gray-700">
        <p class="font-semibold text-gray-900 mb-3">TATA CARA PENGGUNAAN :</p>
        <ol class="list-decimal list-inside space-y-2 pl-2">
            <li class="pl-1">Tunjukkan e-ticket ini kepada petugas saat tiba di lokasi</li>
            <li class="pl-1">Pastikan QR Code dapat terlihat jelas untuk dipindai</li>
            <li class="pl-1">Petugas akan memverifikasi sebelum masuk</li>
            <li class="pl-1">QR Code hanya dapat digunakan sekali untuk masuk</li>
            <li class="pl-1">Jaga kerahasiaan e-ticket Anda</li>
        </ol>
    </div>

    <!-- Catatan -->
    <div class="text-sm border-t border-gray-300 pt-4 text-gray-700">
        <p class="font-semibold text-gray-900 mb-2">CATATAN :</p>
        <ul class="list-disc list-inside space-y-1 pl-2">
            <li class="pl-1">E-tiket berlaku sesuai tanggal kunjungan</li>
            <li class="pl-1">Tidak dapat direfund atau diubah jadwal</li>
            <li class="pl-1">Pastikan data sudah sesuai sebelum datang</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="mt-6 pt-4 border-t border-gray-400 text-center text-xs text-gray-600">
        <p>Butuh bantuan? Hubungi <span class="font-semibold">0341-591025</span> atau 
           <span class="font-semibold">marketing@selecta.com</span></p>
    </div>
</div>