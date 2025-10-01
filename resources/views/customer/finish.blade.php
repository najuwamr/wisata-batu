@extends('layouts.guest')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg mt-10 text-center">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">Status Pembayaran</h1>
    <p class="text-lg">{{ $message }}</p>

    <a href="/" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Kembali ke Beranda
    </a>
</div>
@endsection
