@extends('layouts.guest')

@section('title', 'Keranjang')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-blue-900">Keranjang Tiket</h1>

    @if(empty($cart))
        <p class="text-gray-500">Keranjang masih kosong.</p>
    @else
        <table class="w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Tiket</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item['name'] }}</td> {{-- ✅ sekarang pakai nama --}}
                        <td class="p-2">
                            <form action="{{ route('keranjang.update', $item['ticket_id']) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('POST') {{-- tambahin ini --}}
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="w-16 border rounded text-center">
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                    Update
                                </button>
                            </form>
                        </td>
                        <td class="p-2">
                            <button onclick="hapusItem('{{ $item['ticket_id'] }}')"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                Hapus
                            </button>

                            <form id="hapus-form-{{ $item['ticket_id'] }}"
                                action="{{ route('keranjang.hapus', $item['ticket_id']) }}"
                                method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between mt-6">
            <form action="{{ route('keranjang.clear') }}" method="POST" id="clear-form">
                @csrf
                @method('DELETE')
                <button type="button" onclick="kosongkanKeranjang()"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Kosongkan Keranjang
                </button>
            </form>

            <a href="{{ route('checkout') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Lanjut Pembayaran
            </a>
        </div>
    @endif
</div>

{{-- SweetAlert Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfirmasi hapus item
    function hapusItem(id) {
        Swal.fire({
            title: 'Hapus tiket ini?',
            text: "Data akan hilang dari keranjang.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('hapus-form-' + id).submit();
            }
        });
    }

    // Konfirmasi kosongkan keranjang
    function kosongkanKeranjang() {
        Swal.fire({
            title: 'Kosongkan keranjang?',
            text: "Semua tiket akan dihapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, kosongkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('clear-form').submit();
            }
        });
    }
</script>
@endsection
