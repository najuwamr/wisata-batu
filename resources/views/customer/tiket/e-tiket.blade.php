{{-- E-Ticket Responsif --}}
<div id="etiket" class="bg-white w-full mx-auto border px-4 sm:px-6">
    <!-- Header -->
    <div class="flex flex-row justify-between items-center gap-4">
        <!-- Info kiri -->
        <div class="w-full md:w-auto text-left">
            <h1 class="text-md sm:text-xl font-extrabold">E-Ticket</h1>
            <p class="text-xs sm:text-sm font-extralight">Taman Rekreasi Selecta</p>
        </div>

        <!-- Logo tengah -->
        <div class="mx-0">
            <img src="{{ asset('assets/customer/selecta-logo1.png') }}" alt="Logo Selecta"
                 class="h-18 my-0.5 mx-auto object-contain">
        </div>

        <!-- Kode kanan -->
        <div class="w-full md:w-auto text-right">
            <p class="text-md sm:text-xl font-extrabold">
                {{ $transaction->code }}
            </p>
            <p class="text-xs sm:text-sm font-extralight">Kode Pemesanan</p>
        </div>
    </div>

    <div class="w-full h-[1px] bg-black mb-6"></div>

    <!-- Informasi Pengguna -->
    <div class="flex flex-row gap-6 mb-8">
        <div class="flex-1 space-y-3 text-sm sm:text-base">
            <div class="flex flex-row sm:items-center gap-1 sm:gap-2">
                <span class="font-semibold min-w-[100px]">Nama</span>
                <span>: {{ $transaction->customer->name }}</span>
            </div>
            <div class="flex flex-row sm:items-center gap-1 sm:gap-2">
                <span class="font-semibold min-w-[100px]">Email</span>
                <span class="break-all">: {{ $transaction->customer->email }}</span>
            </div>
            <div class="flex flex-row sm:items-center gap-1 sm:gap-2">
                <span class="font-semibold min-w-[100px]">No. Telp</span>
                <span>: {{ $transaction->customer->telephone ?? '-' }}</span>
            </div>
            <div class="flex flex-row sm:items-center gap-1 sm:gap-2">
                <span class="font-semibold min-w-[100px]">Tanggal Kunjungan</span>
                <span>: {{ \Carbon\Carbon::parse($transaction->tanggal_kedatangan)->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <div class="flex justify-center items-center mx-auto lg:mx-0">
            @if($transaction->status === 'paid')
                <div class="bg-white p-2 rounded-md border ">
                    {!! QrCode::size(120)->generate($qrCode) !!}
                </div>
            @else
                <div class="h-28 w-28 sm:h-32 sm:w-32 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                    <span class="text-xs font-extralight text-center">QR Code<br>Belum Tersedia</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Detail Tiket -->
    <div class="ticket-table border rounded-sm mb-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs sm:text-sm md:text-base">
                <thead class="bg-black/5 border-b border-black">
                    <tr>
                        <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-semibold whitespace-nowrap">Jenis Tiket</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3 text-center font-semibold whitespace-nowrap">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
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

    <!-- Footer -->
    <div class="mt-6 mb-2 pt-4 border-t text-center text-[11px] sm:text-xs leading-relaxed">
        <p>
            Butuh bantuan? Hubungi
            <span class="font-semibold">0341-591025</span>
            atau
            <span class="font-semibold">marketing@selecta.com</span>
        </p>
    </div>
</div>
