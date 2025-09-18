<table>
    <thead>
        <tr>
            <th>ID Penjualan</th>
            <th>Tanggal</th>
            <th>Nama Tiket</th>
            <th>Nama Pelanggan</th>
            <th>Email</th>
            <th>Nomor Telepon</th>
            <th>Harga Tiket</th>
            <th>Subtotal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Metode Pembayaran</th>
            <th>Bukti Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($laporan as $row)
            <tr>
                <td>{{ $row['id'] }}</td>
                <td>{{ $row['tanggal'] }}</td>
                <td>{{ $row['nama_tiket'] }}</td>
                <td>{{ $row['nama_pelanggan'] }}</td>
                <td>{{ $row['email'] }}</td>
                <td>{{ $row['nomor_telepon'] }}</td>
                <td>{{ $row['harga_tiket'] }}</td>
                <td>{{ $row['subtotal'] }}</td>
                <td>{{ $row['total'] }}</td>
                <td>{{ $row['status'] }}</td>
                <td>{{ $row['metode_pembayaran'] }}</td>
                <td>{{ $row['bukti_pembayaran'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('export.laporan') }}" class="btn btn-success">
    Export Laporan Penjualan
</a>
