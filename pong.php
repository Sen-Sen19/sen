<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pong</title>
    <style>
        canvas { background: #000; display: block; margin: 0 auto; }
    </style>
</head>
<body>
    <canvas id="pong" width="800" height="400"></canvas>
    <script>
        const canvas = document.getElementById('pong');
        const context = canvas.getContext('2d');

        // Paddle
        function Paddle(x, y, width, height) {
            this.x = x;
            this.y = y;
            this.width = width;
            this.height = height;
            this.dy = 0;
        }

        // Draw paddle
        Paddle.prototype.draw = function() {
            context.fillStyle = '#fff';
            context.fillRect(this.x, this.y, this.width, this.height);
        };

        // Update paddle position
        Paddle.prototype.update = function() {
            this.y += this.dy;
            if (this.y < 0) this.y = 0;
            if (this.y + this.height > canvas.height) this.y = canvas.height - this.height;
        };

        // Ball
        function Ball(x, y, radius, speed) {
            this.x = x;
            this.y = y;
            this.radius = radius;
            this.speed = speed;
            this.dx = speed;
            this.dy = speed;
        }

        // Draw ball
        Ball.prototype.draw = function() {
            context.fillStyle = '#fff';
            context.beginPath();
            context.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            context.closePath();
            context.fill();
        };

        // Update ball position
        Ball.prototype.update = function(paddle1, paddle2) {
            this.x += this.dx;
            this.y += this.dy;

            // Check for collision with top and bottom walls
            if (this.y - this.radius < 0 || this.y + this.radius > canvas.height) {
                this.dy = -this.dy;
            }

            // Check for collision with paddles
            if (this.x - this.radius < paddle1.x + paddle1.width && this.y > paddle1.y && this.y < paddle1.y + paddle1.height) {
                this.dx = -this.dx;
                this.x = paddle1.x + paddle1.width + this.radius; // Adjust position to avoid sticking
            }
            if (this.x + this.radius > paddle2.x && this.y > paddle2.y && this.y < paddle2.y + paddle2.height) {
                this.dx = -this.dx;
                this.x = paddle2.x - this.radius; // Adjust position to avoid sticking
            }

            // Check for out of bounds (game over or reset)
            if (this.x - this.radius < 0 || this.x + this.radius > canvas.width) {
                this.x = canvas.width / 2;
                this.y = canvas.height / 2;
                this.dx = -this.dx;
            }
        };

        // Initialize game elements
        const player = new Paddle(0, canvas.height / 2 - 50, 10, 100);
        const opponent = new Paddle(canvas.width - 10, canvas.height / 2 - 50, 10, 100);
        const ball = new Ball(canvas.width / 2, canvas.height / 2, 10, 4);

        // WebSocket connection
        let socket;
        let isSocketOpen = false;

        function connectWebSocket() {
            socket = new WebSocket('ws://172.25.114.229:8080');  // Replace with your server IP and port

            socket.onopen = () => {
                console.log('WebSocket connection established');
                isSocketOpen = true;
            };

            socket.onmessage = (event) => {
                const message = JSON.parse(event.data);
                if (message.type === 'paddle') {
                    console.log('Received paddle data:', message);
                    if (message.side === 'opponent') {
                        opponent.y = message.y;
                    }
                } else if (message.type === 'ball') {
                    console.log('Received ball data:', message);
                    ball.x = message.x;
                    ball.y = message.y;
                    ball.dx = message.dx;
                    ball.dy = message.dy;
                }
            };

            socket.onclose = () => {
                console.log('WebSocket connection closed');
                isSocketOpen = false;
                setTimeout(connectWebSocket, 1000);  // Try to reconnect after 1 second
            };

            socket.onerror = (error) => {
                console.error('WebSocket error:', error);
            };
        }

        connectWebSocket();

        // Send paddle position to the server
        function sendPaddlePosition() {
            if (isSocketOpen) {
                socket.send(JSON.stringify({
                    type: 'paddle',
                    y: player.y,
                    side: 'player'
                }));
            }
        }

        // Handle keyboard input
        document.addEventListener('keydown', (event) => {
            switch (event.key) {
                case 'w':
                    player.dy = -8;
                    break;
                case 's':
                    player.dy = 8;
                    break;
            }
        });

        document.addEventListener('keyup', (event) => {
            switch (event.key) {
                case 'w':
                case 's':
                    player.dy = 0;
                    break;
            }
        });

        // Game loop
        function loop() {
            context.clearRect(0, 0, canvas.width, canvas.height);
            player.update();
            opponent.update();
            ball.update(player, opponent);
            player.draw();
            opponent.draw();
            ball.draw();

            // Send paddle position to the server
            sendPaddlePosition();

            // Send ball position if this player is in control
            if (ball.dx < 0 && isSocketOpen) {  // Player controls the ball moving left
                socket.send(JSON.stringify({
                    type: 'ball',
                    x: ball.x,
                    y: ball.y,
                    dx: ball.dx,
                    dy: ball.dy
                }));
            }

            requestAnimationFrame(loop);
        }

        // Start the game loop
        loop();
    </script>
</body>
</html>
