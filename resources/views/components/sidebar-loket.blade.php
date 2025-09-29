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
                    <a href="{{ route('loket.dashboard') }}"
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.557 2.75H4.682A1.932 1.932 0 0 0 2.75 4.682v3.875a1.942 1.942 0 0 0 1.932 1.942h3.875a1.942 1.942 0 0 0 1.942-1.942V4.682A1.942 1.942 0 0 0 8.557 2.75m10.761 0h-3.875a1.942 1.942 0 0 0-1.942 1.932v3.875a1.943 1.943 0 0 0 1.942 1.942h3.875a1.942 1.942 0 0 0 1.932-1.942V4.682a1.932 1.932 0 0 0-1.932-1.932m0 10.75h-3.875a1.942 1.942 0 0 0-1.942 1.933v3.875a1.942 1.942 0 0 0 1.942 1.942h3.875a1.942 1.942 0 0 0 1.932-1.942v-3.875a1.932 1.932 0 0 0-1.932-1.932M8.557 13.5H4.682a1.943 1.943 0 0 0-1.932 1.943v3.875a1.932 1.932 0 0 0 1.932 1.932h3.875a1.942 1.942 0 0 0 1.942-1.932v-3.875a1.942 1.942 0 0 0-1.942-1.942"/></svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="border-b border-gray-600 pb-4 hover:text-blue-700">
                    <a href="{{ route('loket.scan') }}"
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                            <path fill="currentColor" d="M22 24H10a2 2 0 0 1-2-2v-3h2v3h12v-3h2v3a2 2 0 0 1-2 2zM2 15h28v2H2zm22-2h-2v-3H10v3H8v-3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm6-3h-2V4h-6V2h8v8zM4 10H2V2h8v2H4v6zm6 20H2v-8h2v6h6v2zm20 0h-8v-2h6v-6h2v8z"/>
                        </svg>
                        <span>Scan</span>
                    </a>
                </li>

                <li class="border-b border-gray-600 pb-4 hover:text-blue-700">
                    <a href=" {{ route('loket.laporan') }} "
                        class="flex items-center space-x-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M13.5 6.5v6a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h4.01m-.01 0l5 5h-4a1 1 0 0 1-1-1z"/>
                        </svg>
                        <span>Laporan</span>
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
