<button id="menu-toggle"
    class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-all">
    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<aside id="sidebar"
    class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-100 shadow-lg
           transform -translate-x-full lg:translate-x-0 transition-transform duration-200 z-40 overflow-y-auto">

    <div class="p-5">
        <div class="flex justify-center mb-8">
            <img src="{{ asset('assets/customer/selecta-logo1.png') }}" alt="Logo Selecta"
                class="w-28 h-auto" loading="lazy">
        </div>

        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <button type="button"
                        onclick="toggleDropdown('tiket-promo')"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            <span>Tiket & Promo</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" id="icon-tiket-promo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <ul id="tiket-promo" class="hidden ml-4 mt-2 space-y-1 border-l border-gray-200 pl-4">
                        <li>
                            <a href="{{ route('admin.tiket.get') }}"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                <div class="w-1.5 h-1.5 bg-gray-400 hover:bg-blue-600 rounded-full"></div>
                                <span>Tiket</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.promo.get') }}"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                <div class="w-1.5 h-1.5 bg-gray-400 hover:bg-blue-600 rounded-full"></div>
                                <span>Promo</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.laporan') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Laporan</span>
                    </a>
                </li>

                <li>
                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3h10c1.87 0 2.804 0 3.5.402A3 3 0 0 1 21.598 4.5C22 5.196 22 6.13 22 8s0 2.804-.402 3.5a3 3 0 0 1-1.098 1.098C19.804 13 18.87 13 17 13h-.394c-.687 0-1.03 0-1.351-.071a3 3 0 0 1-1.183-.554c-.26-.202-.48-.465-.92-.993c-.35-.42-.526-.63-.727-.725a1 1 0 0 0-.85 0c-.201.094-.376.304-.727.725c-.44.528-.66.791-.92.993a3 3 0 0 1-1.183.554C8.425 13 8.081 13 7.394 13H7c-1.87 0-2.804 0-3.5-.402A3 3 0 0 1 2.402 11.5C2 10.804 2 9.87 2 8s0-2.804.402-3.5A3 3 0 0 1 3.5 3.402C4.196 3 5.13 3 7 3M5 6h2m5.1 13l-2.02-2m2.02 2l-2.02 2m2.02-2C7.05 19 2.81 17 2 15m13.131 3.771C18.602 18.231 21.266 16.79 22 15" color="currentColor"/>
                        </svg>
                        <span>Selecta 360</span>
                    </a>
                </li>

                <li>
                    <button type="button"
                        onclick="toggleDropdown('resto-menu')"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Restoran</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" id="icon-resto-menu" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <ul id="resto-menu" class="hidden ml-4 mt-2 space-y-1 border-l border-gray-200 pl-4">
                        <li>
                            <a href="#asri"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                <div class="w-1.5 h-1.5 bg-gray-400 hover:bg-blue-600 rounded-full"></div>
                                <span>Restoran Asri</span>
                            </a>
                        </li>
                        <li>
                            <a href="#bahagia"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                <div class="w-1.5 h-1.5 bg-gray-400 hover:bg-blue-600 rounded-full"></div>
                                <span>Restoran Bahagia</span>
                            </a>
                        </li>
                        <li>
                            <a href="#cantik"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                <div class="w-1.5 h-1.5 bg-gray-400 hover:bg-blue-600 rounded-full"></div>
                                <span>Restoran Cantik</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="pt-4 mt-4 border-t border-gray-200">
                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-30 lg:hidden hidden"></div>

<script>
const toggleBtn = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebar-overlay');

function toggleSidebar() {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}

function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
}

toggleBtn.addEventListener('click', toggleSidebar);
overlay.addEventListener('click', closeSidebar);

function toggleDropdown(menuId) {
    const menu = document.getElementById(menuId);
    const icon = document.getElementById('icon-' + menuId);

    if (menu && icon) {
        menu.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }
}

document.querySelectorAll('#sidebar a').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth < 1024) {
            closeSidebar();
        }
    });
});
</script>
