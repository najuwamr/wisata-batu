@extends('layouts.guest')

@section('title', 'Beranda')

{{-- Tambahan style --}}
@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        .text-selecta-blue {
            color: #373C90;
        }

        .bg-selecta-blue {
            background-color: #373C90;
        }

        body {
            /* Menggunakan gradien gelap yang lebih modern daripada warna solid */
            background-color: #1a202c;
            /* fallback */
            background-image: linear-gradient(to bottom right, #1a202c, #0f172a);
        }
    </style>
@endpush

@section('content')
    {{-- =================== HERO VIDEO =================== --}}
    <section class="relative w-full h-screen overflow-hidden">
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('assets/customer/vid-profil.mp4') }}" type="video/mp4" loading="lazy">
            Browser Anda tidak mendukung video.
        </video>

        <div class="absolute inset-0 bg-black/20"></div>

        <img src="{{ asset('assets/customer/truly6.png') }}" alt="Truly Picnic"
            class="absolute top-1/2 left-1/2 w-1/2 md:w-1/3 transform -translate-x-1/2 -translate-y-1/2 z-20">

        <!-- Wave -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="block w-full h-[100px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100"
                preserveAspectRatio="none">
                <path fill="#FFFCFB" d="M0,30 C360,90 1080,-30 1440,60 L1440,100 L0,100Z"></path>
            </svg>
        </div>
    </section>

    {{-- =================== TIKET =================== --}}
    <section class="bg-[#FFFCFB] py-10 md:min-h-[700px] h-[500px] text-center relative rounded-b-9xl overflow-x-hidden">
        <h1 class="text-4xl md:text-7xl mx-5 font-semibold text-[#093FB4] font-poppins">
            Pilihan <span class="text-[#ED3500]">Tiket</span>
        </h1>
    </section>

    {{-- =================== PETA INTERAKTIF =================== --}}
    <section class="relative w-full bg-amber-50 overflow-hidden py-16 md:py-24 reveal-on-scroll">
        <div class="flex flex-col md:flex-row w-full max-w-7xl mx-auto">

            <div class="relative w-full md:w-2/3 flex justify-center items-center px-4 md:px-0">
                <img src="{{ asset('assets/customer/peta1.png') }}" alt="Peta Wahana"
                    class="w-full rounded-2xl shadow-2xl shadow-amber-900/20">

                {{-- Marker: Kolam Renang --}}
                <div class="absolute top-[40%] left-[25%]" x-data="{ open: false }" @mouseenter="open = true"
                    @mouseleave="open = false">
                    <div class="group relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 16 16"
                            class="cursor-pointer drop-shadow-lg transition-transform duration-300 group-hover:scale-125">
                            <path fill="#ED3500" fill-rule="evenodd"
                                d="m7.539 14.841l.003.003l.002.002a.755.755 0 0 0 .912 0l.002-.002l.003-.003l.012-.009a5.57 5.57 0 0 0 .19-.153a15.588 15.588 0 0 0 2.046-2.082C11.81 11.235 13 9.255 13 7A5 5 0 0 0 3 7c0 2.255 1.19 4.235 2.292 5.597a15.591 15.591 0 0 0 2.046 2.082a8.916 8.916 0 0 0 .189.153zM8 8.5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3" />
                        </svg>
                        <div
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 pointer-events-none
                           opacity-0 scale-90 group-hover:opacity-100 group-hover:scale-100
                           transition-all duration-300 ease-in-out transform-gpu
                           bg-white/70 backdrop-blur-md rounded-2xl shadow-2xl p-4 border border-amber-300/50 z-50
                           origin-bottom">
                            <div
                                class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0
                                    border-x-8 border-x-transparent
                                    border-t-8 border-t-white/70">
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Kolam Renang</h3>
                            <img src="{{ asset('assets/customer/kolamrenang.jpg') }}" alt="Kolam Renang"
                                class="w-full h-36 object-cover rounded-lg mt-2 shadow-md">
                            <p class="mt-3 text-sm text-slate-700">
                                Kami memiliki 3 kolam renang dengan tinggi mulai 0.5 meter hingga 3 meter.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Marker: Bianglala --}}
                <div class="absolute top-[55%] left-[15%]" x-data="{ open: false }" @mouseenter="open = true"
                    @mouseleave="open = false">
                    <div class="group relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 16 16"
                            class="cursor-pointer drop-shadow-lg transition-transform duration-300 group-hover:scale-125">
                            <path fill="#ED3500" fill-rule="evenodd"
                                d="m7.539 14.841l.003.003l.002.002a.755.755 0 0 0 .912 0l.002-.002l.003-.003l.012-.009a5.57 5.57 0 0 0 .19-.153a15.588 15.588 0 0 0 2.046-2.082C11.81 11.235 13 9.255 13 7A5 5 0 0 0 3 7c0 2.255 1.19 4.235 2.292 5.597a15.591 15.591 0 0 0 2.046 2.082a8.916 8.916 0 0 0 .189.153zM8 8.5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3" />
                        </svg>
                        <div
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 pointer-events-none
                           opacity-0 scale-90 group-hover:opacity-100 group-hover:scale-100
                           transition-all duration-300 ease-in-out transform-gpu
                           bg-white/70 backdrop-blur-md rounded-2xl shadow-2xl p-4 border border-amber-300/50 z-50
                           origin-bottom">
                            <div
                                class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0
                                    border-x-8 border-x-transparent
                                    border-t-8 border-t-white/70">
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Bianglala</h3>
                            <img src="{{ asset('assets/customer/bianglala.jpg') }}" alt="Bianglala"
                                class="w-full h-36 object-cover rounded-lg mt-2 shadow-md">
                            <p class="mt-3 text-sm text-slate-700">
                                Nikmati pemandangan kota Batu dari ketinggian 30 meter di atas Bianglala.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="w-full md:w-1/3 flex flex-col justify-center text-white p-8 md:p-12 mt-8 md:mt-0">
                <div class="text-center md:text-left">
                    <h1 class="font-black text-5xl md:text-6xl text-transparent bg-clip-text bg-gradient-to-br from-amber-200 to-amber-500 reveal-item"
                        style="--delay: 100ms;">
                        Peta Selecta
                    </h1>
                    <p class="text-lg text-amber-400 mt-4 max-w-sm mx-auto md:mx-0 reveal-item" style="--delay: 200ms;">
                        Jelajahi setiap sudut dan temukan semua wahana seru yang kami tawarkan.
                    </p>
                </div>

                {{-- Grid Fasilitas --}}
                <div class="grid grid-cols-2 gap-x-6 gap-y-5 w-full mt-12">
                    <div class="flex items-center space-x-3 group cursor-pointer reveal-item" style="--delay: 300ms;">
                        <div
                            class="bg-amber-400/20 p-2 rounded-lg transition-all duration-300 group-hover:bg-amber-400/40 group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                class="size-6 text-amber-300">
                                <path fill-rule="evenodd"
                                    d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08Zm3.094 8.016a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="transition-colors duration-300 group-hover:text-amber-300 text-amber-500">Security</span>
                    </div>
                    <div class="flex items-center space-x-3 group cursor-pointer reveal-item" style="--delay: 400ms;">
                        <div
                            class="bg-amber-400/20 p-2 rounded-lg transition-all duration-300 group-hover:bg-amber-400/40 group-hover:scale-110">
                            <img src="{{ asset('assets/icons/toilet.png') }}" class="w-6 h-6 filter invert brightness-200">
                        </div>
                        <span class="transition-colors duration-300 group-hover:text-amber-300">Toilet</span>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- =================== BERITA =================== --}}
    <section class="bg-blue-50 p-4 md:min-h-[1000px] relative -mt-20 z-0 overflow-hidden rounded-t-[4rem]">
        <div class="flex justify-between items-center p-7">
            <h1 class="text-left p-5 text-4xl md:text-7xl font-bold text-blue-800">Berita <span
                    class="text-amber-500">Selecta!</span></h1>
            <a href="" class="md:text-md text-center font-reguler text-black underline p-4 flex items-center gap-2">
                Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="">
                    <g fill="none" stroke="#FFFFFF" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-miterlimit="10" d="m15.813 8.187l-7.626 7.626" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.111 15.155V8.917a1.028 1.028 0 0 0-1.028-1.028H8.845" />
                        <rect width="18.5" height="18.5" x="2.75" y="2.75" rx="6" />
                    </g>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-10"> <!-- Card Besar -->
            <div class="md:col-span-2 md:row-span-2 bg-[#FFFCFB] rounded-2xl shadow-lg flex flex-row overflow-hidden">
                <div class="p-6 flex flex-col justify-between w-1/2">
                    <h3 class="text-sm uppercase font-bold">SELECTA NEWS</h3>
                    <p class="text-2xl font-bold mt-2">"Sekarang Selecta punya wahana baru!"</p> <button
                        class="mt-6 px-4 py-2 bg-[#093FB4] rounded-lg text-[#FFD8D8] text-sm font-semibold hover:bg-gray-200 transition">
                        MORE INFO >> </button>
                </div>
                <div class="w-1/2"> <img src="{{ asset('assets/customer/berita1.webp') }}"
                        class="w-full h-full object-cover" /> </div>
            </div> <!-- Card Kecil 1 -->
            <div class="bg-[#FFFCFB] rounded-2xl shadow-lg overflow-hidden"> <img
                    src="{{ asset('assets/customer/berita2.webp') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">Family Time!</h3>
                    <p class="text-lg font-semibold mt-2">"Taman cantik sayang kalo ga foto-foto!"</p>
                </div>
            </div> <!-- Card Kecil 2 -->
            <div class="bg-[#FFFCFB] rounded-2xl shadow-lg overflow-hidden"> <img
                    src="{{ asset('assets/customer/berita3.jpg') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">Family Time!</h3>
                    <p class="text-lg font-semibold mt-2">"50k dapet apa aja si?"</p>
                </div>
            </div>
        </div>
    </section>
@endsection
