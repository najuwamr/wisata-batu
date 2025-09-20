<nav class="fixed z-[9999] bg-white shadow-xl w-full">
    <div class="flex items-center justify-between px-6 py-3">
        <!-- Kiri: Logo + Menu -->
        <div class="flex items-center space-x-8">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <img src="{{ asset('assets/customer/selecta-logo1.png') }}" alt="Selecta Logo" class="h-12">
            </div>

            <!-- Menu -->
            <ul class="hidden lg:flex items-center space-x-6 font-poppins font-medium text-[#373C90]">
                <li><a href="/" class="hover:text-blue-700">Tiket & Promo</a></li>
                <li><a href="/" class="hover:text-blue-700">Hotel</a></li>
                <li><a href="/" class="hover:text-blue-700">Restoran</a></li>
                <li><a href="/" class="hover:text-blue-700">Informasi</a></li>
                <li><a href="/" class="hover:text-blue-700">Selecta 360</a></li>
            </ul>
        </div>

        <!-- Mobile: Hamburger -->
        <div class="lg:hidden">
            <button id="menu-btn" class="text-[#373C90] focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Kanan: Language + Search -->
        <div class="hidden lg:flex items-center space-x-4">
            <!-- Language -->
            <button class="flex items-center space-x-2 font-poppins bg-white p-3 shadow-md rounded-lg">
                <span class="font-semibold">ID</span>
                <img src="https://flagcdn.com/w20/id.png" alt="Indonesia Flag" class="h-4 shadow-md">
            </button>

            <!-- Search -->
            <div class="flex items-center bg-[#373C90] text-white px-4 py-2 rounded-full space-x-2 shadow-md">
                <input type="text" placeholder="Cari disini"
                       class="bg-transparent focus:outline-none text-sm placeholder-white w-32 lg:w-40">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="menu" class="hidden lg:hidden px-6 pb-4">
        <ul class="flex flex-col space-y-2 font-poppins font-medium text-[#373C90]">
            <li><a href="/" class="hover:text-blue-700">Tiket & Promo</a></li>
            <li><a href="/" class="hover:text-blue-700">Hotel</a></li>
            <li><a href="/" class="hover:text-blue-700">Restoran</a></li>
            <li><a href="/" class="hover:text-blue-700">Informasi</a></li>
            <li><a href="/" class="hover:text-blue-700">Selecta 360</a></li>
        </ul>
    </div>
</nav>

<script>
    // Toggle menu mobile
    document.getElementById('menu-btn').addEventListener('click', function () {
        document.getElementById('menu').classList.toggle('hidden');
    });
</script>
