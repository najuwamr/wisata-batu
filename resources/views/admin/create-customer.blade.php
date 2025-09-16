<form method="POST" action="{{ route('customer.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Nama" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="wa_number" placeholder="No WA" required>
    <button type="submit">Generate QR</button>
</form>
