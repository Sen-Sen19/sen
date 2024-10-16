<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        #scanner-container {
            text-align: center;
        }

        #qr-reader {
            width: 100%;
            max-width: 600px;
            height: auto;
            display: none; /* Hide the QR reader initially */
        }

        #qr-result {
            margin-top: 20px;
            font-size: 1.2em;
        }

        #start-scanner {
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        #start-scanner:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="scanner-container">
        <button id="start-scanner">Start QR Scanner</button>
        <div id="qr-reader"></div>
        <div id="qr-result">Scanning...</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('qr-result').textContent = `Scanned QR Code: ${decodedText}`;
        }

        function onScanError(errorMessage) {
            console.error(`QR Code scan error: ${errorMessage}`);
        }

        function handleStartScanner() {
            if (typeof Html5Qrcode === 'undefined') {
                console.error('Html5Qrcode library not loaded');
                return;
            }

            const html5QrCode = new Html5Qrcode("qr-reader");

            const qrCodeConfig = { fps: 10, qrbox: { width: 250, height: 250 } };

            html5QrCode.start(
                { facingMode: "environment" },
                qrCodeConfig,
                onScanSuccess,
                onScanError
            ).catch(err => {
                console.error(`Unable to start QR code scanner: ${err}`);
                alert('Unable to start QR code scanner. Please check your camera permissions and ensure your browser supports WebRTC.');
            });
        }

        document.getElementById('start-scanner').addEventListener('click', () => {
            document.getElementById('qr-reader').style.display = 'block';
            handleStartScanner();
        });
    </script>
</body>
</html>
