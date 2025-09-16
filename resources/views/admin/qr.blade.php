<div class="container">
    <h1>QR Code untuk {{ $customer->name }}</h1>

    {{-- Generate QR --}}
    <div>
        {!! QrCode::size(200)->generate($qrString) !!}
    </div>

    <p>Scan QR ini untuk melihat data customer terenkripsi.</p>
</div>
