<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinball Game</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #222;
        }
        #gameCanvas {
            background-color: #000;
            border: 2px solid white;
        }
        .paddle {
            width: 100px;
            height: 20px;
            background-color: #fff;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }
        .ball {
            width: 15px;
            height: 15px;
            background-color: red;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <canvas id="gameCanvas" width="600" height="400"></canvas>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');

        const paddleWidth = 100;
        const paddleHeight = 20;
        const ballRadius = 7;

        let ballX = canvas.width / 2;
        let ballY = canvas.height / 2;
        let ballSpeedX = 4;
        let ballSpeedY = -4;

        let paddleX = (canvas.width - paddleWidth) / 2;
        let paddleSpeed = 0;

        document.addEventListener('keydown', (e) => {
            if (e.key === 'a' || e.key === 'A') {
                paddleSpeed = -5;
            } else if (e.key === 'd' || e.key === 'D') {
                paddleSpeed = 5;
            }
        });

        document.addEventListener('keyup', (e) => {
            if (e.key === 'a' || e.key === 'A' || e.key === 'd' || e.key === 'D') {
                paddleSpeed = 0;
            }
        });

        function drawBall() {
            ctx.beginPath();
            ctx.arc(ballX, ballY, ballRadius, 0, Math.PI * 2);
            ctx.fillStyle = 'red';
            ctx.fill();
            ctx.closePath();
        }

        function drawPaddle() {
            ctx.beginPath();
            ctx.rect(paddleX, canvas.height - paddleHeight - 10, paddleWidth, paddleHeight);
            ctx.fillStyle = 'white';
            ctx.fill();
            ctx.closePath();
        }

        function updateBall() {
            ballX += ballSpeedX;
            ballY += ballSpeedY;

            if (ballX + ballRadius > canvas.width || ballX - ballRadius < 0) {
                ballSpeedX = -ballSpeedX;
            }
            if (ballY - ballRadius < 0) {
                ballSpeedY = -ballSpeedY;
            }

            if (ballY + ballRadius > canvas.height - paddleHeight - 10 &&
                ballX > paddleX && ballX < paddleX + paddleWidth) {
                ballSpeedY = -ballSpeedY;
            }

            if (ballY + ballRadius > canvas.height) {
                ballX = canvas.width / 2;
                ballY = canvas.height / 2;
                ballSpeedX = 4;
                ballSpeedY = -4;
            }
        }

        function updatePaddle() {
            paddleX += paddleSpeed;
            if (paddleX < 0) {
                paddleX = 0;
            }
            if (paddleX + paddleWidth > canvas.width) {
                paddleX = canvas.width - paddleWidth;
            }
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            drawBall();
            drawPaddle();
            updateBall();
            updatePaddle();

            requestAnimationFrame(draw);
        }

        draw();
    </script>
</body>
</html>
