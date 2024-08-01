<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinball Game</title>
   <style>
    body {
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #000;
}

#gameContainer {
    position: relative;
    width: 80%;
    height: 80%;
    background-color: #222;
    border: 5px solid #fff;
    overflow: hidden;
}

canvas {
    display: block;
    width: 100%;
    height: 100%;
}

   </style>
</head>
<body>
    <div id="gameContainer">
        <canvas id="gameCanvas"></canvas>
    </div>
   <script>
    const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');

canvas.width = canvas.offsetWidth;
canvas.height = canvas.offsetHeight;

let flipperLeftActive = false;
let flipperRightActive = false;

document.addEventListener('keydown', (e) => {
    if (e.key === 'a') {
        flipperLeftActive = true;
    } else if (e.key === 's') {
        flipperRightActive = true;
    }
});

document.addEventListener('keyup', (e) => {
    if (e.key === 'a') {
        flipperLeftActive = false;
    } else if (e.key === 's') {
        flipperRightActive = false;
    }
});

function drawFlippers() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = 'white';


    if (flipperLeftActive) {
        ctx.fillRect(50, canvas.height - 60, 100, 20);
    } else {
        ctx.fillRect(50, canvas.height - 40, 100, 20);
    }


    if (flipperRightActive) {
        ctx.fillRect(canvas.width - 150, canvas.height - 60, 100, 20);
    } else {
        ctx.fillRect(canvas.width - 150, canvas.height - 40, 100, 20);
    }

    requestAnimationFrame(drawFlippers);
}

drawFlippers();

   </script>
</body>
</html>
