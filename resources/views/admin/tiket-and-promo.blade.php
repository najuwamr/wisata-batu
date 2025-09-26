@extends('layouts.admin')

@section('title', '| Tiket & Promo')

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

    {{-- Alpine: sync dengan tab yang dikirim dari controller --}}
    <div x-data="{ active: '{{ $tab ?? 'tiket' }}' }">

        {{-- Tab Switch --}}
        <div class="inline-flex rounded-lg overflow-hidden border">
            <div class="bg-blue-200 p-2 gap-6 rounded-lg flex">
                <a href="{{ route('admin.get.tiket') }}">
                    <button
                        :class="active === 'tiket' ? 'bg-white border rounded-md cursor-pointer' : 'bg-blue-200 cursor-pointer'"
                        class="px-6 py-1 text-blue-900 font-semibold">
                        Tiket
                    </button>
                </a>
                <a href="{{ route('admin.get.promo') }}">
                    <button
                        :class="active === 'promo' ? 'bg-white border rounded-md cursor-pointer' : 'bg-blue-200 cursor-pointer'"
                        class="px-6 py-1 text-blue-900 font-semibold">
                        Promo
                    </button>
                </a>
            </div>
        </div>

        {{-- Toolbar kanan --}}
        <div class="flex justify-between lg:justify-end mt-6 lg:mt-1 items-center mb-6">
            {{-- Search --}}
            <div class="flex items-center text-black mx-4 px-4 py-2 rounded-full space-x-2 shadow-md">
                <input type="text" placeholder="Cari"
                       class="bg-transparent focus:outline-none text-sm placeholder-black w-32 lg:w-40">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
                </svg>
            </div>

            {{-- Tombol tambah dinamis --}}
            <div class="flex items-center bg-blue-200 text-black px-4 py-2 rounded-md space-x-2 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024">
                    <path fill="currentColor" d="M512 0C229.232 0 0 229.232 0 512c0 282.784 229.232 512 512 512c282.784 0 512-229.216 512-512C1024 229.232 794.784 0 512 0zm0 961.008c-247.024 0-448-201.984-448-449.01c0-247.024 200.976-448 448-448s448 200.977 448 448s-200.976 449.01-448 449.01zM736 480H544V288c0-17.664-14.336-32-32-32s-32 14.336-32 32v192H288c-17.664 0-32 14.336-32 32s14.336 32 32 32h192v192c0 17.664 14.336 32 32 32s32-14.336 32-32V544h192c17.664 0 32-14.336 32-32s-14.336-32-32-32z"/>
                </svg>
                <p x-text="active === 'tiket' ? 'Tambah Tiket' : 'Tambah Promo'"></p>
            </div>
        </div>

        {{-- Content Tiket --}}
        <div x-show="active === 'tiket'" x-cloak class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($data ?? [] as $ticket)
                <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                    <div class="h-40 flex items-center justify-center bg-gray-100">
                        @if($ticket->image)
                            <img src="{{ asset('storage/'.$ticket->image) }}"
                                 alt="{{ $ticket->name }}"
                                 class="object-cover h-full w-full">
                        @else
                            <span class="text-gray-600 font-semibold">Gambar</span>
                        @endif
                    </div>

                    <div class="bg-blue-200 p-4 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-blue-900">{{ $ticket->name }}</h3>
                            <p class="text-blue-900">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex space-x-2 text-blue-900">
                            <button class="hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16ZM96 40a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8v8H96Zm96 168H64V64h128Zm-80-104v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm48 0v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Z"/>
                                </svg>
                            </button>
                            <button class="hover:text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                                    <path fill="currentColor" d="M25 4.031c-.766 0-1.516.297-2.094.875L13 14.781l-.219.219l-.062.313l-.688 3.5l-.312 1.468l1.469-.312l3.5-.688l.312-.062l.219-.219l9.875-9.906A2.968 2.968 0 0 0 25 4.03zm0 1.938c.234 0 .465.12.688.343c.445.446.445.93 0 1.375L16 17.376l-1.719.344l.344-1.719l9.688-9.688c.222-.222.453-.343.687-.343zM4 8v20h20V14.812l-2 2V26H6V10h9.188l2-2z"/>
                                </svg>
                            </button>
                            <button class="hover:text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 472 384"><path fill="currentcolor" d="M235 32q79 0 142.5 44.5T469 192q-28 71-91.5 115.5T235 352T92 307.5T0 192q28-71 92-115.5T235 32zm0 267q44 0 75-31.5t31-75.5t-31-75.5T235 85t-75.5 31.5T128 192t31.5 75.5T235 299zm-.5-171q26.5 0 45.5 18.5t19 45.5t-19 45.5t-45.5 18.5t-45-18.5T171 192t18.5-45.5t45-18.5z"/></svg>                            
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Content Promo --}}
        <div x-show="active === 'promo'" x-cloak class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($promos ?? [] as $item)
                <div class="bg-blue-200 rounded-xl shadow-md overflow-hidden flex flex-col">
                    <div class="h-40 flex items-center justify-center bg-gray-100">
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}"
                                 alt="{{ $item->name }}"
                                 class="object-cover h-full w-full">
                        @else
                            <span class="text-gray-600 font-semibold">Gambar</span>
                        @endif
                    </div>

                    <div class="p-4 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-blue-900">{{ $item->name }}</h3>
                            <p class="text-blue-900">{{ $item->code }}</p>
                        </div>

                        <div class="flex space-x-2 text-blue-900">
                            <button class="hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16ZM96 40a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8v8H96Zm96 168H64V64h128Zm-80-104v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm48 0v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Z"/>
                                </svg>
                            </button>
                            <button class="hover:text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                                    <path fill="currentColor" d="M25 4.031c-.766 0-1.516.297-2.094.875L13 14.781l-.219.219l-.062.313l-.688 3.5l-.312 1.468l1.469-.312l3.5-.688l.312-.062l.219-.219l9.875-9.906A2.968 2.968 0 0 0 25 4.03zm0 1.938c.234 0 .465.12.688.343c.445.446.445.93 0 1.375L16 17.376l-1.719.344l.344-1.719l9.688-9.688c.222-.222.453-.343.687-.343zM4 8v20h20V14.812l-2 2V26H6V10h9.188l2-2z"/>
                                </svg>
                            </button>
                            <button class="hover:text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 472 384"><path fill="currentcolor" d="M235 32q79 0 142.5 44.5T469 192q-28 71-91.5 115.5T235 352T92 307.5T0 192q28-71 92-115.5T235 32zm0 267q44 0 75-31.5t31-75.5t-31-75.5T235 85t-75.5 31.5T128 192t31.5 75.5T235 299zm-.5-171q26.5 0 45.5 18.5t19 45.5t-19 45.5t-45.5 18.5t-45-18.5T171 192t18.5-45.5t45-18.5z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Alpine helper: biar nggak flicker --}}
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
