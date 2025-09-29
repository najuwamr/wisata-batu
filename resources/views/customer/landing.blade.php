@extends('layouts.guest')

@section('title', '| Taman Rekreasi, Hotel, & Resto')



@section('content')
    {{-- =================== HERO VIDEO =================== --}}
    <section class="relative w-full h-screen overflow-hidden">
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('assets/customer/vid-profil.mp4') }}" type="video/mp4" loading="lazy">
            Browser Anda tidak mendukung video.
        </video>

        <div class="absolute inset-0 bg-black/20"></div>
        <div class="flex-col justify-center items-center">
            <img src="{{ asset('assets/customer/truly6.png') }}" alt="Truly Picnic"
                class="absolute top-1/2 left-1/2 w-1/2 md:w-1/3 transform -translate-x-1/2 -translate-y-1/2 z-20">
            <a href="" class="bg-white"></a>
        </div>


        <!-- Wave -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="block w-full h-[100px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100"
                preserveAspectRatio="none">
                <path fill="currentColor" class="text-blue-50" d="M0,30 C360,90 1080,-30 1440,60 L1440,100 L0,100Z"></path>
            </svg>
        </div>
    </section>

    {{-- =================== TIKET =================== --}}
    <section class="w-full bg-blue-50 py-20">
        <div class="max-w-7xl mx-auto bg-blue-50 rounded-3xl p-8 md:p-12 lg:p-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <!-- Bagian Teks -->
                <div>
                    <h2
                        class="text-5xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600 leading-tight mb-4">
                        Pilihan Tiket
                    </h2>
                    <p class="text-gray-600 text-lg max-w-md mb-8">
                        Geser untuk melihat semua tiket yang tersedia dan pilih yang terbaik untuk Anda.
                    </p>

                    <!-- Tombol Lihat Tiket lainnya -->
                    <a href="#"
                        class="md:w-1/3 w-1/2 bg-gradient-to-r from-red-400 to-red-600 text-white font-semibold px-4 py-3 rounded-lg shadow-md hover:from-blue-500 hover:to-blue-700">
                        Lihat Tiket lainnya
                    </a>

                    <!-- Tombol Navigasi di bawah -->
                    <div class="flex space-x-3 mt-6">
                        <button
                            class="swiper-button-prev-features w-12 h-12 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button
                            class="swiper-button-next-features w-12 h-12 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Bagian Slider -->
                <div class="w-full overflow-hidden">
                    <div class="swiper mySwiperFeatures">
                        <div class="swiper-wrapper py-4">

                            @forelse($tiketAktif as $tiket)
                                <div class="swiper-slide flex justify-center">
                                    <div class="bg-white shadow-lg rounded-2xl overflow-hidden w-full">
                                        <img src="{{ asset('images/' . $tiket->image) }}" alt="{{ $tiket->name }}"
                                            class="w-full h-40 object-cover">

                                        <div class="p-3">
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $tiket->name }}</h3>


                                            <p class="mt-3 text-xl font-bold text-blue-600">
                                                Rp {{ number_format($tiket->price, 0, ',', '.') }}
                                            </p>

                                            <a href="/"
                                                class="w-full md:w-1/2 flex justify-center items-center mt-4 bg-gradient-to-r from-red-500 to-red-400 text-white px-4 py-2 rounded-lg hover:from-red-600 hover:to-red-500 gap-2">
                                                Lihat Detail
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        viewBox="0 0 24 24">
                                                        <path fill="#ffffff"
                                                            d="M9 10a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-1-1Zm12 1a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1a1 1 0 0 1 0 2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1a1 1 0 0 1 0-2Zm-1-1.82a3 3 0 0 0 0 5.64V17H10a1 1 0 0 0-2 0H4v-2.18a3 3 0 0 0 0-5.64V7h4a1 1 0 0 0 2 0h10Z" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <p class="text-center text-gray-500">Belum ada tiket tersedia.</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>






    {{-- =================== PETA INTERAKTIF =================== --}}
    <section class="relative w-full bg-gradient-to-tr from-blue-100 via-green-50 to-blue-100 -mt-10">

        <div class="flex flex-col md:flex-row w-full max-w-screen-7xl mx-auto ">

            <!-- Bagian Peta -->
            <div class="relative w-full md:w-full flex justify-end items-end ">
                <!-- Container Peta dengan Efek 3D Ringan -->
                <div class="relative w-full">
                    <!-- Background Peta dengan Efek Kedalaman -->


                    <!-- Peta Utama -->
                    <div class="relative">
                        <img src="{{ asset('assets/customer/peta1.png') }}" alt="Peta Wahana Selecta"
                            class="w-full h-auto object-cover shadow-2xl" loading="lazy">

                        <!-- Overlay dengan Grid Transparan untuk Efek Interaktif -->

                    </div>

                    <!-- Marker hanya ditampilkan di desktop -->
                    <div class="hidden lg:block">
                        <!-- Marker: Kolam Renang -->
                        <div class="absolute top-[40%] left-[43%] animate-float">
                            <div class="group relative">
                                <!-- Marker dengan animasi pulsa -->
                                <div
                                    class="absolute -inset-2 bg-green-500 rounded-full animate-ping opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 16 16"
                                    class="cursor-pointer drop-shadow-lg transition-all duration-300 group-hover:scale-125 relative z-10">
                                    <path fill="currentColor" class="bg-blue-"
                                        d="m7.539 14.841l.003.003l.002.002a.755.755 0 0 0 .912 0l.002-.002l.003-.003l.012-.009a5.57 5.57 0 0 0 .19-.153a15.588 15.588 0 0 0 2.046-2.082C11.81 11.235 13 9.255 13 7A5 5 0 0 0 3 7c0 2.255 1.19 4.235 2.292 5.597a15.591 15.591 0 0 0 2.046 2.082a8.916 8.916 0 0 0 .189.153zM8 8.5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3" />
                                </svg>
                                <!-- Tooltip -->
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 pointer-events-none opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-in-out origin-bottom bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-4 border border-amber-300/50 z-50">
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/90">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Kolam Renang</h3>
                                    <img src="{{ asset('assets/customer/kolamrenang.jpg') }}" alt="Kolam Renang"
                                        class="w-full h-36 object-cover rounded-lg mt-2 shadow-md" loading="lazy">
                                    <p class="mt-3 text-sm text-slate-700">
                                        3 kolam renang dengan kedalaman mulai 0.5 meter hingga 3 meter. Hati-hati ya karena
                                        air di sini dingin sekali!
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Marker: Bianglala -->
                        <div class="absolute top-[51%] left-[36%] animate-float" style="animation-delay: 0.5s;">
                            <div class="group relative">
                                <!-- Marker dengan animasi pulsa -->
                                <div
                                    class="absolute -inset-2 bg-green-500 rounded-full animate-ping opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 16 16"
                                    class="cursor-pointer drop-shadow-lg transition-all duration-300 group-hover:scale-125 relative z-10">
                                    <path fill="#ED3500"
                                        d="m7.539 14.841l.003.003l.002.002a.755.755 0 0 0 .912 0l.002-.002l.003-.003l.012-.009a5.57 5.57 0 0 0 .19-.153a15.588 15.588 0 0 0 2.046-2.082C11.81 11.235 13 9.255 13 7A5 5 0 0 0 3 7c0 2.255 1.19 4.235 2.292 5.597a15.591 15.591 0 0 0 2.046 2.082a8.916 8.916 0 0 0 .189.153zM8 8.5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3" />
                                </svg>
                                <!-- Tooltip -->
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 pointer-events-none opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-in-out origin-bottom bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-4 border border-amber-300/50 z-50">
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/90">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Bianglala</h3>
                                    <img src="{{ asset('assets/customer/bianglala.jpg') }}" alt="Bianglala"
                                        class="w-full h-36 object-cover rounded-lg mt-2 shadow-md" loading="lazy">
                                    <p class="mt-3 text-sm text-slate-700">
                                        Nikmati pemandangan kota Batu dari ketinggian 30 meter di atas Bianglala.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Dinosaurus --}}
                        <div class="absolute top-[35%] left-[45%] animate-float" style="animation-delay: 0.5s;">
                            <div class="group relative">
                                <!-- Marker dengan animasi pulsa -->
                                <div
                                    class="absolute -inset-2 bg-green-500 rounded-full animate-ping opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 16 16"
                                    class="cursor-pointer drop-shadow-lg transition-all duration-300 group-hover:scale-125 relative z-10">
                                    <path fill="#ED3500"
                                        d="m7.539 14.841l.003.003l.002.002a.755.755 0 0 0 .912 0l.002-.002l.003-.003l.012-.009a5.57 5.57 0 0 0 .19-.153a15.588 15.588 0 0 0 2.046-2.082C11.81 11.235 13 9.255 13 7A5 5 0 0 0 3 7c0 2.255 1.19 4.235 2.292 5.597a15.591 15.591 0 0 0 2.046 2.082a8.916 8.916 0 0 0 .189.153zM8 8.5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3" />
                                </svg>
                                <!-- Tooltip -->
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 pointer-events-none opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-in-out origin-bottom bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-4 border border-amber-300/50 z-50">
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/90">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Dinosaurus</h3>
                                    <img src="{{ asset('assets/customer/dinosaurus.png') }}" alt="Dinosaurus"
                                        class="w-full h-36 object-cover rounded-lg mt-2 shadow-md" loading="lazy">
                                    <p class="mt-3 text-sm text-slate-700">
                                        Kumpulan replika hewan prasejarah dengan ukuran hampir menyerupai aslinya dengan
                                        pemandangan taman indah.
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- Sky Bike --}}
                        <div class="absolute top-[34%] left-[16%] animate-float" style="animation-delay: 0.5s;">
                            <div class="group relative">
                                <!-- Marker dengan animasi pulsa -->
                                <div
                                    class="absolute -inset-2 bg-green-500 rounded-full animate-ping opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 16 16"
                                    class="cursor-pointer drop-shadow-lg transition-all duration-300 group-hover:scale-125 relative z-10">
                                    <path fill="#ED3500"
                                        d="m7.539 14.841l.003.003l.002.002a.755.755 0 0 0 .912 0l.002-.002l.003-.003l.012-.009a5.57 5.57 0 0 0 .19-.153a15.588 15.588 0 0 0 2.046-2.082C11.81 11.235 13 9.255 13 7A5 5 0 0 0 3 7c0 2.255 1.19 4.235 2.292 5.597a15.591 15.591 0 0 0 2.046 2.082a8.916 8.916 0 0 0 .189.153zM8 8.5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3" />
                                </svg>
                                <!-- Tooltip -->
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 pointer-events-none opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-in-out origin-bottom bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-4 border border-amber-300/50 z-50">
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/90">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Sky Bike</h3>
                                    <img src="{{ asset('assets/customer/skybike.jpg') }}" alt="Sky Bike"
                                        class="w-full h-36 object-cover rounded-lg mt-2 shadow-md" loading="lazy">
                                    <p class="mt-3 text-sm text-slate-700">
                                        Bersepeda sembari melihat Taman Selecta yang indah.
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- Roller Coaster --}}
                        <div class="absolute top-[45%] left-[28%] animate-float" style="animation-delay: 0.5s;">
                            <div class="group relative">
                                <!-- Marker dengan animasi pulsa -->
                                <div
                                    class="absolute -inset-2 bg-green-500 rounded-full animate-ping opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 16 16"
                                    class="cursor-pointer drop-shadow-lg transition-all duration-300 group-hover:scale-125 relative z-10">
                                    <path fill="#ED3500"
                                        d="m7.539 14.841l.003.003l.002.002a.755.755 0 0 0 .912 0l.002-.002l.003-.003l.012-.009a5.57 5.57 0 0 0 .19-.153a15.588 15.588 0 0 0 2.046-2.082C11.81 11.235 13 9.255 13 7A5 5 0 0 0 3 7c0 2.255 1.19 4.235 2.292 5.597a15.591 15.591 0 0 0 2.046 2.082a8.916 8.916 0 0 0 .189.153zM8 8.5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3" />
                                </svg>
                                <!-- Tooltip -->
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 pointer-events-none opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-in-out origin-bottom bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-4 border border-amber-300/50 z-50">
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/90">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Roller Coaster</h3>
                                    <img src="{{ asset('assets/customer/skybike.jpg') }}" alt="Roller Coaster"
                                        class="w-full h-36 object-cover rounded-lg mt-2 shadow-md" loading="lazy">
                                    <p class="mt-3 text-sm text-slate-700">
                                        Roller Coaster memiliki 10 baris dengan tiap baris maksimal 2 penumpang. Cukup bikin
                                        deg-degan!
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- Akoirium --}}
                        <div class="absolute top-[39%] left-[53%] animate-float" style="animation-delay: 0.5s;">
                            <div class="group relative">
                                <!-- Marker dengan animasi pulsa -->
                                <div
                                    class="absolute -inset-2 bg-blue-100 rounded-full animate-ping opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 16 16"
                                    class="cursor-pointer drop-shadow-lg transition-all duration-300 group-hover:scale-125 relative z-10">
                                    <path fill="currentColor" class="text-gradient-to-b from-blue-500 to-blue-700"
                                        d="m7.539 14.841l.003.003l.002.002a.755.755 0 0 0 .912 0l.002-.002l.003-.003l.012-.009a5.57 5.57 0 0 0 .19-.153a15.588 15.588 0 0 0 2.046-2.082C11.81 11.235 13 9.255 13 7A5 5 0 0 0 3 7c0 2.255 1.19 4.235 2.292 5.597a15.591 15.591 0 0 0 2.046 2.082a8.916 8.916 0 0 0 .189.153zM8 8.5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3" />
                                </svg>
                                <!-- Tooltip -->
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-72 pointer-events-none opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-in-out origin-bottom bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-4 border border-amber-300/50 z-50">
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-x-8 border-x-transparent border-t-8 border-t-white/90">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Akoirium</h3>
                                    <img src="{{ asset('assets/customer/akoirium.jpeg') }}" alt="Akoirium"
                                        class="w-full h-36 object-cover rounded-lg mt-2 shadow-md" loading="lazy">
                                    <p class="mt-3 text-sm text-slate-700">
                                        Roller Coaster memiliki 10 baris dengan tiap baris maksimal 2 penumpang. Cukup bikin
                                        deg-degan!
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{--  --}}

                    </div>
                </div>
            </div>

            <!-- Bagian Informasi -->
            <div
                class="w-full md:w-1/2 bg-gradient-to-br from-blue-900 to-blue-950 flex flex-col justify-center text-white p-8 md:p-16 shadow-[2rem] ">
                <div class="text-center md:text-left">
                    <h1
                        class="font-black text-5xl md:text-6xl text-transparent bg-clip-text bg-gradient-to-br from-green-100 via-blue-100 to-lime-200  mb-2">
                        Peta Selecta
                    </h1>
                    <div
                        class="w-full h-1 bg-gradient-to-r from-green-100 via-blue-300 to-blue-600 rounded-full mx-auto md:mx-0 mb-4">
                    </div>
                    <p class="text-lg text-blue-100/80 mt-4 max-w-sm mx-auto md:mx-0">
                        Jelajahi setiap sudut dan temukan semua wahana seru yang kami tawarkan.
                    </p>
                </div>

                <!-- Grid Fasilitas -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-6 w-full mt-8">
                    <!-- Security -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M12 2L4 5v6c0 5.55 3.58 10.74 8 12c4.42-1.26 8-6.45 8-12V5l-8-3zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V13H5V6.3l7-3.11v9.8z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Security</span>
                    </div>

                    <!-- Toilet -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 17 16">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M11.777 15.974h-6.29s3.013-5.98-1.474-5.98V8.001h11.966s.087 1.217-2.112 2.686c-3.387 2.26-2.09 5.287-2.09 5.287zM8 6h7.979v.979H8zM3.012.009v6.974H7V.009H3.012zM6 3.036H5V1h1v2.036z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Toilet</span>
                    </div>

                    <!-- Mushola -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M4 22V8a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1h10v-1a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v14h-2v-7a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v7H4zm-2-14l10-6l10 6" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Mushola</span>
                    </div>

                    <!-- Informasi -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M13 9h-2V7h2m0 10h-2v-6h2m-1-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2Z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Informasi</span>
                    </div>

                    <!-- Kedai -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Kedai</span>
                    </div>

                    <!-- Paseban -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M7 2h10v3h3v4h2v2h-1v9h1v2H2v-2h1v-9H2V9h2V5h3V2Zm2 3h6V4H9v1Zm-4 6v9h3v-6h8v6h3v-9H5Zm13-2V7H6v2h12Zm-4 11v-4h-4v4h4Z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Paseban</span>
                    </div>

                    <!-- Souvenir -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48"
                                fill="currentColor" class="text-blue-300">
                                <g fill="none">
                                    <path d="M39 32H13L8 12h36l-5 20Z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="4" d="M3 6h3.5L8 12m0 0l5 20h26l5-20H8Z" />
                                    <circle cx="13" cy="39" r="3" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                                    <circle cx="39" cy="39" r="3" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                                </g>
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Souvenir</span>
                    </div>

                    <!-- Kamar Mandi Air Panas -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path d="M9 10V8a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2M7 10h14" />
                                    <path
                                        d="M3 22V4a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v2m-4 8h.01M14 14h.01M18 14h.01M9 18h.01M14 18h.01M19 18h.01M8 22h.01M14 22h.01M20 22h.01" />
                                </g>
                            </svg>
                        </div>
                        <span
                            class="text-xs transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Kamar
                            Mandi Air Panas</span>
                    </div>

                    <!-- Pasar Wisata -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 650 800">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M648 256q0 2 1 3t0 3v20q0 10-7 17t-17 7h-46v324q0 10-6 16t-17 7H93q-10 0-17-7t-7-16V306H23q-10 0-16-7t-7-17v-20q0-4 1-6L60 39q5-16 17-25t28-9h439q16 0 28 9t16 25zm-138 50H139v127q0 5 4 8t8 4h347q5 0 9-4t3-8V306z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-amber-300 group-hover:font-medium">Pasar
                            Wisata</span>
                    </div>

                    <!-- Kamar Bilas -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path d="M9 10V8a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2M7 10h14" />
                                    <path
                                        d="M3 22V4a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v2m-4 8h.01M14 14h.01M18 14h.01M9 18h.01M14 18h.01M19 18h.01M8 22h.01M14 22h.01M20 22h.01" />
                                </g>
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Kamar
                            Bilas</span>
                    </div>

                    <!-- P3K & Laktasi -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 1024 1024">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M839.2 278.1a32 32 0 0 0-30.4-22.1H736V144c0-17.7-14.3-32-32-32H320c-17.7 0-32 14.3-32 32v112h-72.8a31.9 31.9 0 0 0-30.4 22.1L112 502v378c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V502l-72.8-223.9zM360 184h304v72H360v-72zm480 656H184V513.4L244.3 328h535.4L840 513.4V840zM652 572H544V464c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v108H372c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h108v108c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V636h108c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8z" />
                            </svg>
                        </div>
                        <span
                            class="text-xs transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">P3K
                            & Laktasi</span>
                    </div>

                    <!-- Parkir -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M18.92 5.01C18.72 4.42 18.16 4 17.5 4h-11c-.66 0-1.21.42-1.42 1.01L3 11v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 15c-.83 0-1.5-.67-1.5-1.5S5.67 12 6.5 12s1.5.67 1.5 1.5S7.33 15 6.5 15zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5s1.5.67 1.5 1.5s-.67 1.5-1.5 1.5zM5 10l1.5-4.5h11L19 10H5z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Parkir</span>
                    </div>

                    <!-- Resto -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Resto</span>
                    </div>

                    <!-- Penitipan Barang -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M19 6h-3V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v1H5a3 3 0 0 0-3 3v9a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3Zm-9-1h4v1h-4Zm10 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-5.61L8.68 14A1.19 1.19 0 0 0 9 14h6a1.19 1.19 0 0 0 .32-.05L20 12.39Zm0-7.72L14.84 12H9.16L4 10.28V9a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1Z" />
                            </svg>
                        </div>
                        <span
                            class="text-xs transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Penitipan
                            Barang</span>
                    </div>

                    <!-- Area Terbuka -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Area
                            Terbuka</span>
                    </div>

                    <!-- Gazebo -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                                <path fill="currentColor" class="text-blue-300"
                                    d="M15.5 14.69h-1.25V7.78a.62.62 0 0 0-.25-.47L8.4 2.7a.65.65 0 0 0-.81 0L2 7.31a.62.62 0 0 0-.22.47v6.91H.5V7.78a1.87 1.87 0 0 1 .68-1.44l5.62-4.6a1.88 1.88 0 0 1 2.39 0l5.63 4.6a1.87 1.87 0 0 1 .68 1.44z" />
                                <path fill="currentColor" class="text-blue-300"
                                    d="M11.05 12.11H9.8A1.72 1.72 0 0 0 8 10.49a1.72 1.72 0 0 0-1.8 1.62H5a3 3 0 0 1 3-2.87a3 3 0 0 1 3.05 2.87zm-6.1 0H6.2v2.58H4.95zm4.85 0h1.25v2.58H9.8z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Gazebo</span>
                    </div>

                    <!-- Live Music -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M12 3v10.55c-.59-.34-1.27-.55-2-.55c-2.21 0-4 1.79-4 4s1.79 4 4 4s4-1.79 4-4V7h4V3h-6z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Live
                            Music</span>
                    </div>

                    <!-- Foto -->
                    <div
                        class="flex items-center space-x-3 group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 p-2 rounded-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor" class="text-blue-300">
                                <path
                                    d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm transition-all duration-300 group-hover:text-blue-300 group-hover:font-medium">Foto</span>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-12 text-center md:text-left">
                    <button
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl active:scale-95">
                        Lihat Peta Lengkap
                    </button>
                </div>
            </div>
        </div>
    </section>



    {{-- =================== BERITA =================== --}}
    <section class="bg-blue-50 p-4 md:min-h-[1000px] relative -mt-20 z-0 overflow-hidden rounded-t-[3rem] shadow-sm">
        <div class="flex justify-between items-center p-7">
            <div class="flex-col items-center">
                <h1
                    class="text-left p-5 text-4xl md:text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-green-500 via-blue-400 to-lime-500">
                    Berita <span
                        class="text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600">Selecta!</span>
                </h1>
                <div
                    class="w-full h-1 bg-gradient-to-r from-blue-300 via-green-300 to-blue-600 rounded-full mx-auto md:mx-0 mb-4">
                </div>
            </div>
            <a href=""
                class="md:text-md text-center font-reguler text-blue-700 underline p-4 flex items-center gap-2">
                Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    fill="currentColor" class="text-blue-700">
                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-miterlimit="10" d="m15.813 8.187l-7.626 7.626" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.111 15.155V8.917a1.028 1.028 0 0 0-1.028-1.028H8.845" />
                        <rect width="18.5" height="18.5" x="2.75" y="2.75" rx="6" />
                    </g>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-10"> <!-- Card Besar -->
            <div
                class="md:col-span-2 md:row-span-2 bg-[#FFFCFB] rounded-2xl shadow-lg flex flex-row overflow-hidden transform transition-all hover:-translate-y-1 duration-400">
                <div class="p-6 flex flex-col justify-between w-1/2">
                    <h3 class="text-sm uppercase font-bold">SELECTA NEWS</h3>
                    <p class="text-2xl font-bold mt-2">"Sekarang Selecta punya wahana baru!"</p> <button
                        class="mt-6 px-4 py-2 bg-[#093FB4] rounded-lg text-[#FFD8D8] text-sm font-semibold hover:bg-gray-200 transition">
                        MORE INFO >> </button>
                </div>
                <div class="w-1/2"> <img src="{{ asset('assets/customer/berita1.webp') }}"
                        class="w-full h-full object-cover" /> </div>
            </div> <!-- Card Kecil 1 -->
            <div
                class="bg-[#FFFCFB] rounded-2xl shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 duration-400">
                <img src="{{ asset('assets/customer/berita2.webp') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">Family Time!</h3>
                    <p class="text-lg font-semibold mt-2">"Taman cantik sayang kalo ga foto-foto!"</p>
                </div>
            </div> <!-- Card Kecil 2 -->
            <div
                class="bg-[#FFFCFB] rounded-2xl shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 duration-400">
                <img src="{{ asset('assets/customer/berita3.jpg') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">Family Time!</h3>
                    <p class="text-lg font-semibold mt-2">"50k dapet apa aja si?"</p>
                </div>
            </div>

    </section>
    <section class="bg-gray-50 py-10 md:py-20 px-4 md:px-10 overflow-hidden md:min-h-screen items-center">
        <div class="container mx-auto pt-10">
            <h2
                class="text-2xl sm:text-5xl md:text-7xl font-poppins font-bold text-center text-transparent bg-clip-text bg-gradient-to-br from-blue-500 to-blue-700 mb-8 md:mb-12 leading-snug">
                Apa kata mereka tentang <span
                    class="text-transparent bg-clip-text bg-gradient-to-br from-green-400 to-[#6ECCFF]">Selecta?</span>
            </h2>

            <!-- Swiper Container -->
            <div class="swiper mySwiperReview">
                <div class="swiper-wrapper">
                    @foreach ($review as $item)
                        <div class="swiper-slide">
                            <div
                                class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center text-center h-full transition-all hover:scale-105">
                                <img src="{{ $item['image'] }}" alt="{{ $item['user'] }}"
                                    class="w-16 h-16 rounded-full object-cover mb-4">
                                <h3 class="font-semibold text-gray-800">{{ $item['user'] }}</h3>
                                <p class="text-gray-600 text-sm mt-3 leading-relaxed">
                                    "{{ $item['komen'] }}"
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination mt-6"></div>
            </div>
        </div>
    </section>
    {{-- Promo --}}
    <section class="bg-red-50 py-16 px-4 sm:px-6 md:px-12 rounded-b-[2rem] relative  min-h-screen">

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center justify-center pt-10">

            <!-- Kolom Kiri: Swiper Card Promo -->
            <div class="w-full">
                <div class="swiper mySwiperPromo">
                    <div class="swiper-wrapper">
                        @foreach ($promo as $item)
                            <div class="swiper-slide flex justify-center">
                                <div
                                    class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all hover:-translate-y-1 duration-500 w-full max-w-lg">
                                    <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->name }}"
                                        class="w-full h-56 sm:h-64 md:h-72 object-cover" />
                                    <div class="p-4 sm:p-6">
                                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $item->name }}</h3>
                                        <p class="text-gray-600 mt-2 text-sm sm:text-base">{{ $item->description }}</p>
                                        <p class="text-base sm:text-lg font-semibold text-red-500 mt-4">
                                            Diskon {{ $item->discount_percent }}% • Berlaku sampai
                                            {{ \Carbon\Carbon::parse($item->valid_until)->translatedFormat('d F Y') }}
                                        </p>
                                        <a href=""
                                            class="mt-4 inline-block px-4 sm:px-5 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg shadow hover:from-red-600 hover:to-red-700 transition text-sm sm:text-base">Lihat
                                            SnK</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Text & Navigasi -->
            <div class="flex flex-col justify-center text-center lg:text-left">
                <h2
                    class="text-4xl sm:text-5xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-blue-400 to-blue-600 leading-tight mb-4 sm:mb-6">
                    Promo <span
                        class="text-transparent bg-clip-text bg-gradient-to-br from-red-400 via-amber-400 to-red-600">
                        Selecta 🔥
                    </span>
                </h2>
                <p class="text-gray-600 text-base sm:text-lg mb-6 sm:mb-8 max-w-md mx-auto lg:mx-0">
                    Pilih promo terbaik untuk liburanmu! Nikmati diskon menarik dan penawaran spesial dari Selecta.
                </p>

                <!-- Tombol Lihat Promo -->
                <a href="{{route('customer.get.promo')}}"
                    class="w-2/3 sm:w-1/2 mx-auto lg:mx-0 bg-gradient-to-r from-red-400 to-red-600 text-white font-semibold px-4 sm:px-6 py-3 rounded-lg shadow-md hover:from-blue-500 hover:to-blue-700 transition flex justify-center items-center gap-2 sm:gap-3 text-sm sm:text-base">
                    Lihat Promo Lainnya
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="text-white">
                            <g fill="none" stroke="currentColor">
                                <path stroke-width="2.5"
                                    d="M10.51 3.665a2 2 0 0 1 2.98 0l.7.782a2 2 0 0 0 1.601.663l1.05-.058a2 2 0 0 1 2.107 2.108l-.058 1.049a2 2 0 0 0 .663 1.6l.782.7a2 2 0 0 1 0 2.981l-.782.7a2 2 0 0 0-.663 1.601l.058 1.05a2 2 0 0 1-2.108 2.107l-1.049-.058a2 2 0 0 0-1.6.663l-.7.782a2 2 0 0 1-2.981 0l-.7-.782a2 2 0 0 0-1.601-.663l-1.05.058a2 2 0 0 1-2.107-2.108l.058-1.049a2 2 0 0 0-.663-1.6l-.782-.7a2 2 0 0 1 0-2.981l.782-.7a2 2 0 0 0 .663-1.601l-.058-1.05A2 2 0 0 1 7.16 5.053l1.049.058a2 2 0 0 0 1.6-.663l.7-.782Z" />
                                <path stroke-linejoin="round" stroke-width="3.75"
                                    d="M9.5 9.5h.01v.01H9.5zm5 5h.01v.01h-.01z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m15 9l-6 6" />
                            </g>
                        </svg>
                    </span>
                </a>

                <!-- Tombol Navigasi -->
                <div class="flex justify-center lg:justify-start space-x-4 mt-6">
                    <button
                        class="swiper-button-prev-promo w-10 sm:w-12 h-10 sm:h-12 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 sm:w-5 h-4 sm:h-5 text-gray-800"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        class="swiper-button-next-promo w-10 sm:w-12 h-10 sm:h-12 bg-white border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 sm:w-5 h-4 sm:h-5 text-gray-800"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>









@endsection
