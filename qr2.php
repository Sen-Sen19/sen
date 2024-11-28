<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto QR Code Scanner</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            flex-direction: column;
            margin: 0;
        }
        #scanner-container {
            position: relative;
            width: 300px;
            height: 300px;
            border: 2px solid #20c997;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        canvas {
            display: none;
        }
        select {
            margin: 10px 0;
            padding: 5px;
            font-size: 16px;
        }
        .scanner-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: red;
            top: 0;
            animation: scan 2s linear infinite;
        }
        @keyframes scan {
            from {
                top: 0;
            }
            to {
                top: 100%;
            }
        }
    </style>
</head>
<body>
    <select id="cameraSelect"></select>
    <div id="scanner-container">
        <video id="video" autoplay></video>
        <div class="scanner-line"></div>
    </div>
    <canvas id="canvas"></canvas>

    <script src="libs/jsQR.min.js"></script>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const cameraSelect = document.getElementById('cameraSelect');

        let currentStream = null;
        let scanning = false;

        async function startCamera(deviceId = null) {
            try {
                if (currentStream) {
                    currentStream.getTracks().forEach(track => track.stop());
                }

                const constraints = deviceId
                    ? { video: { deviceId: { exact: deviceId } } }
                    : { video: true };

                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
                currentStream = stream;

                requestAnimationFrame(scanQRCode);
            } catch (error) {
                console.error("Error accessing the camera: ", error);
            }
        }

        async function getCameras() {
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                const videoDevices = devices.filter(device => device.kind === 'videoinput');

                cameraSelect.innerHTML = "";
                videoDevices.forEach((device, index) => {
                    const option = document.createElement('option');
                    option.value = device.deviceId;
                    option.textContent = device.label || Camera ${index + 1};
                    cameraSelect.appendChild(option);
                });

                if (videoDevices.length > 0) {
                    startCamera(videoDevices[0].deviceId);
                }
            } catch (error) {
                console.error("Error listing cameras: ", error);
            }
        }

        cameraSelect.addEventListener('change', () => {
            startCamera(cameraSelect.value);
        });

        function scanQRCode() {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const qrCode = jsQR(imageData.data, canvas.width, canvas.height);

                if (qrCode && !scanning) {
                    scanning = true;
                    alert('QR Code detected: ' + qrCode.data);
                    saveQRCode(qrCode.data);
                }
            }
            requestAnimationFrame(scanQRCode);
        }


        function saveQRCode(data) {
            fetch('save_qr.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ scanned: data })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('QR Code saved to the database!');
                } else {
                    alert('Failed to save QR Code: ' + result.error);
                }
                scanning = false;
            })
            .catch(error => {
                console.error('Error:', error);
                scanning = false;
            });
        }

        window.onload = getCameras;
    </script>
</body>
</html>


