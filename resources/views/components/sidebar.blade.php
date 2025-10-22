{{-- Tombol Toggle untuk Mobile --}}
<button id="menu-toggle"
    class="lg:hidden fixed top-4 left-4 z-50 p-2 text-black rounded-sm bg-gray-100">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

{{-- Sidebar --}}
<aside id="sidebar"
    class="fixed top-0 left-0 h-screen w-64 bg-white text-black shadow-lg
           transform -translate-x-full transition-transform duration-300 ease-in-out
           lg:translate-x-0 lg:rounded-r-3xl z-40 overflow-y-auto">

    <div class="p-6">
        {{-- Logo --}}
        <img src="{{ asset('assets/customer/selecta-logo1.png') }}" alt="Logo Selecta"
            class="mx-auto mb-6 w-32 h-auto" loading="lazy">

        {{-- Navigasi --}}
        <nav>
            <ul class="space-y-4 text-lg">

                {{-- Dashboard --}}
                <li class="border-b border-gray-200 pb-3 hover:text-blue-700">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 15 15">
                            <path fill="currentColor" fill-rule="evenodd" d="M2.8 1h-.05c-.229 0-.426 0-.6.041A1.5 1.5 0 0 0 1.04 2.15c-.04.174-.04.37-.04.6v2.5c0 .229 0 .426.041.6A1.5 1.5 0 0 0 2.15 6.96c.174.04.37.04.6.04h2.5c.229 0 .426 0 .6-.041A1.5 1.5 0 0 0 6.96 5.85c.04-.174.04-.37.04-.6v-2.5c0-.229 0-.426-.041-.6A1.5 1.5 0 0 0 5.85 1.04C5.676 1 5.48 1 5.25 1H2.8Zm-.417 1.014c.043-.01.11-.014.417-.014h2.4c.308 0 .374.003.417.014a.5.5 0 0 1 .37.37c.01.042.013.108.013.416v2.4c0 .308-.003.374-.014.417a.5.5 0 0 1-.37.37C5.575 5.996 5.509 6 5.2 6H2.8c-.308 0-.374-.003-.417-.014a.5.5 0 0 1-.37-.37C2.004 5.575 2 5.509 2 5.2V2.8c0-.308.003-.374.014-.417a.5.5 0 0 1 .37-.37ZM9.8 1h-.05c-.229 0-.426 0-.6.041A1.5 1.5 0 0 0 8.04 2.15c-.04.174-.04.37-.04.6v2.5c0 .229 0 .426.041.6A1.5 1.5 0 0 0 9.15 6.96c.174.04.37.04.6.04h2.5c.229 0 .426 0 .6-.041a1.5 1.5 0 0 0 1.11-1.109c.04-.174.04-.37.04-.6v-2.5c0-.229 0-.426-.041-.6a1.5 1.5 0 0 0-1.109-1.11c-.174-.04-.37-.04-.6-.04H9.8Zm-.417 1.014c.043-.01.11-.014.417-.014h2.4c.308 0 .374.003.417.014a.5.5 0 0 1 .37.37c.01.042.013.108.013.416v2.4c0 .308-.004.374-.014.417a.5.5 0 0 1-.37.37c-.042.01-.108.013-.416.013H9.8c-.308 0-.374-.003-.417-.014a.5.5 0 0 1-.37-.37C9.004 5.575 9 5.509 9 5.2V2.8c0-.308.003-.374.014-.417a.5.5 0 0 1 .37-.37ZM2.75 8h2.5c.229 0 .426 0 .6.041A1.5 1.5 0 0 1 6.96 9.15c.04.174.04.37.04.6v2.5c0 .229 0 .426-.041.6a1.5 1.5 0 0 1-1.109 1.11c-.174.04-.37.04-.6.04h-2.5c-.229 0-.426 0-.6-.041a1.5 1.5 0 0 1-1.11-1.109c-.04-.174-.04-.37-.04-.6v-2.5c0-.229 0-.426.041-.6A1.5 1.5 0 0 1 2.15 8.04c.174-.04.37-.04.6-.04Zm.05 1c-.308 0-.374.003-.417.014a.5.5 0 0 0-.37.37C2.004 9.425 2 9.491 2 9.8v2.4c0 .308.003.374.014.417a.5.5 0 0 0 .37.37c.042.01.108.013.416.013h2.4c.308 0 .374-.004.417-.014a.5.5 0 0 0 .37-.37c.01-.042.013-.108.013-.416V9.8c0-.308-.003-.374-.014-.417a.5.5 0 0 0-.37-.37C5.575 9.004 5.509 9 5.2 9H2.8Zm7-1h-.05c-.229 0-.426 0-.6.041A1.5 1.5 0 0 0 8.04 9.15c-.04.174-.04.37-.04.6v2.5c0 .229 0 .426.041.6a1.5 1.5 0 0 0 1.109 1.11c.174.041.371.041.6.041h2.5c.229 0 .426 0 .6-.041a1.5 1.5 0 0 0 1.109-1.109c.041-.174.041-.371.041-.6V9.75c0-.229 0-.426-.041-.6a1.5 1.5 0 0 0-1.109-1.11c-.174-.04-.37-.04-.6-.04H9.8Zm-.417 1.014c.043-.01.11-.014.417-.014h2.4c.308 0 .374.003.417.014a.5.5 0 0 1 .37.37c.01.042.013.108.013.416v2.4c0 .308-.004.374-.014.417a.5.5 0 0 1-.37.37c-.042.01-.108.013-.416.013H9.8c-.308 0-.374-.004-.417-.014a.5.5 0 0 1-.37-.37C9.004 12.575 9 12.509 9 12.2V9.8c0-.308.003-.374.014-.417a.5.5 0 0 1 .37-.37Z" clip-rule="evenodd"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Tiket & Promo Dropdown --}}
                <li class="border-b border-gray-200 pb-3">
                    <button onclick="toggleDropdown('tiket-promo', 'icon-tiket-promo')"
                        class="flex items-center space-x-3 font-semibold w-full hover:text-blue-700">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                            <path fill="currentcolor" d="M59.6 26.4c1.5-.1 2.7-1.3 2.7-2.9V18c0-3.4-2.7-6.1-6.1-6.1H7.9c-3.4 0-6.1 2.7-6.1 6.1v5.6c0 1.5 1.2 2.8 2.7 2.9c2.8.3 4.9 2.7 4.9 5.6s-2.1 5.3-4.9 5.5c-1.5.1-2.7 1.4-2.7 2.9V46c0 3.4 2.7 6.1 6.1 6.1h48.3c3.4 0 6.1-2.7 6.1-6.1v-5.5c0-1.5-1.2-2.8-2.7-2.9c-2.8-.3-4.9-2.7-4.9-5.6c0-3 2.1-5.4 4.9-5.6m-1.8 15.4V46c0 .9-.7 1.6-1.6 1.6H31.7v-5.4c0-1.2-1-2.3-2.3-2.3s-2.3 1-2.3 2.3v5.4H7.9c-.9 0-1.6-.7-1.6-1.6v-4c4.4-1 7.6-5 7.6-9.8c0-4.7-3.2-8.8-7.6-9.9V18c0-.9.7-1.6 1.6-1.6h19.3v5.4c0 1.2 1 2.3 2.3 2.3s2.3-1 2.3-2.3v-5.4h24.4c.9 0 1.6.7 1.6 1.6v4.1c-4.4 1.1-7.6 5.1-7.6 9.9c0 4.7 3.2 8.7 7.6 9.8"/>
                            <path fill="#000000" d="M29.5 27.2c-1.2 0-2.3 1-2.3 2.3v5.1c0 1.2 1 2.3 2.3 2.3s2.3-1 2.3-2.3v-5.1c-.1-1.3-1.1-2.3-2.3-2.3"/>
                        </svg>
                        <span>Tiket & Promo</span>
                        <svg class="ml-auto w-4 h-4 transition-transform duration-300"
                            id="icon-tiket-promo" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul id="tiket-promo" class="hidden ml-6 mt-2 space-y-2 text-base">
                        <li>
                            <a href="{{ route('admin.tiket.get') }}" class="block hover:text-blue-700">
                                Tiket
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.promo.get') }}" class="block hover:text-blue-700">
                                Promo
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Laporan --}}
                <li class="border-b border-gray-200 pb-3 hover:text-blue-700">
                    <a href="{{ route('admin.laporan') }}" class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 16 16" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M13.5 6.5v6a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h4.01m-.01 0l5 5h-4a1 1 0 0 1-1-1z" />
                        </svg>
                        <span>Laporan</span>
                    </a>
                </li>

                {{-- Restoran Dropdown --}}
                <li class="border-b border-gray-200 pb-3">
                    <button onclick="toggleDropdown('resto-menu', 'icon-resto-menu')"
                        class="flex items-center space-x-3 font-semibold w-full hover:text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M7.5 21.5v-9.035q-1.16-.177-1.964-1.063q-.805-.887-.805-2.171V2.5h1v6.73H7.5V2.5h1v6.73h1.77V2.5h1v6.73q0 1.285-.806 2.172T8.5 12.465V21.5h-1Zm9.23 0v-8h-2.46V7q0-1.671.943-2.96t2.518-1.502V21.5h-1Z" />
                        </svg>
                        <span>Restoran</span>
                        <svg class="ml-auto w-4 h-4 transition-transform duration-300"
                            id="icon-resto-menu" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul id="resto-menu" class="hidden ml-6 mt-2 space-y-2 text-base">
                        <li><a href="#asri" class="block hover:text-blue-700">Restoran Asri</a></li>
                        <li><a href="#bahagia" class="block hover:text-blue-700">Restoran Bahagia</a></li>
                        <li><a href="#cantik" class="block hover:text-blue-700">Restoran Cantik</a></li>
                    </ul>
                </li>

                {{-- Logout --}}
                <li class="border-b border-gray-200 pb-3 hover:text-blue-700">
                    <a href="#" class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 512 512" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="32">
                            <path
                                d="M304 336v40a40 40 0 0 1-40 40H104a40 40 0 0 1-40-40V136a40 40 0 0 1 40-40h152c22.09 0 48 17.91 48 40v40m64 160l80-80l-80-80m-192 80h256" />
                        </svg>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

{{-- Script Toggle Sidebar & Dropdown --}}
<script>
    const toggleBtn = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    function toggleDropdown(menuId, iconId) {
        const menu = document.getElementById(menuId);
        const icon = document.getElementById(iconId);

        menu.classList.toggle("hidden");
        icon.classList.toggle("rotate-180");
    }
</script>
