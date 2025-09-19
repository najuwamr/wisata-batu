@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
    <section class="relative w-full h-screen overflow-hidden">
        <!-- Video Background -->
        <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-1/2 md:h-3/4 object-cover">
            <source src="{{ asset('assets/customer/vid-profil.mp4') }}" type="video/mp4">
            Browser Anda tidak mendukung video.
        </video>

        <!-- Overlay -->
        <div class="absolute inset-0 h-1/2 md:h-3/4 bg-black/50"></div>

        <!-- Konten di atas video -->
        <div
            class="relative flex items-center justify-center top-10 md:justify-start font-light md:left-20 z-20 h-1/2 text-white text-5xl md:text-6xl ">
            <h1 class="font-poppins">
                <span class="block ">Truly</span>
                <span class="text-[#6ECCFF] ">Picnic</span>
            </h1>
        </div>
    </section>

    {{-- <section class="bg-white w-full h-screen">
        <div class="w-full flex justify-between px-10 items-center">
            <h1 class="text-4xl text-[#373C90] font-semibold">Selecta</h1>
            <h1 class="text-2xl font-light">since 1930</h1>
        </div>

    </section> --}}

    <section class="bg-white w-full py-20">
        <div class="container mx-auto px-4 md:px-10">
            <div class="w-full flex justify-between items-center mb-20">
                <h1 class="text-4xl md:text-5xl text-selecta-blue font-semibold">Selecta</h1>
                <h1 class="text-2xl md:text-3xl font-light text-gray-600">since 1930</h1>
            </div>

            <div class="relative max-w-4xl mx-auto py-20">
                <div class="absolute left-1/2 top-0 h-full w-1 bg-selecta-blue transform -translate-x-1/2"></div>

                <div class="mb-16 flex items-center w-full">
                    <div class="w-full h-1/2 flex justify-around">

                        <div
                            class="absolute top-1/2 transform translate-y-1/2 w-4 h-4 rounded-full bg-white border-4 border-selecta-blue">
                        </div>
                        <img src="{{ asset('assets/customer/Selecta1930.jpg') }}" alt="Selecta tahun 1930-an"
                            class="shadow-xl rounded-md">
                        <p class="text-gray-700 leading-relaxed">
                            Pemandian Selecta dibangun pada tahun 1930 oleh warga negara Belanda bernama De Ruyter de Wildt
                            dengan nama Bath Hotel Selecta. Pada masa pendudukan Jepang (1942-1945), tempat ini dikelola
                            oleh Mr. Hashiguchi, hingga akhirnya pada akhir tahun 1949 saat pecah perang revolusi yang
                            dikenal dengan Clash Kedua, Selecta dibumihanguskan dan bangunan megahnya hancur menjadi
                            puing-puing.
                        </p>

                    </div>
                </div>

            </div>



        </div>
        </div>
    </section>

@endsection
