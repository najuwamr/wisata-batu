@extends('layouts.admin')

@section('title', '| Manajemen Tiket')

@section('content')
<div class="md:ml-64 min-h-screen bg-gradient-to-br from-gray-50 to-blue-50" x-data="{
    showNonAktif: false
}">
    <div class="sticky top-0 bg-white/80 backdrop-blur-md shadow-sm z-10 px-6 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">
                    Manajemen Tiket
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

            <div class="mt-4 md:mt-0 flex gap-3">
                <a href="{{ route('admin.promo.get') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span class="font-semibold">Kelola Promo</span>
                </a>

                <a href="{{ route('admin.tiket.tambah') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="font-semibold">Tambah Tiket</span>
                </a>
            </div>
        </div>
    </div>

    <div class="px-6 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Tiket</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $tiketAktif->count() + $tiketNonAktif->count() }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Semua tiket</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Tiket Aktif</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $tiketAktif->count() }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Tersedia untuk dijual</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-gray-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Tiket Nonaktif</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $tiketNonAktif->count() }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Tidak ditampilkan</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Tiket Aktif</h2>
                        <p class="text-sm text-gray-600">Tiket yang tersedia untuk dijual</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold border border-green-200">
                        {{ $tiketAktif->count() }} Tiket
                    </span>
                </div>

                <div class="p-6">
                    @if($tiketAktif->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="activeTickets">
                            @foreach ($tiketAktif as $tiket)
                                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 group ticket-card" data-name="{{ strtolower($tiket->name) }}">
                                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                        <img src="{{ asset('images/' . $tiket->image) }}"
                                             alt="{{ $tiket->name }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-green-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                                Aktif
                                            </span>
                                        </div>
                                        <div class="absolute bottom-3 left-3 right-3">
                                            <h3 class="text-lg font-bold text-white drop-shadow-lg">{{ $tiket->name }}</h3>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                                <p class="text-xl font-bold text-blue-600">
                                                    Rp{{ number_format($tiket->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold border border-blue-200">
                                                {{ ucfirst($tiket->category) }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-3 gap-2">
                                            <button onclick='showDetail(@json($tiket))'
                                                class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-2 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:scale-105"
                                                title="Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </button>

                                            <a href="{{ route('admin.tiket.edit', $tiket->id) }}"
                                                class="bg-yellow-50 hover:bg-yellow-100 text-yellow-600 p-2 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:scale-105"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('admin.tiket.delete', $tiket->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menonaktifkan tiket ini?');">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:scale-105"
                                                    title="Nonaktifkan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Tiket Aktif</h3>
                            <p class="text-gray-500 mb-6">Mulai tambahkan tiket untuk ditampilkan kepada pengunjung</p>
                            <a href="{{ route('admin.tiket.tambah') }}"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Tiket Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Tiket Nonaktif</h2>
                        <p class="text-sm text-gray-600">Tiket yang dinonaktifkan sementara</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-semibold border border-gray-200">
                            {{ $tiketNonAktif->count() }} Tiket
                        </span>
                        <button @click="showNonAktif = !showNonAktif"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg font-medium transition-all duration-200 shadow-sm border border-gray-200">
                            <span x-text="showNonAktif ? 'Sembunyikan' : 'Tampilkan'"></span>
                            <svg class="w-5 h-5 transition-transform duration-300"
                                 :class="{ 'rotate-180': showNonAktif }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="showNonAktif"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-cloak
                 class="p-6">
                @if($tiketNonAktif->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($tiketNonAktif as $tiket)
                            <div class="bg-gray-50 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-300">
                                <div class="relative h-48 overflow-hidden bg-gray-200">
                                    <img src="{{ asset('images/' . $tiket->image) }}"
                                         alt="{{ $tiket->name }}"
                                         class="w-full h-full object-cover grayscale opacity-60">
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="bg-gray-700 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                            Nonaktif
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <div class="mb-3">
                                        <h3 class="text-lg font-bold text-gray-700">{{ $tiket->name }}</h3>
                                        <span class="inline-block bg-gray-200 text-gray-600 px-3 py-1 rounded-lg text-xs font-semibold mt-2">
                                            {{ ucfirst($tiket->category) }}
                                        </span>
                                    </div>

                                    <div class="space-y-2">
                                        <form action="{{ route('admin.tiket.restore', $tiket->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                                Aktifkan Kembali
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.tiket.destroy', $tiket->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus tiket ini secara permanen? Tindakan ini tidak dapat dibatalkan!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">Semua tiket dalam kondisi aktif</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="detailModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <div class="relative h-64">
            <img id="modalImage" src="" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

            <div class="absolute bottom-6 left-6 right-6">
                <h2 id="modalName" class="text-3xl font-bold text-white mb-2"></h2>
                <div class="flex items-center gap-3">
                    <span id="modalCategory" class="bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-semibold"></span>
                    <span id="modalPrice" class="text-white text-2xl font-bold"></span>
                </div>
            </div>
        </div>

        <div class="p-6 overflow-y-auto max-h-96">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Deskripsi</h3>
                <p id="modalDescription" class="text-gray-600 leading-relaxed"></p>
            </div>

            <div id="modalFasilitas" class="mb-6 hidden">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Fasilitas</h3>
                <div id="fasilitasList" class="grid grid-cols-1 md:grid-cols-2 gap-2"></div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
            <button onclick="closeDetail()"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
function showDetail(ticket) {
    const modal = document.getElementById('detailModal');

    document.getElementById('modalImage').src = '/images/' + ticket.image;
    document.getElementById('modalImage').alt = ticket.name;

    document.getElementById('modalName').textContent = ticket.name;
    document.getElementById('modalCategory').textContent = ticket.category;
    document.getElementById('modalPrice').textContent = 'Rp' + ticket.price.toLocaleString('id-ID');
    document.getElementById('modalDescription').textContent = ticket.description || '-';

    const fasilitasContainer = document.getElementById('modalFasilitas');
    const fasilitasList = document.getElementById('fasilitasList');

    if (ticket.aset && ticket.aset.length > 0) {
        fasilitasContainer.classList.remove('hidden');
        fasilitasList.innerHTML = '';

        ticket.aset.forEach(fasilitas => {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 bg-blue-50 px-3 py-2 rounded-lg';
            div.innerHTML = `
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm text-gray-700">${fasilitas.name}</span>
            `;
            fasilitasList.appendChild(div);
        });
    } else {
        fasilitasContainer.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDetail() {
    const modal = document.getElementById('detailModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
