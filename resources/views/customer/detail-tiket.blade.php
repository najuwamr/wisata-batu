@extends('layouts.guest')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">Detail Tiket</h1>

    @if(!empty($tiket->image))
        <img src="{{ asset('images/' . $tiket->image) }}"
             class="w-full h-64 object-contain rounded border mb-4"
             alt="Gambar Tiket">
    @else
        <div class="w-full h-64 flex items-center justify-center rounded border mb-4 text-gray-500 font-semibold">
            Gambar tidak tersedia
        </div>
    @endif

    <p><strong>Nama:</strong> {{ $tiket->name }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($tiket->price, 0, ',', '.') }}</p>
    <p><strong>Kategori:</strong> {{ ucfirst($tiket->category) }}</p>

    <div class="mt-4">
        <p><strong>Deskripsi:</strong></p>
        <div class="detailDeskripsi max-w-none">
            {!! $tiket->description !!}
        </div>
    </div>

    {{-- Tombol kembali --}}
    <div class="mt-6">
        <a href="{{ route('guest.tiket') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Kembali
        </a>
    </div>

    <div class="mt-6">
        <a href="{{ route('guest.keranjang') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Pesan Sekarang
        </a>
    </div>
</div>
@endsection
