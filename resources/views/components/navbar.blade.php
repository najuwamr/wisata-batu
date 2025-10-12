<nav id="navbar"
    class="fixed z-[9999] bg-white shadow-xl w-full transform -translate-y-full transition-transform duration-300 ease-in-out rounded-b-[1rem]">
    <div class="flex items-center justify-between px-6 py-3">
        <div class="flex items-center space-x-8">
            <div class="flex-shrink-0">
                <a href="/"><img src="{{ asset('assets/customer/selecta-logo1.png') }}" alt="Selecta Logo"
                        class="h-12"></a>

            </div>

            <ul class="hidden lg:flex items-center space-x-6 font-poppins font-medium text-blue-700">
                <!-- Tiket & Promo Dropdown -->
                <li class="relative group">
                    <button class="flex items-center space-x-1 hover:text-blue-700 transition-colors duration-200 py-2">
                        <span class="text-[#ff0f0f]">Tiket & Promo</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            class="transition-transform duration-200 group-hover:rotate-180">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.5" d="m7 10l5 5m0 0l5-5" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-left scale-95 group-hover:scale-100">
                        <div class="p-4">
                            <div class="space-y-3">
                                <a href="{{ route('guest.tiket') }}"
                                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 group/item">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path
                                                d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z" />
                                            <path d="M13 5v2M13 17v2M13 11v2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover/item:text-blue-600">Cari Tiket
                                        </p>
                                        <p class="text-sm text-gray-500">Berbagai pilihan tiket</p>
                                    </div>
                                </a>

                                <a href="{{ route('guest.promo') }}"
                                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 group/item">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor" class="text-white"
                                                d="m11.496 1.19l10.506.808l.808 10.505l-10.932 10.932L.564 12.121L11.496 1.19Zm.764 2.064l-8.867 8.867l8.485 8.486l8.867-8.868l-.606-7.879l-7.879-.606Zm3.86 4.624a1 1 0 1 0-1.414 1.414a1 1 0 0 0 1.414-1.414Zm-2.828-1.414a3 3 0 1 1 4.243 4.242a3 3 0 0 1-4.243-4.242Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover/item:text-blue-600">Promo
                                            Spesial</p>
                                        <p class="text-sm text-gray-500">Diskon & penawaran</p>
                                    </div>
                                </a>
                                <a href="#"
                                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 group/item">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor" class="text-white"
                                                d="m11.496 1.19l10.506.808l.808 10.505l-10.932 10.932L.564 12.121L11.496 1.19Zm.764 2.064l-8.867 8.867l8.485 8.486l8.867-8.868l-.606-7.879l-7.879-.606Zm3.86 4.624a1 1 0 1 0-1.414 1.414a1 1 0 0 0 1.414-1.414Zm-2.828-1.414a3 3 0 1 1 4.243 4.242a3 3 0 0 1-4.243-4.242Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover/item:text-blue-600">Paket
                                            Selecta</p>
                                        <p class="text-sm text-gray-500">Lihat paket lainnya</p>
                                    </div>
                                </a>


                            </div>
                        </div>
                    </div>
                </li>

                <li><a href="/" class="hover:text-blue-700 transition-colors duration-200 py-2 block">Hotel</a>
                </li>
                <li class="relative group">
                    <button class="flex items-center space-x-1 hover:text-blue-700 transition-colors duration-200 py-2">
                        <span class="text-blu-700">Restoran</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            class="transition-transform duration-200 group-hover:rotate-180">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.5" d="m7 10l5 5m0 0l5-5" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-left scale-95 group-hover:scale-100">
                        <div class="p-4">
                            <div class="space-y-3">
                                <a href="{{ route('guest.tiket') }}"
                                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 group/item">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor" class="text-white"
                                                d="M18 3a1 1 0 0 1 .993.883L19 4v16a1 1 0 0 1-1.993.117L17 20v-5h-1a1 1 0 0 1-.993-.883L15 14V8c0-2.21 1.5-5 3-5Zm-6 0a1 1 0 0 1 .993.883L13 4v5a4.002 4.002 0 0 1-3 3.874V20a1 1 0 0 1-1.993.117L8 20v-7.126a4.002 4.002 0 0 1-2.995-3.668L5 9V4a1 1 0 0 1 1.993-.117L7 4v5a2 2 0 0 0 1 1.732V4a1 1 0 0 1 1.993-.117L10 4l.001 6.732a2 2 0 0 0 .992-1.563L11 9V4a1 1 0 0 1 1-1Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover/item:text-red-600">Restoran
                                            Asri
                                        </p>
                                        <p class="text-sm text-gray-500">Masakan Chinese</p>
                                    </div>
                                </a>

                                <a href="/"
                                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 group/item">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor" class="text-white"
                                                d="M18 3a1 1 0 0 1 .993.883L19 4v16a1 1 0 0 1-1.993.117L17 20v-5h-1a1 1 0 0 1-.993-.883L15 14V8c0-2.21 1.5-5 3-5Zm-6 0a1 1 0 0 1 .993.883L13 4v5a4.002 4.002 0 0 1-3 3.874V20a1 1 0 0 1-1.993.117L8 20v-7.126a4.002 4.002 0 0 1-2.995-3.668L5 9V4a1 1 0 0 1 1.993-.117L7 4v5a2 2 0 0 0 1 1.732V4a1 1 0 0 1 1.993-.117L10 4l.001 6.732a2 2 0 0 0 .992-1.563L11 9V4a1 1 0 0 1 1-1Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover/item:text-amber-500">Restoran
                                            Bahagia
                                        </p>
                                        <p class="text-sm text-gray-500">Masakan Bakaran</p>
                                    </div>
                                </a>
                                <a href="#"
                                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 group/item">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-gray-400 to-gray-600 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor" class="text-white"
                                                d="M18 3a1 1 0 0 1 .993.883L19 4v16a1 1 0 0 1-1.993.117L17 20v-5h-1a1 1 0 0 1-.993-.883L15 14V8c0-2.21 1.5-5 3-5Zm-6 0a1 1 0 0 1 .993.883L13 4v5a4.002 4.002 0 0 1-3 3.874V20a1 1 0 0 1-1.993.117L8 20v-7.126a4.002 4.002 0 0 1-2.995-3.668L5 9V4a1 1 0 0 1 1.993-.117L7 4v5a2 2 0 0 0 1 1.732V4a1 1 0 0 1 1.993-.117L10 4l.001 6.732a2 2 0 0 0 .992-1.563L11 9V4a1 1 0 0 1 1-1Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover/item:text-blue-600">Restoran
                                            Cantik</p>
                                        <p class="text-sm text-gray-500">Masakan Oriental</p>
                                    </div>
                                </a>


                            </div>
                        </div>
                    </div>
                </li>

                <!-- Informasi Dropdown -->
                <li class="relative group">
                    <button
                        class="flex items-center space-x-1 hover:text-blue-700 transition-colors duration-200 py-2">
                        <span>Informasi</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            class="transition-transform duration-200 group-hover:rotate-180">
                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2.5" d="m7 10l5 5m0 0l5-5" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        class="absolute top-full left-0 mt-2 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-left scale-95 group-hover:scale-100">
                        <div class="p-4">
                            <div class="space-y-3">
                                <a href="#"
                                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 group/item">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover/item:text-blue-600">Tentang
                                            Selecta</p>
                                        <p class="text-sm text-gray-500">Profil & sejarah</p>
                                    </div>
                                </a>

                                <a href="#"
                                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 group/item">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover/item:text-blue-600">Berita
                                            Selecta</p>
                                        <p class="text-sm text-gray-500">Cari tahu kabar terbaru</p>
                                    </div>
                                </a>


                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li><a href="/" class="hover:text-blue-700 transition-colors duration-200 py-2 block">Selecta
                        360</a></li>
            </ul>
        </div>

        <div class="lg:hidden">
            <button id="menu-btn" class="text-[#373C90] focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div class="hidden lg:flex items-center space-x-4">
            <button
                class="flex items-center space-x-2 font-poppins bg-white p-3 shadow-md rounded-lg hover:shadow-lg transition-shadow duration-200">
                <span class="font-semibold">ID</span>
                <img src="https://flagcdn.com/w20/id.png" alt="Indonesia Flag" class="h-4 shadow-md">
            </button>

            <div
                class="flex items-center bg-gradient-to-br from-blue-600 to-blue-700 text-white px-4 py-2 rounded-full space-x-2 shadow-md hover:shadow-lg transition-shadow duration-200">
                <input type="text" placeholder="Cari disini"
                    class="bg-transparent focus:outline-none text-sm placeholder-white w-32 lg:w-40">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <!-- Mobile Menu -->
    <div id="menu" class="hidden lg:hidden px-6 pb-4 bg-white border-t border-gray-200">
        <ul class="flex flex-col space-y-3 font-poppins font-medium text-[#373C90]">
            <!-- Tiket & Promo Mobile -->
            <li>
                <button class="flex items-center justify-between w-full py-2 hover:text-blue-700"
                    onclick="toggleMobileDropdown('tiket-dropdown')">
                    <span class="text-[#ff0f0f]">Tiket & Promo</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        class="transition-transform duration-200" id="tiket-arrow">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2.5" d="m7 10l5 5m0 0l5-5" />
                    </svg>
                </button>
                <div id="tiket-dropdown" class="hidden ml-4 mt-2 space-y-2 border-l-2 border-blue-200 pl-4">
                    <a href="{{ route('guest.tiket') }}" class="block py-2 text-gray-600 hover:text-blue-700">Cari
                        Tiket</a>
                    <a href="{{ route('guest.promo') }}" class="block py-2 text-gray-600 hover:text-blue-700">Promo
                        Spesial</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-blue-700">Paket Selecta</a>
                </div>
            </li>

            <li><a href="/" class="block py-2 hover:text-blue-700">Hotel</a></li>

            <!-- Restoran Mobile -->
            <li>
                <button class="flex items-center justify-between w-full py-2 hover:text-blue-700"
                    onclick="toggleMobileDropdown('restoran-dropdown')">
                    <span>Restoran</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        class="transition-transform duration-200" id="restoran-arrow">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2.5" d="m7 10l5 5m0 0l5-5" />
                    </svg>
                </button>
                <div id="restoran-dropdown" class="hidden ml-4 mt-2 space-y-2 border-l-2 border-blue-200 pl-4">
                    <a href="#" class="block py-2 text-gray-600 hover:text-blue-700">Restoran Asri</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-blue-700">Restoran Bahagia</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-blue-700">Restoran Cantik</a>
                </div>
            </li>

            <!-- Informasi Mobile -->
            <li>
                <button class="flex items-center justify-between w-full py-2 hover:text-blue-700"
                    onclick="toggleMobileDropdown('info-dropdown')">
                    <span>Informasi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        class="transition-transform duration-200" id="info-arrow">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2.5" d="m7 10l5 5m0 0l5-5" />
                    </svg>
                </button>
                <div id="info-dropdown" class="hidden ml-4 mt-2 space-y-2 border-l-2 border-blue-200 pl-4">
                    <a href="#" class="block py-2 text-gray-600 hover:text-blue-700">Tentang Selecta</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-blue-700">Berita Selecta</a>
                </div>
            </li>

            <li><a href="/" class="block py-2 hover:text-blue-700">Selecta 360</a></li>
        </ul>

        <!-- Mobile Search & Language -->
        <div class="mt-6 space-y-4">
            <div class="flex items-center bg-gradient-to-br from-blue-600 to-blue-700 text-white px-4 py-3 rounded-full space-x-2">
                <input type="text" placeholder="Cari disini"
                    class="bg-transparent focus:outline-none text-sm placeholder-white w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                </svg>
            </div>

            <button
                class="flex items-center space-x-2 font-poppins bg-white p-3 shadow-md rounded-lg w-full justify-center">
                <span class="font-semibold">Bahasa Indonesia (ID)</span>
                <img src="https://flagcdn.com/w20/id.png" alt="Indonesia Flag" class="h-4 shadow-md">
            </button>
        </div>
    </div>
</nav>

<script>
    // Script untuk menampilkan navbar saat scroll
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.remove('-translate-y-full');
        } else {
            navbar.classList.add('-translate-y-full');
        }
    });

    // Toggle menu mobile utama
    document.getElementById('menu-btn').addEventListener('click', function() {
        document.getElementById('menu').classList.toggle('hidden');
    });

    // Fungsi untuk toggle dropdown mobile
    function toggleMobileDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const arrow = document.getElementById(dropdownId.replace('-dropdown', '-arrow'));

        dropdown.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    // Close dropdown ketika klik di luar
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.group')) {
            // Untuk desktop, tidak perlu close karena menggunakan hover
        }
    });
</script>

<style>
    /* Smooth transitions for dropdown */
    .group:hover .transition-all {
        transition: all 0.3s ease-in-out;
    }

    /* Custom scrollbar for dropdowns */
    .overflow-y-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
</style>
