<button id="menu-toggle"
    class="md:hidden fixed top-4 left-4 z-50 p-2 text-black rounded-sm bg-gray-100">
    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<aside id="sidebar"
    class="fixed top-0 left-0 h-screen w-64 bg-white text-black shadow-lg
           transform -translate-x-full transition-transform duration-300 ease-in-out
           md:translate-x-0 md:rounded-r-3xl z-40 overflow-y-auto">
    <div class="p-6">
        <img src="{{ asset('assets/customer/selecta-logo.png') }}" alt="Logo Selecta" class="mx-auto mb-6 w-32 h-auto" loading="lazy">
        <nav>
            <ul class="space-y-4 text-lg">
                <li class="border-b border-gray-600 pb-4 hover:text-blue-700">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.557 2.75H4.682A1.932 1.932 0 0 0 2.75 4.682v3.875a1.942 1.942 0 0 0 1.932 1.942h3.875a1.942 1.942 0 0 0 1.942-1.942V4.682A1.942 1.942 0 0 0 8.557 2.75m10.761 0h-3.875a1.942 1.942 0 0 0-1.942 1.932v3.875a1.943 1.943 0 0 0 1.942 1.942h3.875a1.942 1.942 0 0 0 1.932-1.942V4.682a1.932 1.932 0 0 0-1.932-1.932m0 10.75h-3.875a1.942 1.942 0 0 0-1.942 1.933v3.875a1.942 1.942 0 0 0 1.942 1.942h3.875a1.942 1.942 0 0 0 1.932-1.942v-3.875a1.932 1.932 0 0 0-1.932-1.932M8.557 13.5H4.682a1.943 1.943 0 0 0-1.932 1.943v3.875a1.932 1.932 0 0 0 1.932 1.932h3.875a1.942 1.942 0 0 0 1.942-1.932v-3.875a1.942 1.942 0 0 0-1.942-1.942"/></svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="border-b border-gray-600 pb-4 hover:text-blue-700">
                    <a href="{{ route('admin.get.tiket') }}"
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="m9 15l6-6"/>
                                <path fill="currentColor" d="M15.5 14.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0Zm-5-5a1 1 0 1 1-2 0a1 1 0 0 1 2 0Z"/>
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M14.004 4H9.996C6.218 4 4.33 4 3.156 5.172c-.88.877-1.1 2.154-1.156 4.322c-.007.278.221.5.49.571A2.001 2.001 0 0 1 3.986 12c0 .929-.634 1.71-1.494 1.935c-.27.07-.498.292-.49.57c.055 2.17.276 3.446 1.154 4.323M18 4.1c1.309.128 2.189.417 2.845 1.072c.878.877 1.1 2.154 1.155 4.322c.007.278-.221.5-.49.571A2.002 2.002 0 0 0 20.014 12c0 .929.634 1.71 1.494 1.935c.27.07.498.292.49.57c-.055 2.17-.276 3.446-1.154 4.323C19.67 20 17.782 20 14.004 20H9.996C8.83 20 7.841 20 7 19.965"/>
                            </g>
                        </svg>
                        <span>Tiket & Promo</span>
                    </a>
                </li>

                <li class="border-b border-gray-600 pb-4 hover:text-blue-700">
                    <a href="#"
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M5.615 21q-.69 0-1.152-.462Q4 20.075 4 19.385V6.615q0-.69.463-1.152Q4.925 5 5.615 5h1.77V3.308q0-.233.153-.386q.152-.153.385-.153t.386.153q.153.153.153.386V5h7.153V3.27q0-.214.144-.357t.356-.144q.214 0 .357.143t.143.357V5h1.77q.69 0 1.152.463q.463.462.463 1.152v12.77q0 .69-.462 1.152q-.463.463-1.153.463H5.615Zm0-1h12.77q.23 0 .423-.192q.192-.193.192-.423v-8.77H5v8.77q0 .23.192.423q.193.192.423.192ZM5 9.615h14v-3q0-.23-.192-.423Q18.615 6 18.385 6H5.615q-.23 0-.423.192Q5 6.385 5 6.615v3Zm0 0V6v3.615ZM8 13.5q-.213 0-.357-.143Q7.5 13.213 7.5 13t.143-.357Q7.787 12.5 8 12.5h8q.213 0 .357.143q.143.144.143.357t-.143.357q-.144.143-.357.143H8Zm0 4q-.213 0-.357-.143Q7.5 17.213 7.5 17t.143-.357Q7.787 16.5 8 16.5h5q.213 0 .357.143q.143.144.143.357t-.143.357q-.144.143-.357.143H8Z"/>
                        </svg>
                        <span>Informasi</span>
                    </a>
                </li>

                <li class="border-b border-gray-600 pb-4 hover:text-blue-700">
                    <a href="{{ route('admin.laporan') }}"
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M13.5 6.5v6a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h4.01m-.01 0l5 5h-4a1 1 0 0 1-1-1z"/>
                        </svg>
                        <span>Laporan</span>
                    </a>
                </li>

                <li class="border-b border-gray-600 pb-4">
                    <button onclick="toggleDropdown('resto-menu')"
                        class="flex items-center space-x-3 font-semibold w-full hover:text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M7.5 21.5v-9.035q-1.16-.177-1.964-1.063q-.805-.887-.805-2.171V2.5h1v6.73H7.5V2.5h1v6.73h1.77V2.5h1v6.73q0 1.285-.806 2.172T8.5 12.465V21.5h-1Zm9.23 0v-8h-2.46V7q0-1.671.943-2.96t2.518-1.502V21.5h-1Z" />
                        </svg>
                        <span>Restoran</span>
                        <svg class="ml-auto w-4 h-4 transition-transform duration-300" id="icon-resto-menu"
                            xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul id="resto-menu" class="hidden ml-6 mt-2 space-y-2">
                        <li><a href="#asri" class="block hover:text-blue-700">Restoran Asri</a></li>
                        <li><a href="#bahagia" class="block hover:text-blue-700">Restoran Bahagia</a></li>
                        <li><a href="#cantik" class="block hover:text-blue-700">Restoran Cantik</a></li>
                    </ul>
                </li>
                {{-- SCRIPT RESTO --}}
                <script>
                    function toggleDropdown(id) {
                        const menu = document.getElementById(id);
                        const icon = document.getElementById("icon-" + id);
                        menu.classList.toggle("hidden");
                        icon.classList.toggle("rotate-180");
                    }
                </script>

                <li class="border-b border-gray-600 pb-4 hover:text-blue-700">
                    <a href="#"
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m8.538 18.73l-.707-.707l2.134-2.146q-2.911-.387-4.938-1.452Q3 13.36 3 12q0-1.613 2.618-2.807Q8.237 8 12 8t6.382 1.193Q21 10.387 21 12q0 1.088-1.364 2.063T16 15.562V14.55q1.925-.5 2.963-1.238T20 12q0-.858-2.138-1.929T12 9q-3.725 0-5.863 1.071T4 12q0 .715 1.66 1.601t4.202 1.253l-2.031-2.03l.707-.709l3.308 3.308l-3.308 3.308Z"/>
                        </svg>
                        <span>Selecta 360</span>
                    </a>
                </li>

                <li class="border-b border-gray-600 pb-4 hover:text-blue-700">
                    <a href="#"
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M304 336v40a40 40 0 0 1-40 40H104a40 40 0 0 1-40-40V136a40 40 0 0 1 40-40h152c22.09 0 48 17.91 48 40v40m64 160l80-80l-80-80m-192 80h256"/>
                        </svg>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<script>
    const toggleBtn = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
</script>
