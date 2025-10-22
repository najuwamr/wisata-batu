@extends('layouts.admin')

@section('title', '| Laporan')

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

    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center text-black px-4 py-2 rounded-full space-x-2 shadow-md">
            <input type="text" placeholder="Cari Laporan"
                    class="bg-transparent focus:outline-none text-sm placeholder-black w-32 lg:w-40">
            <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
            </svg>
        </div>

        <div class="flex cursor-pointer items-center bg-green-100 hover:bg-green-200 text-black px-4 py-2 rounded-md space-x-2 shadow-md">
            <p>Lihat Spreadsheet</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                    <path d="M15 2.5V4c0 1.414 0 2.121.44 2.56C15.878 7 16.585 7 18 7h1.5"/>
                    <path d="M4 16V8c0-2.828 0-4.243.879-5.121C5.757 2 7.172 2 10 2h4.172c.408 0 .613 0 .797.076c.183.076.328.22.617.51l3.828 3.828c.29.29.434.434.51.618c.076.183.076.388.076.796V16c0 2.828 0 4.243-.879 5.121C18.243 22 16.828 22 14 22h-4c-2.828 0-4.243 0-5.121-.879C4 20.243 4 18.828 4 16"/>
                    <path d="M12 11v3m0 0v3m0-3H7.5m4.5 0h4.5m-7 3h5c.943 0 1.414 0 1.707-.293s.293-.764.293-1.707v-2c0-.943 0-1.414-.293-1.707S15.443 11 14.5 11h-5c-.943 0-1.414 0-1.707.293S7.5 12.057 7.5 13v2c0 .943 0 1.414.293 1.707S8.557 17 9.5 17"/>
                </g>
            </svg>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full cursor-default bg-blue-100 border-t border-b border-white rounded-lg shadow-md overflow-hidden">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-4 py-2 border-b-4 border-gray-100">Kode Transaksi</th>
                    <th class="px-4 py-2 border-b-4 border-gray-100">Tanggal Kedatangan</th>
                    <th class="px-4 py-2 border-b-4 border-gray-100">Nama</th>
                    <th class="px-4 py-2 border-b-4 border-gray-100">Tiket</th>
                    <th class="px-4 py-2 border-b-4 border-gray-100">Status</th>
                    <th class="px-4 py-2 border-b-4 border-gray-100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr class="text-center hover:bg-blue-50">
                    <td class="px-4 py-2 border-b-4 border-gray-100">{{ $transaction->code }}</td>
                    <td class="px-4 py-2 border-b-4 border-gray-100">
                        {{ \Carbon\Carbon::parse($transaction->tanggal_kedatangan, 'Asia/Jakarta')->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-4 py-2 border-b-4 border-gray-100">{{ $transaction->customer->name ?? '-' }}</td>
                    <td class="px-4 py-2 border-b-4 border-gray-100 text-left">
                        <ul class="list-disc list-inside">
                            @foreach($transaction->transactionDetail as $detail)
                                <li>{{ $detail->ticket->name ?? '-' }} ({{ $detail->quantity }}x)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-4 py-2 border-b-4 border-gray-100">{{ $transaction->status ?? '-' }}</td>
                    <td class="px-4 py-2 border-b-4 border-gray-100">
                        <a href="#" class="text-blue-700 font-semibold hover:underline">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- pagination --}}
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
