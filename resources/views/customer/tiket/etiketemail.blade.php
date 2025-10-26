<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket Anda</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f8f8; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
        h1 { color: #333; }
        p { color: #555; line-height: 1.5; }
        .code { font-weight: bold; background: #eee; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Halo {{ $transaction->customer->name }},</h1>

        <p>Terima kasih atas pesanan Anda!</p>

        <p><strong>Kode Pemesanan:</strong> <span class="code">{{ $transaction->code }}</span></p>

        @if($transaction->status === 'paid')
            <p>E-ticket Anda telah terlampir pada email ini dalam format PDF.</p>
        @else
            <p>Pembayaran Anda belum dikonfirmasi. E-ticket akan dikirim setelah status berubah menjadi <strong>Paid</strong>.</p>
        @endif

        <p>Terima kasih, <br>Marketing Selecta</p>
    </div>
</body>
</html>
