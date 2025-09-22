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
    </style>
@endpush

@section('content')
    {{-- =================== HERO VIDEO =================== --}}
    <section class="relative w-full h-screen overflow-hidden">
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('assets/customer/vid-profil.mp4') }}" type="video/mp4" loading="lazy">
            Browser Anda tidak mendukung video.
        </video>

        <div class="absolute inset-0 bg-black/50"></div>

        <img src="{{ asset('assets/customer/truly2.png') }}" alt="Truly Picnic"
            class="absolute top-3/4 left-1/2 w-1/2 md:w-1/3 transform -translate-x-1/2 -translate-y-1/2 z-20">


        {{-- Konten Tengah --}}
        {{-- <div
            class="absolute inset-0 flex flex-col mx-10 justify-center items-start z-20 text-[#093FB4] text-3xl md:text-6xl">
            <h1 class="font-poppins">
                <span class="block font-semibold">Truly</span>
                <span class="text-[#ED3500] font-semibold text-8xl">Picnic</span>
            </h1>

            <p class="text-white font-reguler text-left text-[0.9rem] w-full md:w-1/2">Selamat datang di Taman Rekreasi
                dengan
                perpaduan pemandangan alam terindah nomer 1 di Kota Batu. Tempat paling nyaman untuk keluarga melihat
                bunga-bunga indah dengan suasana dingin di lembah Gunung Panderman</p>

            {{-- Tombol --}}
        <a href="/"
            class="mt-6 bg-[#093FB4] hover:bg-[#6ECCFF] text-white font-semibold hover:text-[#1c0a66] px-6 py-3 rounded-lg shadow-xl transition duration-400 text-lg">
            Pesan Tiket
        </a>
        </div>
    </section>

    {{-- =================== TIKET TERBAIK =================== --}}
    <section class="bg-[#bee5f9] py-10 min-h-[700px] text-center pr-10 relative">
        <h1 class="text-4xl md:text-7xl mx-10 font-semibold text-[#2a1a71] font-poppins">
            Pilihan <span class="text-amber-500">Tiket</span>
        </h1>
    </section>

    <!-- Wave -->
    <img src="{{ asset('assets/customer/wave.svg') }}" alt="wave separator" class="w-full block relative z-10">

    {{-- =================== Info =================== --}}
    <section class="bg-gradient-to-b from-[#e7ffea] to-blue-200 p-4 md:min-h-[1000px] relative -mt-20 z-0">

        <h1 class="text-left p-10 text-4xl md:text-left md:text-7xl font-bold text-amber-500">Kepo Selecta!</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-10">
            <!-- Card Besar (span 2 kolom, 2 baris) -->
            <div
                class="md:col-span-2 md:row-span-2 bg-[#e4ffbf] rounded-2xl shadow-lg flex flex-row md:flex-row overflow-hidden">
                <div class="p-6 flex flex-col justify-between w-1/2 md:w-1/2">
                    <h3 class="text-sm uppercase font-bold">SELECTA NEWS</h3>
                    <p class="text-2xl font-bold mt-2">
                        "Super fun! There's a lot of exciting activities you can choose!"
                    </p>

                    <button
                        class="mt-6 px-4 py-2 bg-white rounded-lg text-black text-sm font-semibold hover:bg-gray-200 transition">
                        MORE INFO >>
                    </button>
                </div>
                <div class="w-1/2 md:w-1/2">
                    <img src="{{ asset('assets/customer/peta-selecta1.jpg') }}"
                        class="w-full h-full md:w-full md:h-full object-cover" />
                </div>
            </div>

            <!-- Card Kecil 1 -->
            <div class="bg-[#c0ffd7] rounded-2xl shadow-lg overflow-hidden">
                <img src="{{ asset('assets/customer/peta-selecta1.jpg') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">FEEDING TIME!</h3>
                    <p class="text-lg font-semibold mt-2">"The giraffe is so majestic and pretty"</p>
                </div>
            </div>

            <!-- Card Kecil 2 -->
            <div class="bg-[#edf0ac] rounded-2xl shadow-lg overflow-hidden">
                <img src="{{ asset('assets/customer/peta-selecta1.jpg') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">ENCHANTING SHOWS</h3>
                    <p class="text-lg font-semibold mt-2">"Amazing! A True Voyage of Fantasy"</p>
                </div>
            </div>
        </div>

    </section>
    <section class="bg-blue-200 p-4 md:min-h-[1000px]">

        <h1 class="text-center p-10 text-4xl md:text-center md:text-7xl font-bold text-amber-500">Promo</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-10">
            <!-- Card Besar (span 2 kolom, 2 baris) -->
            <div
                class="md:col-span-2 md:row-span-2 bg-[#e4ffbf] rounded-2xl shadow-lg flex flex-row md:flex-row overflow-hidden">
                <div class="p-6 flex flex-col justify-between w-1/2 md:w-1/2">
                    <h3 class="text-sm uppercase font-bold">SELECTA NEWS</h3>
                    <p class="text-2xl font-bold mt-2">
                        "Super fun! There's a lot of exciting activities you can choose!"
                    </p>

                    <button
                        class="mt-6 px-4 py-2 bg-white rounded-lg text-black text-sm font-semibold hover:bg-gray-200 transition">
                        MORE INFO >>
                    </button>
                </div>
                <div class="w-1/2 md:w-1/2">
                    <img src="{{ asset('assets/customer/peta-selecta1.jpg') }}"
                        class="w-full h-full md:w-full md:h-full object-cover" />
                </div>
            </div>

            <!-- Card Kecil 1 -->
            <div class="bg-[#c0ffd7] rounded-2xl shadow-lg overflow-hidden">
                <img src="{{ asset('assets/customer/peta-selecta1.jpg') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">FEEDING TIME!</h3>
                    <p class="text-lg font-semibold mt-2">"The giraffe is so majestic and pretty"</p>
                </div>
            </div>

            <!-- Card Kecil 2 -->
            <div class="bg-[#edf0ac] rounded-2xl shadow-lg overflow-hidden">
                <img src="{{ asset('assets/customer/peta-selecta1.jpg') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">ENCHANTING SHOWS</h3>
                    <p class="text-lg font-semibold mt-2">"Amazing! A True Voyage of Fantasy"</p>
                </div>
            </div>
        </div>

    </section>


    {{-- =================== PETA SELECTA =================== --}}


    {{-- =================== GOOGLE REVIEW =================== --}}
    {{-- <section class="bg-gray-50 py-20">
        <div class="container mx-auto px-6 md:px-10">
            <h2 class="text-3xl md:text-5xl font-poppins font-semibold text-left text-blue-700 mb-12">
                Apa kata mereka tentang <span class="text-[#6ECCFF]">Selecta?</span>
            </h2>

            <div class="tagembed-widget" style="width:100%;height:100%;overflow:auto;" data-widget-id="301186"
                data-website="1"></div>
            <script src="https://widget.tagembed.com/embed.min.js" type="text/javascript"></script>
        </div>
    </section> --}}

    {{-- =================== SECTION TERAKHIR =================== --}}
    <section class="bg-white py-20 w-full flex items-center h-[700px]">
        <div class="container mx-auto px-4">
            <h1 class="text-center font-semibold text-3xl md:text-5xl">Mitra Kami</h1>

            <div class="marquee-container overflow-hidden relative w-full mt-20">
                <div class="flex whitespace-nowrap animate-marquee">
                    <!-- Daftar logo asli -->
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-PHRI.png') }}" alt="Logo PHRI"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-Pemkot.svg') }}" alt="Logo Pemkot"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-PesonaInd.png') }}" alt="Logo Pesona Indonesia"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-hotelselecta.webp') }}" alt="Logo Hotel Selecta"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-PHRI.png') }}" alt="Logo Partner 5"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-Pemkot.svg') }}" alt="Logo Partner 6"
                            class="h-16 md:h-20 object-contain">
                    </div>

                    <!-- Duplikat daftar logo untuk efek seamless -->
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-PHRI.png') }}" alt="Logo PHRI"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-Pemkot.svg') }}" alt="Logo Pemkot"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-PesonaInd.png') }}" alt="Logo Pesona Indonesia"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-hotelselecta.webp') }}" alt="Logo Hotel Selecta"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-PHRI.png') }}" alt="Logo Partner 5"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-Pemkot.svg') }}" alt="Logo Partner 6"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-PHRI.png') }}" alt="Logo Partner 5"
                            class="h-16 md:h-20 object-contain">
                    </div>
                    <div class="logo-item mx-8">
                        <img src="{{ asset('assets/customer/Logo-Pemkot.svg') }}" alt="Logo Partner 6"
                            class="h-16 md:h-20 object-contain">
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection
