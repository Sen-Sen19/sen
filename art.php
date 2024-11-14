<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Random Art Generator</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    canvas {
      border: 1px solid black;
      margin-top: 20px;
      background-color: #ffffff;
    }
    .controls {
      margin-bottom: 20px;
      text-align: center;
    }
    input[type="color"] {
      margin: 10px;
    }
    input[type="range"] {
      width: 200px;
    }
    button {
      background-color: #20c997;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background-color: #17a085;
    }
    .shape-checkboxes {
      display: flex;
      justify-content: center;
      margin: 10px 0;
    }
    .shape-checkboxes label {
      margin-right: 20px;
    }
  </style>
</head>
<body>

  <div class="controls">
    <label for="colorPicker">Choose Color 1: </label>
    <input type="color" id="colorPicker1" value="#ff0000">
    <label for="colorPicker">Choose Color 2: </label>
    <input type="color" id="colorPicker2" value="#00ff00">
    <label for="colorPicker">Choose Color 3: </label>
    <input type="color" id="colorPicker3" value="#0000ff">
    <label for="colorPicker">Choose Color 4: </label>
    <input type="color" id="colorPicker4" value="#ff00ff">
    <label for="colorPicker">Choose Color 5: </label>
    <input type="color" id="colorPicker5" value="#ffff00">
    <br>
    <label for="numShapes">Number of Shapes: </label>
    <input type="range" id="numShapes" min="5" max="100" value="30">
    <span id="numShapesValue">30</span>
    <br>
    <label for="sizeRange">Shape Size: </label>
    <input type="range" id="sizeRange" min="10" max="100" value="50">
    <span id="sizeValue">50</span>
    <br>
    <div class="shape-checkboxes">
      <label><input type="checkbox" id="circleCheckbox" checked> Circle</label>
      <label><input type="checkbox" id="squareCheckbox" checked> Square</label>
      <label><input type="checkbox" id="triangleCheckbox" checked> Triangle</label>
      <label><input type="checkbox" id="starCheckbox" checked> Star</label>
    </div>
    <button onclick="generateArt()">Generate Art</button>
  </div>

  <canvas id="artCanvas" width="500" height="500"></canvas>

  <script>
    // Get the DOM elements
    const canvas = document.getElementById("artCanvas");
    const ctx = canvas.getContext("2d");

    const colorPicker1 = document.getElementById("colorPicker1");
    const colorPicker2 = document.getElementById("colorPicker2");
    const colorPicker3 = document.getElementById("colorPicker3");
    const colorPicker4 = document.getElementById("colorPicker4");
    const colorPicker5 = document.getElementById("colorPicker5");
    const numShapesInput = document.getElementById("numShapes");
    const sizeRangeInput = document.getElementById("sizeRange");
    const numShapesValue = document.getElementById("numShapesValue");
    const sizeValue = document.getElementById("sizeValue");

    // Shape checkboxes
    const circleCheckbox = document.getElementById("circleCheckbox");
    const squareCheckbox = document.getElementById("squareCheckbox");
    const triangleCheckbox = document.getElementById("triangleCheckbox");
    const starCheckbox = document.getElementById("starCheckbox");

    // Update the labels when the slider value changes
    numShapesInput.addEventListener("input", () => {
      numShapesValue.textContent = numShapesInput.value;
    });

    sizeRangeInput.addEventListener("input", () => {
      sizeValue.textContent = sizeRangeInput.value;
    });

    // Function to generate random art
    function generateArt() {
      const numShapes = parseInt(numShapesInput.value);
      const shapeSize = parseInt(sizeRangeInput.value);

      // Collect colors from the color pickers
      const colors = [
        colorPicker1.value,
        colorPicker2.value,
        colorPicker3.value,
        colorPicker4.value,
        colorPicker5.value
      ];

      // Clear the canvas before drawing new shapes
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      // Draw random shapes
      for (let i = 0; i < numShapes; i++) {
        const randomX = Math.random() * canvas.width;
        const randomY = Math.random() * canvas.height;
        const randomSize = Math.random() * shapeSize;

        // Random shape selection based on checkboxes
        const shapeTypes = [];
        if (circleCheckbox.checked) shapeTypes.push(0);
        if (squareCheckbox.checked) shapeTypes.push(1);
        if (triangleCheckbox.checked) shapeTypes.push(2);
        if (starCheckbox.checked) shapeTypes.push(3);

        const randomShape = shapeTypes[Math.floor(Math.random() * shapeTypes.length)];

        // Select a random color from the colors array
        const randomColor = colors[Math.floor(Math.random() * colors.length)];

        ctx.fillStyle = randomColor;
        ctx.beginPath();

        switch (randomShape) {
          case 0:
            // Circle
            ctx.arc(randomX, randomY, randomSize, 0, Math.PI * 2);
            break;
          case 1:
            // Square
            ctx.fillRect(randomX, randomY, randomSize, randomSize);
            break;
          case 2:
            // Triangle
            ctx.moveTo(randomX, randomY);
            ctx.lineTo(randomX + randomSize, randomY);
            ctx.lineTo(randomX + randomSize / 2, randomY - randomSize);
            ctx.closePath();
            break;
          case 3:
            // Star
            ctx.moveTo(randomX, randomY - randomSize);
            for (let j = 0; j < 5; j++) {
              const angle = Math.PI * 2 * j / 5;
              const x = randomX + randomSize * Math.cos(angle);
              const y = randomY - randomSize * Math.sin(angle);
              ctx.lineTo(x, y);
            }
            ctx.closePath();
            break;
        }

        ctx.fill();
      }
    }
  </script>
</body>
</html>
