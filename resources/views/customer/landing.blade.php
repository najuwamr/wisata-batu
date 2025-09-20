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
            <source src="{{ asset('assets/customer/vid-profil.mp4') }}" type="video/mp4">
            Browser Anda tidak mendukung video.
        </video>

        <div class="absolute inset-0 bg-black/30"></div>

        {{-- Konten Tengah --}}
        <div class="absolute inset-0 flex flex-col mx-10 justify-center items-start z-20 text-white text-3xl md:text-6xl">
            <h1 class="font-poppins">
                <span class="block font-semibold">Truly</span>
                <span class="text-[#6ECCFF] font-light text-8xl">Picnic</span>
            </h1>

            {{-- Tombol --}}
            <a href="/"
                class="mt-6 bg-amber-500 hover:bg-[#1c0a66] text-blue-700 font-semibold hover:text-amber-500 px-6 py-3 rounded-lg shadow-lg transition duration-400 text-lg">
                Pesan Tiket
            </a>
        </div>
    </section>

    {{-- =================== TIKET TERBAIK =================== --}}
    <section class="bg-[#090040] min-h-[600px] flex pt-10">
        <h1 class="text-4xl md:text-7xl mx-10 font-semibold text-white font-poppins">
            Tiket <span class="text-amber-400">Terbaik</span>
        </h1>
    </section>

    {{-- =================== TIMELINE =================== --}}
    <section class="bg-white w-full py-20">
        <div class="container mx-auto px-6 md:px-10">
            <div class="w-full flex justify-between items-center mb-16 md:mb-24">
                <h1 class="text-4xl md:text-5xl text-selecta-blue font-semibold">Selecta</h1>
                <h1 class="text-2xl md:text-3xl font-light text-gray-800">since 1930</h1>
            </div>

            <div class="relative max-w-5xl mx-auto">
                {{-- Garis timeline --}}
                <div class="absolute left-6 top-0 bottom-0 w-1 bg-selecta-blue"></div>


                {{-- Item Timeline --}}
                <div class="sejarah flex flex-col md:flex-row items-center gap-8 mb-10">
                    <div class="w-full md:w-2/5">
                        <img src="{{ asset('assets/customer/Selecta1930.jpg') }}" class="rounded-md w-full shadow-lg"
                            alt="Selecta tahun 1930-an">
                    </div>
                    <div class="w-full md:w-3/5">

                        <p class="text-gray-700 leading-relaxed">
                            Pemandian Selecta dibangun pada tahun 1930 oleh warga negara Belanda bernama De Ruyter de Wildt
                            dengan nama Bath Hotel Selecta. Pada masa pendudukan Jepang (1942–1945), tempat ini dikelola
                            oleh Mr. Hashiguchi, hingga akhirnya pada akhir tahun 1949 saat pecah perang revolusi yang
                            dikenal dengan Clash Kedua, Selecta dibumihanguskan dan bangunan megahnya hancur menjadi
                            puing-puing.
                        </p>
                    </div>
                </div>
                <div class="sejarah flex flex-col md:flex-row items-center gap-8 mb-10">
                    <div class="w-full md:w-2/5">
                        <img src="{{ asset('assets/customer/Selecta1930.jpg') }}" class="rounded-md w-full shadow-lg"
                            alt="Selecta tahun 1930-an">
                    </div>
                    <div class="w-full md:w-3/5">
                        <p class="text-gray-700 leading-relaxed">
                            Pemandian Selecta dibangun pada tahun 1930 oleh warga negara Belanda bernama De Ruyter de Wildt
                            dengan nama Bath Hotel Selecta. Pada masa pendudukan Jepang (1942–1945), tempat ini dikelola
                            oleh Mr. Hashiguchi, hingga akhirnya pada akhir tahun 1949 saat pecah perang revolusi yang
                            dikenal dengan Clash Kedua, Selecta dibumihanguskan dan bangunan megahnya hancur menjadi
                            puing-puing.
                        </p>
                    </div>
                </div>
                <div class="sejarah flex flex-col md:flex-row items-center gap-8 mb-10">
                    <div class="w-full md:w-2/5">
                        <img src="{{ asset('assets/customer/Selecta1930.jpg') }}" class="rounded-md w-full shadow-lg"
                            alt="Selecta tahun 1930-an">
                    </div>
                    <div class="w-full md:w-3/5">
                        <p class="text-gray-700 leading-relaxed">
                            Pemandian Selecta dibangun pada tahun 1930 oleh warga negara Belanda bernama De Ruyter de Wildt
                            dengan nama Bath Hotel Selecta. Pada masa pendudukan Jepang (1942–1945), tempat ini dikelola
                            oleh Mr. Hashiguchi, hingga akhirnya pada akhir tahun 1949 saat pecah perang revolusi yang
                            dikenal dengan Clash Kedua, Selecta dibumihanguskan dan bangunan megahnya hancur menjadi
                            puing-puing.
                        </p>
                    </div>
                </div>
                <div class="sejarah flex flex-col md:flex-row items-center gap-8 mb-10">
                    <div class="w-full md:w-2/5">
                        <img src="{{ asset('assets/customer/Selecta1930.jpg') }}" class="rounded-md w-full shadow-lg"
                            alt="Selecta tahun 1930-an">
                    </div>
                    <div class="w-full md:w-3/5">
                        <p class="text-gray-700 leading-relaxed">
                            Pemandian Selecta dibangun pada tahun 1930 oleh warga negara Belanda bernama De Ruyter de Wildt
                            dengan nama Bath Hotel Selecta. Pada masa pendudukan Jepang (1942–1945), tempat ini dikelola
                            oleh Mr. Hashiguchi, hingga akhirnya pada akhir tahun 1949 saat pecah perang revolusi yang
                            dikenal dengan Clash Kedua, Selecta dibumihanguskan dan bangunan megahnya hancur menjadi
                            puing-puing.
                        </p>
                    </div>
                </div>
                <div class="sejarah flex flex-col md:flex-row items-center gap-8 mb-10">
                    <div class="w-full md:w-2/5">
                        <img src="{{ asset('assets/customer/Selecta1930.jpg') }}" class="rounded-md w-full shadow-lg"
                            alt="Selecta tahun 1930-an">
                    </div>
                    <div class="w-full md:w-3/5">
                        <p class="text-gray-700 leading-relaxed">
                            Pemandian Selecta dibangun pada tahun 1930 oleh warga negara Belanda bernama De Ruyter de Wildt
                            dengan nama Bath Hotel Selecta. Pada masa pendudukan Jepang (1942–1945), tempat ini dikelola
                            oleh Mr. Hashiguchi, hingga akhirnya pada akhir tahun 1949 saat pecah perang revolusi yang
                            dikenal dengan Clash Kedua, Selecta dibumihanguskan dan bangunan megahnya hancur menjadi
                            puing-puing.
                        </p>
                    </div>
                </div>



                {{-- Tambahkan item timeline berikutnya --}}

            </div>
        </div>
    </section>

    {{-- =================== PETA SELECTA =================== --}}
    <section class="w-full min-h-[600px]">
        <img src="{{ asset('assets/customer/peta-selecta.jpg') }}" alt="Peta Selecta" class="w-full h-full object-cover">
    </section>

    {{-- =================== GOOGLE REVIEW =================== --}}
    <section class="bg-gray-50 py-20">
        <div class="container mx-auto px-6 md:px-10">
            <h2 class="text-3xl md:text-5xl font-poppins font-semibold text-left text-blue-700 mb-12">
                Apa kata mereka tentang Selecta?
            </h2>

            <div class="tagembed-widget w-full min-h-[600px] overflow-auto" data-widget-id="301186" data-website="1">
            </div>
            <script src="https://widget.tagembed.com/embed.min.js" type="text/javascript"></script>
        </div>
    </section>
@endsection
