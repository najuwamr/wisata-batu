{{-- components/product-card.blade.php --}}
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
        <h3 class="text-xl font-semibold text-blue-900 mb-1">{{ $product->name }}</h3>

        @if(!empty($product->price))
            <p class="text-blue-800 font-medium mb-4">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
        @elseif(!empty($product->code))
            <p class="text-blue-800 font-medium mb-4">
                Kode: {{ $product->code }}
            </p>
        @endif

        {{-- Fasilitas (alias aset terkait) --}}
        @if(!empty($product->price) && $product->assets && $product->assets->count() > 0)
            <div class="mb-3">
                <p class="text-sm text-gray-600 font-semibold">Fasilitas:</p>
                <div class="flex flex-wrap gap-1 mt-1">
                    @foreach($product->assets as $asset)
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                            {{ $asset->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Tombol aksi --}}
        <div class="flex justify-between items-center mb-2">
            {{-- Detail --}}
            <button onclick="openDetailModal('{{ $product->id }}')" 
                    class="flex items-center cursor-pointer gap-1 bg-white border border-blue-600 text-blue-900 px-3 py-1 rounded-md hover:bg-blue-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 472 384">
                    <path fill="currentColor" d="M235 32q79 0 142.5 44.5T469 192q-28 71-91.5 115.5T235 352T92 307.5T0 192q28-71 92-115.5T235 32zm0 267q44 0 75-31.5t31-75.5t-31-75.5T235 85t-75.5 31.5T128 192t31.5 75.5T235 299zm-.5-171q26.5 0 45.5 18.5t19 45.5t-19 45.5t-45.5 18.5t-45-18.5T171 192t18.5-45.5t45-18.5z"/>
                </svg>
                <span>Detail</span>
            </button>

            {{-- Tombol hapus & edit --}}
            <div class="flex gap-2">
                <form method="POST"
                      action="{{ !empty($product->price)
                          ? route('admin.tiket.delete', $product->id)
                          : route('admin.promo.delete', $product->id) }}"
                      onsubmit="return confirm('Yakin ingin menonaktifkan data ini?');">
                    @csrf
                    <button type="submit"
                        class="flex cursor-pointer items-center gap-1 bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 256 256">
                            <path fill="currentColor" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16ZM96 40a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8v8H96Zm96 168H64V64h128Zm-80-104v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm48 0v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Z"/>
                        </svg>
                        <span>Hapus</span>
                    </button>
                </form>

                <button onclick="openEditModal('{{ $product->id }}')" 
                        class="flex cursor-pointer items-center gap-1 bg-blue-600 hover:text-blue-600 text-white border border-blue-600 px-3 py-1 rounded-md hover:bg-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                        <path fill="currentColor" d="M25 4.031c-.766 0-1.516.297-2.094.875L13 14.781l-.219.219l-.062.313l-.688 3.5l-.312 1.468l1.469-.312l3.5-.688l.312-.062l.219-.219l9.875-9.906A2.968 2.968 0 0 0 25 4.03zm0 1.938c.234 0 .465.12.688.343c.445.446.445.93 0 1.375L16 17.376l-1.719.344l.344-1.719l9.688-9.688c.222-.222.453-.343.687-.343zM4 8v20h20V14.812l-2 2V26H6V10h9.188l2-2z"/>
                    </svg>
                    <span>Edit</span>
                </button>
            </div>
        </div>
    </div>
</div>


{{-- Modal edit --}}
<div id="editModal-{{ $product->id }}"
    class="fixed bg-black/70 inset-0 flex items-center justify-center hidden z-50">

    <!-- Kontainer modal -->
    <div class="bg-white w-full max-w-lg max-h-[90vh] rounded-lg shadow-lg relative my-8 flex flex-col">

        <!-- Header -->
        <h2 class="text-xl font-bold text-blue-900 px-6 pt-6">
            Edit {{ isset($product->price) ? 'Tiket' : 'Promo' }}
        </h2>

        <!-- Konten scrollable -->
        <div class="flex-1 overflow-y-auto px-6 pb-6">
            <form id="editForm-{{ $product->id }}"
                method="POST"
                enctype="multipart/form-data"
                action="{{ isset($product->price)
                            ? route('admin.update.tiket', $product->id)
                            : route('admin.update.promo', $product->id) }}">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Nama</label>
                    <input type="text"
                        name="name"
                        id="editNama-{{ $product->id }}"
                        value="{{ old('name', $product->name) }}"
                        class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if (isset($product->price))
                    {{-- Harga --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Harga</label>
                        <input type="number"
                            name="price"
                            id="editPrice-{{ $product->id }}"
                            value="{{ $product->price }}"
                            class="w-full border rounded px-3 py-2 @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Kategori --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Kategori</label>
                        <select name="category"
                            id="editCategory-{{ $product->id }}"
                            class="w-full border rounded px-3 py-2 @error('category') border-red-500 @enderror">
                            <option value="tiket" {{ $product->category === 'tiket' ? 'selected' : '' }}>Tiket</option>
                            <option value="parkir" {{ $product->category === 'parkir' ? 'selected' : '' }}>Parkir</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Aset Terhubung --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Fasilitas (Aset Terkait)</label>
                        <div class="max-h-40 overflow-y-auto border rounded p-2">
                            @forelse($assets as $asset)
                                <label class="flex items-center mb-2">
                                    <input type="checkbox"
                                        name="assets[]"
                                        value="{{ $asset->id }}"
                                        {{ $product->assets->contains($asset->id) ? 'checked' : '' }}
                                        class="mr-2">
                                    <span>{{ $asset->name }}</span>
                                </label>
                            @empty
                                <p class="text-gray-500 text-sm">Tidak ada aset tersedia</p>
                            @endforelse
                        </div>
                    </div>
                @elseif (isset($product->code))
                    {{-- Kode Promo --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Kode Promo</label>
                        <input type="text"
                            name="code"
                            id="editCode-{{ $product->id }}"
                            value="{{ $product->code }}"
                            class="w-full border rounded px-3 py-2 @error('code') border-red-500 @enderror">
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Diskon --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Besar Diskon (%)</label>
                        <input type="number"
                            name="discount_percent"
                            id="editDiscountPercent-{{ $product->id }}"
                            value="{{ $product->discount_percent }}"
                            class="w-full border rounded px-3 py-2 @error('discount_percent') border-red-500 @enderror">
                        @error('discount_percent')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Kuota --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Jumlah Kuota</label>
                        <input type="number"
                            name="qty"
                            id="editQty-{{ $product->id }}"
                            value="{{ $product->qty }}"
                            class="w-full border rounded px-3 py-2 @error('qty') border-red-500 @enderror">
                        @error('qty')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Periode --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Periode Promo</label>
                        <input type="date"
                            name="valid_until"
                            id="editValidUntil-{{ $product->id }}"
                            value="{{ \Carbon\Carbon::parse($product->valid_until)->format('Y-m-d') }}"
                            class="w-full border rounded px-3 py-2 @error('valid_until') border-red-500 @enderror">
                        @error('valid_until')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Deskripsi</label>
                    <textarea name="description"
                        id="editDeskripsi-{{ $product->id }}"
                        rows="6"
                        class="w-full border rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ $product->description }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gambar --}}
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Gambar</label>
                    @if(!empty($product->image))
                        <img id="previewGambar-{{ $product->id }}"
                            src="{{ asset('images/' . $product->image) }}"
                            alt="Preview Gambar"
                            class="w-full h-40 object-contain rounded border mb-2">
                    @else
                        <div id="previewGambar-{{ $product->id }}"
                            class="w-full h-40 flex items-center justify-center border rounded mb-2 text-gray-500 font-semibold">
                            Gambar
                        </div>
                    @endif
                    <input type="file"
                        name="image"
                        accept="image/*"
                        onchange="previewImage(event, '{{ $product->id }}')"
                        class="w-full border rounded p-2 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button"
                            onclick="closeEditModal('{{ $product->id }}')"
                            class="px-4 py-2 rounded border cursor-pointer border-gray-400 text-gray-600 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 rounded cursor-pointer bg-blue-600 text-white hover:bg-blue-900">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal detail --}}
<div id="detailModal-{{ $product->id }}"
    class="fixed bg-black/70 inset-0 flex items-center justify-center overflow-y-auto hidden z-50">
    <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative my-8 max-h-screen overflow-y-auto">
        <h2 class="text-2xl font-bold text-blue-900 mb-4">
            Detail {{ isset($product->price) ? 'Tiket' : 'Promo' }}
        </h2>

        @if(!empty($product->image))
            <img id="detailGambar-{{ $product->id }}"
                src="{{ asset('images/' . $product->image) }}"
                class="w-full h-48 object-contain rounded border mb-4"
                alt="Gambar Produk">
        @else
            <div class="w-full h-48 flex items-center justify-center rounded border mb-4 text-gray-500 font-semibold">
                Gambar
            </div>
        @endif

        <p><strong>Nama:</strong> {{ $product->name }}</p>

        @if (isset($product->price))
            <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p><strong>Kategori:</strong> {{ ucfirst($product->category) }}</p>

            {{-- Aset Terhubung di Detail Modal --}}
            @if($product->assets && $product->assets->count() > 0)
                <p class="mt-3"><strong>Aset Terkait:</strong></p>
                <div class="flex flex-wrap gap-2 mt-1">
                    @foreach($product->assets as $asset)
                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded">
                            {{ $asset->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        @elseif (isset($product->code))
            <p><strong>Kode Promo:</strong> {{ $product->code }}</p>
            <p><strong>Besar Diskon:</strong> {{ $product->discount_percent }}%</p>
            <p><strong>Jumlah Kuota:</strong> {{ $product->qty }}</p>
            <p><strong>Periode Promo:</strong> {{ \Carbon\Carbon::parse($product->valid_until)->format('d M Y') }}</p>
        @endif

        <p class="mt-3"><strong>Deskripsi:</strong></p>
        <div class="detailDeskripsi border rounded p-3 bg-gray-50">
            {{ $product->description }}
        </div>

        <button onclick="closeDetailModal('{{ $product->id }}')"
                class="absolute top-3 right-4 text-gray-500 hover:text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1216 1312">
                <path fill="currentColor" d="M1202 1066q0 40-28 68l-136 136q-28 28-68 28t-68-28L608 976l-294 294q-28 28-68 28t-68-28L42 1134q-28-28-28-68t28-68l294-294L42 410q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 294l294-294q28-28 68-28t68 28l136 136q28 28 28 68t-28 68L880 704l294 294q28 28 28 68z"/>
            </svg>
        </button>
    </div>
</div>

@push('scripts')
<script>
    function openEditModal(id) {
        document.getElementById(`editModal-${id}`).classList.remove('hidden');
        loadTicketData(id); // Load data when modal opens
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

    function loadTicketData(id) {
        fetch(`/admin/tiket/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById(`editNama-${id}`).value = data.ticket.name;
                document.getElementById(`editPrice-${id}`).value = data.ticket.price;
                document.getElementById(`editCategory-${id}`).value = data.ticket.category;
                document.getElementById(`editDeskripsi-${id}`).value = data.ticket.description;

                // Populate assets checkboxes
                const assetsContainer = document.getElementById(`assetsContainer-${id}`);
                const selectedAssets = data.ticket.assets ? data.ticket.assets.map(asset => asset.id) : [];

                if (data.assets && data.assets.length > 0) {
                    let assetsHtml = '';
                    data.assets.forEach(asset => {
                        const isChecked = selectedAssets.includes(asset.id) ? 'checked' : '';
                        assetsHtml += `
                            <label class="flex items-center mb-2">
                                <input type="checkbox"
                                       name="assets[]"
                                       value="${asset.id}"
                                       ${isChecked}
                                       class="mr-2">
                                <span>${asset.name}</span>
                            </label>
                        `;
                    });
                    assetsContainer.innerHTML = assetsHtml;
                } else {
                    assetsContainer.innerHTML = '<p class="text-gray-500 text-sm">Tidak ada aset tersedia</p>';
                }
            })
            .catch(error => {
                console.error('Error loading ticket data:', error);
                document.getElementById(`assetsContainer-${id}`).innerHTML = '<p class="text-red-500 text-sm">Gagal memuat data aset</p>';
            });
    }
</script>
@endpush