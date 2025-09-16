<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">Scan QR Code</h1>

    <!-- Tempat kamera -->
    <div id="qr-reader" style="width: 400px; height: 400px;"></div>

    <!-- Hasil -->
    <div id="qr-result" class="mt-5 p-3 bg-gray-100 rounded hidden"></div>
</div>

<!-- Library HTML5 QR Code -->
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const qrResult = document.getElementById("qr-result");

    function onScanSuccess(decodedText, decodedResult) {
        console.log("Decoded:", decodedText);

        fetch("{{ route('customer.decode.scan') }}",
        { method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ qr_data: decodedText })
        })
        .then(res => res.json())
        .then(data => {
            qrResult.classList.remove('hidden');

            if (data.status === "success") {
                qrResult.innerHTML = `
                    <b>Nama:</b> ${data.data.name}<br>
                    <b>Email:</b> ${data.data.email}<br>
                    <b>WA:</b> ${data.data.wa_number}
                `;
            } else {
                qrResult.innerHTML = "<span class='text-red-500'>" + data.message + "</span>";
            }
        })
        .catch(err => {
            qrResult.classList.remove('hidden');
            qrResult.innerHTML = "<span class='text-red-500'>Error: " + err + "</span>";
        });
    }

    function onScanError(errorMessage) {
        // bisa diabaikan, scanner otomatis retry
        // console.log("Scan error:", errorMessage);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 }
    );
    html5QrcodeScanner.render(onScanSuccess, onScanError);
</script>
