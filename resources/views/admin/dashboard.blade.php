@extends('layouts.admin')

@section('title', '| Dashboard')

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

    <h1 class="text-3xl font-bold mb-6">Transaksi Tiket Hari ini</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-20">
        @foreach ($jenisTiket as $ticket)
            @php
                $bgColors = [
                    'Tiket Reguler' => 'bg-green-100 text-green-900',
                    'Tiket Paket Wahana' => 'bg-blue-100 text-blue-900',
                    'Mobil' => 'bg-yellow-100 text-yellow-900',
                    'Bus' => 'bg-red-100 text-red-900',
                    'Motor' => 'bg-pink-100 text-pink-900',
                ];
                $classes = $bgColors[$ticket->name] ?? 'bg-gray-100 text-gray-900';
            @endphp

            <div class="flex flex-col items-center">
                <div class="rounded-2xl shadow-lg p-12 text-center w-full h-48 {{ $classes }}">
                    <p class="text-6xl font-extrabold">0</p>
                </div>
                <p class="mt-4 font-semibold {{ $classes }} px-3 py-1 rounded text-lg">
                    {{ $ticket->short_name }}
                </p>
            </div>
        @endforeach
    </div>

    <h1 class="pt-10 text-3xl font-bold mb-2">Grafik Pendapatan per Bulan</h1>

    <canvas id="tiketChart" class="w-full pt-3 max-w-4xl mx-auto"></canvas>

    <script>
        const ctx = document.getElementById('tiketChart').getContext('2d');

        const tiketChart = new Chart(ctx, {
            type: 'bar',
                data: {
                        labels: @json($labels),
                        datasets: [
                    {
                        label: 'Paket Wahana',
                        data: @json($paket),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    },
                    {
                        label: 'Tiket Reguler',
                        data: @json($reguler),
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    x: { title: { display: true, text: 'Bulan' } },
                    y: { title: { display: true, text: 'Jumlah Tiket Terjual' }, beginAtZero: true }
                }
            }
        });
    </script>
</div>
@endsection
