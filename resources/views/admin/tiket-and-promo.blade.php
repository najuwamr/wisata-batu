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

    <div x-data="{ active: '{{ $tab ?? 'tiket' }}' }">
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

        <div class="flex justify-between lg:justify-end mt-6 lg:mt-1 items-center mb-6">
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

            <button class="flex items-center bg-blue-200 text-black px-4 py-2 rounded-md space-x-2 shadow-md cursor-pointer"
                @click="window.location.href = active === 'tiket'
                            ? '{{ route('admin.tambah.tiket') }}'
                            : '{{ route('admin.tambah.promo') }}'">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024">
                    <path fill="currentColor"
                        d="M512 0C229.232 0 0 229.232 0 512c0 282.784 229.232 512 512 512c282.784 0 512-229.216 512-512C1024 229.232 794.784 0 512 0zm0 961.008c-247.024 0-448-201.984-448-449.01c0-247.024 200.976-448 448-448s448 200.977 448 448s-200.976 449.01-448 449.01zM736 480H544V288c0-17.664-14.336-32-32-32s-32 14.336-32 32v192H288c-17.664 0-32 14.336-32 32s14.336 32 32 32h192v192c0 17.664 14.336 32 32 32s32-14.336 32-32V544h192c17.664 0 32-14.336 32-32s-14.336-32-32-32z"/>
                </svg>

                <p x-text="active === 'tiket' ? 'Tambah Tiket' : 'Tambah Promo'"></p>
            </button>
        </div>

        {{-- Content Tiket --}}
        <div x-show="active === 'tiket'" x-cloak>
            <h3 class="text-lg font-semibold mb-2">Tiket Aktif</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
                @forelse ($tiketAktif as $tiket)
                    @include('components.product-card', ['product' => $tiket])
                @empty
                    <p class="text-gray-500 col-span-full">Tidak ada tiket aktif.</p>
                @endforelse
            </div>

            <div x-data="{ showNonAktif: false }">
                <button @click="showNonAktif = !showNonAktif"
                        class="text-sm text-blue-600 hover:underline">
                    <span x-show="!showNonAktif">Tampilkan tiket nonaktif</span>
                    <span x-show="showNonAktif">Sembunyikan tiket nonaktif</span>
                </button>

                <div x-show="showNonAktif" x-cloak class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($tiketNonAktif as $tiket)
                        @include('components.product-card', ['product' => $tiket])
                    @empty
                        <p class="text-gray-500 col-span-full">Tidak ada tiket nonaktif.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Content Promo --}}
        <div x-show="active === 'promo'" x-cloak>
            <h3 class="text-lg font-semibold mb-2">Promo Aktif</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                @forelse ($promoAktif as $promo)
                    @include('components.product-card', ['product' => $promo])
                @empty
                    <p class="text-gray-500 col-span-full">Tidak ada promo aktif.</p>
                @endforelse
            </div>

            <div x-data="{ showNonAktif: false }">
                <button @click="showNonAktif = !showNonAktif"
                        class="text-sm text-purple-600 hover:underline">
                    <span x-show="!showNonAktif">Tampilkan promo nonaktif</span>
                    <span x-show="showNonAktif">Sembunyikan promo nonaktif</span>
                </button>

                <div x-show="showNonAktif" x-cloak class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($promoNonAktif as $promo)
                        @include('components.product-card', ['product' => $promo])
                    @empty
                        <p class="text-gray-500 col-span-full">Tidak ada promo nonaktif.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
