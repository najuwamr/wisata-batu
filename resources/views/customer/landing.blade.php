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
    {{-- =================== HERO VIDEO =================== --}}
    <section class="relative w-full h-screen overflow-hidden">
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('assets/customer/vid-profil.mp4') }}" type="video/mp4" loading="lazy">
            Browser Anda tidak mendukung video.
        </video>

        <div class="absolute inset-0 bg-black/50"></div>

        <img src="{{ asset('assets/customer/truly6.png') }}" alt="Truly Picnic"
            class="absolute top-1/2 left-1/2 w-1/2 md:w-1/3 md:top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20">


        <!-- Wave di bawah hero -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[100px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100"
                preserveAspectRatio="none">
                <path fill="#FFFCFB" d="M0,30 C360,90 1080,-30 1440,60 L1440,100 L0,100Z">
                </path>
            </svg>
        </div>
    </section>

    {{-- =================== TIKET TERBAIK =================== --}}
    <section class="bg-[#FFFCFB] py-10 min-h-[700px] text-center pr-10 relative rounded-b-9xl">
        <h1 class="text-4xl md:text-7xl mx-10 font-semibold text-[#093FB4] font-poppins">
            Pilihan <span class="text-[#ED3500]">Tiket</span>
        </h1>
    </section>


    <!-- Wave -->


    {{-- =================== Info =================== --}}

    {{-- <section class= "w-full relative h-[1000px]">
        <div class="bg-blue-50 w-1/3 h-full text-center">Gallery Selecta</div>



    </section> --}}




    {{-- =================== PETA SELECTA =================== --}}
    <section class="">
        <img src="{{ asset('assets/customer/peta2.jpg') }}" alt="" class="w-full">

    </section>

     <section class="bg-[#477fc1] p-4 md:min-h-[1000px] relative -mt-20 z-0">
        <div class="flex justify-between items-center p-7">
            <h1 class="text-left p-5 text-4xl md:text-left md:text-7xl font-bold text-[#ED3500] ">Kepo <span
                    class="text-[#093FB4]">Selecta!</span></h1>
            <a href=""
                class="md:text-2xl text-center font-reguler text-[#093FB4] underline p-4 flex items-center gap-2">Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#093FB4">
                    <g fill="none" stroke="#093FB4" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-miterlimit="10" d="m15.813 8.187l-7.626 7.626" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.111 15.155V8.917a1.028 1.028 0 0 0-1.028-1.028H8.845" />
                        <rect width="18.5" height="18.5" x="2.75" y="2.75" rx="6" />
                    </g>
                </svg></a>



        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-10">
            <!-- Card Besar (span 2 kolom, 2 baris) -->
            <div
                class="md:col-span-2 md:row-span-2 bg-[#FFFCFB] rounded-2xl shadow-lg flex flex-row md:flex-row overflow-hidden">
                <div class="p-6 flex flex-col justify-between w-1/2 md:w-1/2">
                    <h3 class="text-sm uppercase font-bold">SELECTA NEWS</h3>
                    <p class="text-2xl font-bold mt-2">
                        "Super fun! There's a lot of exciting activities you can choose!"
                    </p>

                    <button
                        class="mt-6 px-4 py-2 bg-[#093FB4] rounded-lg text-[#FFD8D8] text-sm font-semibold hover:bg-gray-200 transition">
                        MORE INFO >>
                    </button>
                </div>
                <div class="w-1/2 md:w-1/2">
                    <img src="{{ asset('assets/customer/peta-selecta1.jpg') }}"
                        class="w-full h-full md:w-full md:h-full object-cover" />
                </div>
            </div>

            <!-- Card Kecil 1 -->
            <div class="bg-[#FFFCFB] rounded-2xl shadow-lg overflow-hidden">
                <img src="{{ asset('assets/customer/peta-selecta1.jpg') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">FEEDING TIME!</h3>
                    <p class="text-lg font-semibold mt-2">"The giraffe is so majestic and pretty"</p>
                </div>
            </div>

            <!-- Card Kecil 2 -->
            <div class="bg-[#FFFCFB] rounded-2xl shadow-lg overflow-hidden">
                <img src="{{ asset('assets/customer/peta-selecta1.jpg') }}" class="w-full h-40 object-cover" />
                <div class="p-4">
                    <h3 class="text-sm uppercase font-bold">ENCHANTING SHOWS</h3>
                    <p class="text-lg font-semibold mt-2">"Amazing! A True Voyage of Fantasy"</p>
                </div>
            </div>
        </div>



    </section>

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
