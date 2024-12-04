<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR & Barcode Generator</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #222;
      color: #eee;
      text-align: center;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 500px;
      margin: 50px auto;
      padding: 20px;
      background-color: #333;
      border-radius: 10px;
    }
    input[type="text"], button {
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: none;
      outline: none;
    }
    input[type="text"] {
      width: 90%;
    }
    button {
      background-color: #20c997;
      color: #fff;
      cursor: pointer;
    }
    button:hover {
      background-color: #17a389;
    }
    .canvas-container {
      margin: 20px 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>QR & Barcode Generator</h1>
    <input type="text" id="textInput" placeholder="Enter your text">
    <div>
      <label><input type="radio" name="codeType" value="qr" checked> QR Code</label>
      <label><input type="radio" name="codeType" value="barcode"> Barcode</label>
    </div>
    <button id="generateBtn">Generate</button>
    <div class="canvas-container">
      <canvas id="codeCanvas"></canvas>
    </div>
    <button id="downloadBtn" style="display: none;">Download</button>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
  <script>
    const textInput = document.getElementById('textInput');
    const codeCanvas = document.getElementById('codeCanvas');
    const generateBtn = document.getElementById('generateBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    generateBtn.addEventListener('click', () => {
      const text = textInput.value.trim();
      const codeType = document.querySelector('input[name="codeType"]:checked').value;

      if (!text) {
        alert('Please enter text to generate the code.');
        return;
      }

      const ctx = codeCanvas.getContext('2d');
      ctx.clearRect(0, 0, codeCanvas.width, codeCanvas.height);

      if (codeType === 'qr') {
        QRCode.toCanvas(codeCanvas, text, { width: 300 }, (error) => {
          if (error) console.error(error);
          downloadBtn.style.display = 'block';
        });
      } else if (codeType === 'barcode') {
        JsBarcode(codeCanvas, text, {
          format: 'CODE128',
          lineColor: '#000',
          width: 2,
          height: 100,
          displayValue: true
        });
        downloadBtn.style.display = 'block';
      }
    });

    downloadBtn.addEventListener('click', () => {
      const link = document.createElement('a');
      link.download = 'code.png';
      link.href = codeCanvas.toDataURL();
      link.click();
    });
  </script>
</body>
</html>
