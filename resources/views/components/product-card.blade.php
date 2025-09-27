<div class="bg-blue-50 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
    {{-- Gambar --}}
    <div class="h-40 flex items-center justify-center">
        @if($product->image)
            <img src="{{ asset('images/'.$product->image) }}"
                alt="{{ $product->name }}"
                class="object-cover h-full w-full">
        @else
            <span class="text-gray-600 font-semibold">Tidak ada gambar</span>
        @endif
    </div>

    {{-- Konten --}}
    <div class="p-4">
        <h3 class="text-xl font-semibold text-blue-900 mb-1"">{{ $product->name }}</h3>
        @if(!empty($product->price))
            <p class="text-blue-800 font-medium mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        @elseif(!empty($product->code))
            <p class="text-blue-800 font-medium mb-4">Kode: {{ $product->code }}</p>
        @endif

        {{-- Tombol Aksi --}}
        <div class="flex justify-between items-center mb-2">
            <button onclick="openDetailModal({{ $product->id }})" class="flex items-center gap-1 bg-white border border-blue-600 text-blue-900 px-3 py-1 rounded-md hover:bg-blue-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 472 384">
                    <path fill="currentColor" d="M235 32q79 0 142.5 44.5T469 192q-28 71-91.5 115.5T235 352T92 307.5T0 192q28-71 92-115.5T235 32zm0 267q44 0 75-31.5t31-75.5t-31-75.5T235 85t-75.5 31.5T128 192t31.5 75.5T235 299zm-.5-171q26.5 0 45.5 18.5t19 45.5t-19 45.5t-45.5 18.5t-45-18.5T171 192t18.5-45.5t45-18.5z"/>
                </svg>
                <span>Detail</span>
            </button>
            @if ($product->is_active == false)
                <form method="POST"
                    action="{{ !empty($product->price)
                            ? route('admin.tiket.restore', $product->id)
                            : route('admin.promo.restore', $product->id) }}"
                    onsubmit="return confirm('Yakin ingin mengaktifkan kembali data ini?');">
                    @csrf
                    <button type="submit" class="flex items-center gap-1 bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m20.25 5.5l-.5 6m-14.5-6l.605 10.037c.154 2.57.232 3.855.874 4.78a4 4 0 0 0 1.2 1.132c.582.356 1.284.496 2.321.551m1.5-6.5l1.136 1.466a4 4 0 0 1 7.364-.901m1.5 4.435l-1.136-1.464a4 4 0 0 1-7.328.965M3.75 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C14.344 2 13.824 2 12.785 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.803 5.5" color="currentColor"/>
                        </svg>
                        <span>Restore</span>
                    </button>
                </form>
            @else
                <div class="flex gap-2">
                    <form method="POST"
                    action="{{ !empty($product->price)
                                    ? route('admin.tiket.delete', $product->id)
                                    : route('admin.promo.delete', $product->id) }}"
                        onsubmit="return confirm('Yakin ingin menonaktifkan data ini?');">
                        @csrf
                        <button type="submit" class="flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 256 256">
                                <path fill="currentColor" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16ZM96 40a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8v8H96Zm96 168H64V64h128Zm-80-104v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm48 0v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Z"/>
                            </svg>
                            <span>Delete</span>
                        </button>
                    </form>

                    <button onclick="openEditModal({{ $product->id }})" class="flex items-center gap-1 bg-blue-600 hover:text-blue-600 text-white border border-blue-600 px-3 py-1 rounded-md hover:bg-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                            <path fill="currentColor" d="M25 4.031c-.766 0-1.516.297-2.094.875L13 14.781l-.219.219l-.062.313l-.688 3.5l-.312 1.468l1.469-.312l3.5-.688l.312-.062l.219-.219l9.875-9.906A2.968 2.968 0 0 0 25 4.03zm0 1.938c.234 0 .465.12.688.343c.445.446.445.93 0 1.375L16 17.376l-1.719.344l.344-1.719l9.688-9.688c.222-.222.453-.343.687-.343zM4 8v20h20V14.812l-2 2V26H6V10h9.188l2-2z"/>
                        </svg>
                        <span>Edit</span>
                    </button>
                </div>
            @endif
        </div>

        {{-- Modal edit --}}
        <div id="editModal-{{ $product->id }}"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">

                <h2 class="text-xl font-bold mb-4 text-green-700">
                    Edit {{ isset($product->price) ? 'Tiket' : 'Promo' }}
                </h2>

                <form id="editForm-{{ $product->id }}"
                    method="POST"
                    enctype="multipart/form-data"
                    action="{{ isset($product->price)
                                ? route('admin.tiket.update', $product->id)
                                : route('admin.promo.update', $product->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Nama</label>
                        <input type="text"
                            name="name"
                            id="editNama-{{ $product->id }}"
                            value="{{ $product->name }}"
                            class="w-full border rounded px-3 py-2"
                            required>
                    </div>

                    @if (isset($product->price))
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Harga</label>
                            <input type="number"
                                name="price"
                                id="editPrice-{{ $product->id }}"
                                value="{{ $product->price }}"
                                class="w-full border rounded px-3 py-2"
                                required>
                        </div>
                    @elseif (isset($product->code))
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Kode Promo</label>
                            <input type="text"
                                name="code"
                                id="editCode-{{ $product->id }}"
                                value="{{ $product->code }}"
                                class="w-full border rounded px-3 py-2"
                                required>
                        </div>
                    @endif

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Deskripsi</label>
                        <textarea name="description"
                                id="editDeskripsi-{{ $product->id }}"
                                rows="3"
                                class="w-full border rounded px-3 py-2"
                                required>{{ $product->description }}</textarea>
                    </div>

                    {{-- Gambar --}}
                    <div class="mb-4 text-left">
                        <label class="block text-sm text-gray-700 mb-1">Gambar</label>
                        <img id="previewGambar-{{ $product->id }}"
                            src="{{ asset('images/' . $product->image) }}"
                            alt="Preview Gambar"
                            class="w-full h-40 object-contain rounded border mb-2">
                        <input type="file"
                            name="image"
                            accept="image/*"
                            onchange="previewImage(event, {{ $product->id }})"
                            class="w-full border rounded p-2">
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-2">
                        <button type="button"
                                onclick="closeEditModal({{ $product->id }})"
                                class="px-4 py-2 rounded border border-gray-400 text-gray-600 hover:bg-gray-100">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal detail --}}
        <div id="detailModal-{{ $product->id }}"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
                <h2 class="text-2xl font-bold text-green-700 mb-4">
                    Detail {{ isset($product->price) ? 'Tiket' : 'Promo' }}
                </h2>

                <img id="detailGambar-{{ $product->id }}"
                    src="{{ asset('images/' . $product->image) }}"
                    class="w-full h-48 object-contain rounded border mb-4"
                    alt="Gambar Produk">

                <p><strong>Nama:</strong> {{ $product->name }}</p>

                @if (isset($product->price))
                    <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                @elseif (isset($product->code))
                    <p><strong>Kode Promo:</strong> {{ $product->code }}</p>
                @endif

                <p><strong>Deskripsi:</strong></p>
                <p id="detailDeskripsi-{{ $product->id }}" class="whitespace-pre-line">
                    {{ $product->description }}
                </p>

                <button onclick="closeDetailModal({{ $product->id }})"
                        class="absolute top-3 right-4 text-gray-500 hover:text-red-500">
                    <i data-feather="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <script>
            function openEditModal(id) {
                document.getElementById(`editModal-${id}`).classList.remove('hidden');
            }

            function closeEditModal(id) {
                document.getElementById(`editModal-${id}`).classList.add('hidden');
            }

            function openDetailModal(id) {
                document.getElementById(`detailModal-${id}`).classList.remove('hidden');
            }

            function closeDetailModal(id) {
                document.getElementById(`detailModal-${id}`).classList.add('hidden');
            }

            function previewImage(event, id) {
                const reader = new FileReader();
                reader.onload = function(){
                    document.getElementById(`previewGambar-${id}`).src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
    </div>
</div>
