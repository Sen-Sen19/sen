<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Camera</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        video {
            width: 100%;
            max-width: 600px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <video id="video" autoplay></video>
    <script>
        const video = document.getElementById('video');

        // Access the device camera and stream to video element
        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
            } catch (error) {
                console.error("Error accessing the camera: ", error);
            }
        }

        // Start the camera when the page loads
        window.onload = startCamera;
    </script>
</body>
</html>
