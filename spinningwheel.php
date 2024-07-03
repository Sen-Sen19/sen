<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spinning Wheel</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f0f0f0 50%, #d0d0d0 50%);
        }

        .container {
            display: flex;
            gap: 30px;
            align-items: flex-start; /* Align items at the top */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background: #fff;
            border-radius: 15px;
        }

        .wheel-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        canvas {
            border: 10px solid #333;
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .arrow {
            position: absolute;
            top: 50%;
            right: -40px; /* Adjusted to align with the canvas */
            transform: translateY(-50%);
            width: 80px; /* Increased size for better visibility */
            height: 20px;
            background-color: #ff0000; /* Arrow color */
            z-index: 1;
        }

        .controls {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        #add-item {
            padding: 10px 20px;
            background-color: #20c997;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #add-item:hover {
            background-color: #1ea87a;
        }

        .input-container {
            display: flex;
            gap: 10px;
            align-items: center;
            width: 100px; /* Adjust width as needed */
            flex-wrap: wrap; /* Allow wrapping to the next line */
        }

        .input-container input {
            padding: 8px;
            width: calc(100% - 40px); /* Full width with padding for input and button */
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s;
            margin-bottom: 10px; /* Add margin bottom to separate inputs */
        }

        .input-container input:focus {
            border-color: #20c997;
            outline: none;
        }

        .input-container button {
            padding: 8px 15px;
            background-color: #20c997;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .input-container button:hover {
            background-color: #1ea87a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="wheel-container">
            <canvas id="wheel" width="500" height="500"></canvas>
            <div class="arrow"></div> <!-- Rectangle for the arrow -->
        </div>
        <div class="controls">
            <div class="input-container" id="inputs">
                <button id="add-item">Add Item</button>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const addItemButton = document.getElementById('add-item');
    const inputsContainer = document.getElementById('inputs');
    const canvas = document.getElementById('wheel');
    const ctx = canvas.getContext('2d');
    let items = [];
    let rotation = 0;
    let spinning = false;
    let colors = [];

    // Add input field for new items
    addItemButton.addEventListener('click', () => {
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = 'Enter item';
        input.classList.add('item-input'); // Add a class for styling
        inputsContainer.appendChild(input);
    });

    // Spin the wheel when clicked
    canvas.addEventListener('click', () => {
        if (spinning) return;
        items = Array.from(inputsContainer.querySelectorAll('.item-input')).map(input => input.value);
        if (items.length > 0) {
            if (colors.length !== items.length) colors = generateColors(items.length);
            drawWheel();
            spin();
        }
    });

    // Draw the wheel with items
    function drawWheel() {
        const numSegments = items.length;
        const angleStep = (2 * Math.PI) / numSegments;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        items.forEach((item, index) => {
            const startAngle = index * angleStep;
            const endAngle = (index + 1) * angleStep;
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.width / 2, startAngle, endAngle);
            ctx.closePath();
            ctx.fillStyle = colors[index];
            ctx.fill();

            // Add text
            ctx.save();
            ctx.translate(canvas.width / 2, canvas.height / 2);
            ctx.rotate((startAngle + endAngle) / 2);
            ctx.textAlign = 'right';
            ctx.fillStyle = '#000';
            ctx.font = 'bold 14px Arial';
            ctx.fillText(item, (canvas.width / 2) * 0.8, 0);
            ctx.restore();
        });
    }

   // Spin the wheel
function spin() {
    spinning = true;
    const duration = 5000; // duration of spin in milliseconds
    const endRotation = Math.random() * 2 * Math.PI + 10 * 2 * Math.PI; // random end rotation
    let start = null;
    let tensionFactor = 1; // Adjust the tension factor as needed

    function animate(timestamp) {
        if (!start) start = timestamp;
        const elapsed = timestamp - start;
        const progress = Math.min(elapsed / duration, 1);
        rotation = tensionFactor * progress * endRotation; // Introduce tension effect

        ctx.save();
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.translate(canvas.width / 2, canvas.height / 2);
        ctx.rotate(rotation);
        ctx.translate(-canvas.width / 2, -canvas.height / 2);
        drawWheel();
        ctx.restore();

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            spinning = false;
            determineWinner();
        }
    }

    requestAnimationFrame(animate);
}

    // Determine the winning item
    function determineWinner() {
        const numSegments = items.length;
        const anglePerSegment = (2 * Math.PI) / numSegments;
        const arrowWidth = 60; // Width of the rectangle arrow
        const arrowPosition = canvas.width / 2; // X-coordinate of the arrow (right side of the canvas)

        // Calculate the position of the arrow relative to the canvas center
        const adjustedRotation = rotation % (2 * Math.PI);
        let arrowPositionOnCircle = (2 * Math.PI - adjustedRotation) % (2 * Math.PI);
        if (arrowPositionOnCircle < 0) {
            arrowPositionOnCircle += 2 * Math.PI;
        }

        // Find the winning segment based on arrow position
        let winningIndex = Math.floor(arrowPositionOnCircle / anglePerSegment);
        winningIndex %= numSegments;
        if (winningIndex < 0) winningIndex += numSegments; // Ensure positive index

        alert(`The winner is: ${items[winningIndex]}`);
    }

    // Generate random colors for each segment
    function generateColors(numColors) {
        const baseColors = [
            '#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#A1FF33', '#FFDB33',
            '#33FFDB', '#DB33FF', '#FFD633', '#FF3333', '#33FFD6', '#3333FF'
        ];
        const colors = [];
        for (let i = 0; i < numColors; i++) {
            colors.push(baseColors[i % baseColors.length]);
        }
        return colors;
    }
});
</script>

</body>
</html>
