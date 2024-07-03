<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Barcode Scanner Example</title>
<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f0f0f0;
  }

  video {
    width: 100%;
    max-width: 400px;
    border: 2px solid #ccc;
  }
</style>
</head>
<body>
  <video id="videoElement" autoplay></video>

  <script src="https://unpkg.com/quagga/dist/quagga.min.js"></script>
  <script>
    // Check for browser support
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      // Access the camera
      navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
          const videoElement = document.getElementById('videoElement');
          videoElement.srcObject = stream;

          // Configure QuaggaJS
          Quagga.init({
            inputStream: {
              name: "Live",
              type: "LiveStream",
              target: videoElement
            },
            decoder: {
              readers: ["ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader", "i2of5_reader", "2of5_reader", "code_128_reader", "code_93_reader"]
            }
          }, function(err) {
            if (err) {
              console.error('Error initializing Quagga:', err);
              alert('Error initializing Quagga: ' + err.message);
              return;
            }
            console.log('Initialization finished. Ready to start');
            Quagga.start();
          });

          // Register callback for barcode detection
          Quagga.onDetected(function(result) {
            console.log('Barcode detected and processed:', result);
            alert('Barcode detected and processed: ' + result.codeResult.code);
            Quagga.stop();
          });
        })
        .catch(function(error) {
          console.error('Error accessing camera:', error);
          alert('Error accessing camera: ' + error.message);
        });
    } else {
      console.error('getUserMedia is not supported');
      alert('getUserMedia is not supported on this browser');
    }
  </script>
</body>
</html>
