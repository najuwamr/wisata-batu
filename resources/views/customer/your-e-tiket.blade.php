<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket Selecta</title>
    <style>
        /* Reset dan styling dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            line-height: 1.4;
            color: #333;
            background-color: #f5f5f5;
            padding: 10px;
        }

        /* Container utama */
        .ticket {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 2px dashed #93c5fd;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        /* Info booking */
        .booking-info {
            background: #f8fafc;
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .booking-code {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
        }

        .status {
            background: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        /* Konten utama */
        .content {
            padding: 20px;
        }

        /* Section informasi */
        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Grid info pengguna */
        .user-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
        }

        /* QR Section */
        .qr-section {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .qr-placeholder {
            width: 150px;
            height: 150px;
            background: #e2e8f0;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed #94a3b8;
            color: #64748b;
            font-size: 12px;
            text-align: center;
        }

        /* Tabel tiket */
        .ticket-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .ticket-table th {
            background: #f1f5f9;
            padding: 10px;
            text-align: left;
            font-size: 13px;
            font-weight: bold;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
        }

        .ticket-table td {
            padding: 10px;
            font-size: 13px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Footer */
        .footer {
            background: #1e293b;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 12px;
        }

        .contact-info {
            margin-bottom: 10px;
        }

        .contact-info span {
            margin: 0 10px;
            font-weight: bold;
        }

        .instructions {
            font-size: 11px;
            opacity: 0.8;
            margin-top: 10px;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .ticket {
                box-shadow: none;
                border: 1px solid #ccc;
                margin: 0;
                max-width: 100%;
            }

            .header {
                background: #1e40af !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* Responsif */
        @media (max-width: 600px) {
            .user-grid {
                grid-template-columns: 1fr;
            }

            .booking-info {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Header -->
        <div class="header">
            <h1>E-TIKET SELECTA</h1>
            <p>Taman Rekreasi & Wisata</p>
        </div>

        <!-- Info Booking -->
        <div class="booking-info">
            <div>
                <div style="font-size: 12px; color: #64748b;">Kode Booking</div>
                <div class="booking-code">{{ $transaction->code }}</div>
            </div>
            <div class="status">
                {{ $transaction->status === 'paid' ? 'LUNAS' : 'MENUNGGU PEMBAYARAN' }}
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="content">
            <!-- Informasi Pengunjung -->
            <div class="section">
                <div class="section-title">Informasi Pengunjung</div>
                <div class="user-grid">
                    <div class="info-item">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ $transaction->customer->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $transaction->customer->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">No. Telepon</div>
                        <div class="info-value">{{ $transaction->customer->telephone ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal Kunjungan</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($transaction->tanggal_kedatangan)->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- QR Code -->
            <div class="section">
                <div class="section-title">Kode QR Tiket</div>
                <div class="qr-section">
                    @if($transaction->status === 'paid')
                        <div style="margin-bottom: 10px;">
                            {!! QrCode::size(200)->generate($qrCode) !!}
                        </div>
                        <div style="font-size: 12px; color: #64748b;">
                            Pindai QR code ini saat masuk ke lokasi
                        </div>
                    @else
                        <div class="qr-placeholder">
                            QR Code akan tersedia<br>setelah pembayaran
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detail Tiket -->
            <div class="section">
                <div class="section-title">Detail Tiket</div>
                <table class="ticket-table">
                    <thead>
                        <tr>
                            <th>Jenis Tiket</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->transactionDetail as $detail)
                        <tr>
                            <td>{{ $detail->ticket->name ?? 'Tiket Masuk' }}</td>
                            <td>{{ $detail->quantity }} tiket</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Instruksi -->
            <div style="background: #fffbeb; border: 1px solid #fed7aa; border-radius: 6px; padding: 12px; margin-top: 20px;">
                <div style="display: flex; align-items: flex-start;">
                    <div style="font-size: 14px; font-weight: bold; color: #92400e; margin-right: 8px;">📌</div>
                    <div style="font-size: 12px; color: #92400e;">
                        <strong>Instruksi:</strong> E-Tiket akan berlaku sampai 7 hari dari tanggal kedatangan yang dipilih. Tunjukkan e-tiket ini (cetak atau tampilan digital) di lokasi.
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="contact-info">
                Butuh bantuan? Hubungi
                <span>0341-591025</span>
                atau
                <span>marketing@selecta.com</span>
            </div>
            <div class="instructions">
                E-tiket ini sah dan dapat digunakan untuk masuk ke Taman Rekreasi Selecta
            </div>
        </div>
    </div>
</body>
</html>
