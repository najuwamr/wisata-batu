@extends('layouts.admin')

@section('title', '| Dashboard')

@section('content')
<div class="md:ml-64 min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Header Section -->
    <div class="sticky top-0 bg-white/80 backdrop-blur-md shadow-sm z-10 px-6 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">
                    Dashboard Overview
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
                    <span>Selamat {{ $greeting }}, Admin Selecta!</span>
                    <span class="hidden md:inline text-gray-400">•</span>
                    <span class="hidden md:inline text-sm">{{ now()->translatedFormat('l, d F Y') }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="px-6 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Transaksi Hari Ini -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Transaksi</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $totalTransaksi }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Dalam periode terpilih</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pengunjung Hari Ini -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Pengunjung</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $totalPengunjung }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Jumlah orang</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pendapatan -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Pendapatan</p>
                        <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Dalam periode terpilih</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tiket Terjual -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Tiket Terjual</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $tiketTerjual }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Dalam periode terpilih</p>
                    </div>
                    <div class="bg-orange-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div class="md:col-span-2 lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                        <select name="period" id="periodFilter"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="7days" {{ request('period') == '7days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                            <option value="30days" {{ request('period') == '30days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                            <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                </div>

                <div id="customDateRange" class="grid grid-cols-1 md:grid-cols-2 gap-4 {{ request('period') == 'custom' ? '' : 'hidden' }}">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-colors flex items-center gap-2 font-medium shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Terapkan
                    </button>
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors flex items-center gap-2 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('periodFilter').addEventListener('change', function() {
                const customDate = document.getElementById('customDateRange');
                if (this.value === 'custom') {
                    customDate.classList.remove('hidden');
                } else {
                    customDate.classList.add('hidden');
                }
            });
        </script>

        <!-- Tiket Stats -->
        <div class="mb-6">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">Penjualan Tiket</h2>
                    <p class="text-sm text-gray-600">Statistik per jenis tiket</p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach ($tiket_stats as $tiket)
                            <div class="bg-white rounded-xl border-2 border-blue-200 p-6 text-center hover:shadow-lg transition-shadow">
                                <div class="bg-blue-100 rounded-lg p-6 mb-3">
                                    <p class="text-4xl font-bold text-blue-600">{{ $tiket['qty'] }}</p>
                                </div>
                                <p class="font-semibold text-gray-700 text-sm">{{ $tiket['name'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
