{{-- E-Ticket Responsif untuk html2canvas --}}
<div id="etiket" style="background-color: #ffffff; border: 2px solid #1f2937;" class="w-full max-w-4xl mx-auto p-4 sm:p-6">
    <!-- Header -->
    <div class="grid grid-cols-3 gap-2 sm:gap-4 items-center mb-4">
        <!-- Info kiri -->
        <div class="text-left">
            <h1 class="text-sm sm:text-lg md:text-xl font-bold">E-Ticket</h1>
            <p class="text-xs sm:text-sm">Taman Rekreasi Selecta</p>
        </div>

        <!-- Logo tengah -->
        <div class="flex justify-center">
            <img src="{{ asset('assets/customer/selecta-logo1.png') }}" alt="Logo Selecta"
                class="h-12 sm:h-16 md:h-20 w-auto object-contain">
        </div>

        <!-- Kode kanan -->
        <div class="text-right">
            <p class="text-sm sm:text-lg md:text-xl font-bold break-words">
                {{ $transaction->code }}
            </p>
            <p class="text-xs sm:text-sm">Kode Tiket</p>
        </div>
    </div>

    <div class="w-full h-px mb-4" style="background-color: #1f2937; height: 1px;"></div>

    <!-- Informasi Pengguna & QR Code -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <!-- Info Pengguna (2/3 width pada desktop) -->
        <div class="sm:col-span-2 space-y-2 text-xs sm:text-sm">
            <div class="flex">
                <span class="font-semibold w-32 sm:w-36 shrink-0">Nama</span>
                <span class="flex-1">: {{ $transaction->customer->name }}</span>
            </div>
            <div class="flex">
                <span class="font-semibold w-32 sm:w-36 shrink-0">Email</span>
                <span class="flex-1 break-all">: {{ $transaction->customer->email }}</span>
            </div>
            <div class="flex">
                <span class="font-semibold w-32 sm:w-36 shrink-0">No. Telp</span>
                <span class="flex-1">: {{ $transaction->customer->telephone ?? '-' }}</span>
            </div>
            <div class="flex">
                <span class="font-semibold w-32 sm:w-36 shrink-0">Tanggal Kunjungan</span>
                <span class="flex-1">: {{ \Carbon\Carbon::parse($transaction->tanggal_kedatangan)->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <!-- QR Code (1/3 width pada desktop, centered pada mobile) -->
        <div class="flex justify-center items-center">
            @if ($transaction->status === 'paid')
                <div style="background-color: #ffffff; border: 2px solid #d1d5db; padding: 8px;" class="inline-block">
                    {!! QrCode::size(100)->generate($qrCode) !!}
                </div>
            @else
                <div style="background-color: #f9fafb; border: 2px dashed #9ca3af;" class="h-24 w-24 sm:h-28 sm:w-28 flex items-center justify-center">
                    <span class="text-xs text-center" style="color: #4b5563;">QR Code<br>Belum Tersedia</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Detail Tiket -->
    <div style="border: 2px solid #1f2937; background-color: #ffffff;" class="mb-6 overflow-hidden">
        <table class="w-full text-xs sm:text-sm">
            <thead style="background-color: #f3f4f6; border-bottom: 2px solid #1f2937;">
                <tr>
                    <th class="px-3 py-2 text-left font-semibold" style="color: #000000;">Jenis Tiket</th>
                    <th class="px-3 py-2 text-center font-semibold w-24 sm:w-32" style="color: #000000;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->transactionDetail as $detail)
                    <tr style="border-bottom: 1px solid #d1d5db;">
                        <td class="px-3 py-2" style="color: #000000;">{{ $detail->ticket->name ?? 'Tiket' }}</td>
                        <td class="px-3 py-2 text-center font-semibold" style="color: #000000;">{{ $detail->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="pt-3 text-center text-xs sm:text-sm" style="border-top: 2px solid #1f2937; color: #000000;">
        <p>
            Butuh bantuan? Hubungi
            <span class="font-semibold">0341-591025</span>
            atau
            <span class="font-semibold">marketing@selecta.com</span>
        </p>
    </div>
</div>
