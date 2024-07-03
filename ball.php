<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bouncing Pinball with Constant Powerful Bounce</title>
<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        background-color: #000;
        color: #fff;
        font-family: Arial, sans-serif;
    }

    .container {
        position: relative;
        width: 100%;
        height: 100%;
        background-color: #000;
    }

    #ball {
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #f39c12;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(243, 156, 18, 0.8);
    }

    .trail {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: rgba(243, 156, 18, 0.5);
        border-radius: 50%;
        pointer-events: none;
        animation: trailAnimation 1s ease-out forwards;
    }

    @keyframes trailAnimation {
        0% { transform: scale(1); opacity: 0.5; }
        100% { transform: scale(2); opacity: 0; }
    }
</style>
</head>
<body>
<div class="container">
    <div id="ball"></div>
</div>

<script>
    const container = document.querySelector('.container');
    const ball = document.getElementById('ball');
    const ballSize = 20; // Diameter of the ball in pixels
    let vx = 2; // Initial velocity in x-direction
    let vy = 3; // Initial velocity in y-direction
    const gravity = 0.1; // Simulated gravity
    const friction = 0.99; // Friction to simulate energy loss
    const bounceForce = 10; // Constant powerful bounce force

    function createTrail(x, y) {
        const trail = document.createElement('div');
        trail.classList.add('trail');
        trail.style.left = `${x}px`;
        trail.style.top = `${y}px`;
        container.appendChild(trail);
        setTimeout(() => {
            trail.remove();
        }, 1000);
    }

    function moveBall() {
        let rect = container.getBoundingClientRect();
        let ballRect = ball.getBoundingClientRect();

        // Update position based on velocity and constant bounce force
        let nextX = ballRect.left + vx * bounceForce;
        let nextY = ballRect.top + vy * bounceForce;

        // Check boundaries
        if (nextX < rect.left || nextX + ballSize > rect.right) {
            vx = -vx * friction; // Reverse velocity with friction
        }
        if (nextY < rect.top || nextY + ballSize > rect.bottom) {
            vy = -vy * friction; // Reverse velocity with friction
        }

        // Apply gravity
        vy += gravity;

        // Update ball position
        ball.style.left = `${ballRect.left + vx}px`;
        ball.style.top = `${ballRect.top + vy}px`;

        // Create trail
        createTrail(ballRect.left, ballRect.top);
    }

    setInterval(moveBall, 30); 
</script>
</body>
</html>
