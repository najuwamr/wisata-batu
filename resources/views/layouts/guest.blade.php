<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Selecta</title>

    <!-- Preload Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sofia+Sans&display=swap" rel="stylesheet">

    <!-- Ikon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/customer/selecta-logo1.png') }}">

    <!-- CSS External -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/customer/landing.js'])

    <!-- Vite Resources -->


</head>

<body>
    @include('components.navbar')
    @yield('content')
    @include('components.footer')

    <!-- JavaScript Libraries -->

    <script src="{{ asset('js/three.min.js') }}"></script>
    <script src="{{ asset('js/panolens.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <!-- Inisialisasi AOS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi AOS
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });
        });
    </script>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        </script>
    @endif
    @php
        // Definisikan nomor WhatsApp dan pesan default di sini
        // Format nomor: 62... (kode negara + nomor tanpa spasi/simbol)
        $waNumber = '6281336104254'; // <-- GANTI DENGAN NOMOR MARKETING ANDA
        $waMessage = 'Halo, saya tertarik dengan layanan Anda dan ingin bertanya lebih lanjut.';

        // URL-encode pesan untuk format link yang benar
        $encodedMessage = urlencode($waMessage);
        $waLink = "https://wa.me/{$waNumber}?text={$encodedMessage}";
    @endphp

    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
        class="fixed bottom-6 right-6 z-50 flex items-center justify-center p-3 bg-gradient-to-br from-green-400 to-green-500 rounded-full shadow-lg transition-all duration-300 ease-in-out hover:bg-green-600 hover:scale-110 group">

        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 432 432">
            <path fill="currentColor" class="text-white"
                d="M364.5 65Q427 127 427 214.5T364.5 364T214 426q-54 0-101-26L0 429l30-109Q2 271 2 214q0-87 62-149T214 3t150.5 62zM214 390q73 0 125-51.5T391 214T339 89.5T214 38T89.5 89.5T38 214q0 51 27 94l4 6l-18 65l67-17l6 3q42 25 90 25zm97-132q9 5 10 7q4 6-3 25q-3 8-15 15.5t-21 9.5q-18 2-33-2q-17-6-30-11q-8-4-15.5-8.5t-14.5-9t-13-9.5t-11.5-10t-10.5-10.5t-8.5-9.5t-7-8.5t-5.5-7t-3.5-5L128 222q-22-29-22-55q0-24 19-44q6-7 14-7q6 0 10 1q8 0 12 9q2 3 6 13l7 17.5l3 8.5q3 5 1 9q-3 7-5 9l-3 3l-3 3.5l-2 2.5q-6 6-3 11q13 22 30 37q13 11 43 26q7 3 11-1q12-15 17-21q4-6 12-3q6 3 36 17z" />
        </svg>


    </a>
</body>

</html>
