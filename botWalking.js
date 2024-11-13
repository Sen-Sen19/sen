// Setup Canvas
const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

// Physics Parameters
const GRAVITY = 0.3;   // Gravity force pulling down
const FRICTION = 0.95; // Friction to slow down bot's speed
const BOT_WIDTH = 50;   // Bot width (for collision purposes)
const BOT_HEIGHT = 70;  // Bot height (for collision purposes)
const LEG_LENGTH = 60;  // Length of each leg
const LEG_WIDTH = 10;   // Width of each leg

// Bot Properties
let bot = {
    x: canvas.width / 2,
    y: canvas.height - BOT_HEIGHT - 50,
    velocityX: 0,
    velocityY: 0,
    angle: 0,
    walkingSpeed: 0.5,
    isFalling: false
};

// Legs (left and right)
let leftLeg = {
    x: bot.x - BOT_WIDTH / 2,
    y: bot.y + BOT_HEIGHT,
    angle: 0,
    torque: 0,
    speed: 0
};

let rightLeg = {
    x: bot.x + BOT_WIDTH / 2,
    y: bot.y + BOT_HEIGHT,
    angle: 0,
    torque: 0,
    speed: 0
};

// Update Physics and Animation
function update() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Apply gravity to the bot's vertical velocity
    bot.velocityY += GRAVITY;

    // Move bot based on its velocity
    bot.y += bot.velocityY;
    bot.x += bot.velocityX;

    // Apply friction to slow down the bot's horizontal movement
    bot.velocityX *= FRICTION;

    // Collision with the ground
    if (bot.y + BOT_HEIGHT > canvas.height) {
        bot.y = canvas.height - BOT_HEIGHT;
        bot.velocityY = 0;
        bot.isFalling = false;
    }

    // Leg movement simulation: alternate lifting and placing legs
    leftLeg.angle += leftLeg.speed;
    rightLeg.angle -= rightLeg.speed;

    // Adjust speed of the legs to simulate walking
    leftLeg.speed = Math.sin(leftLeg.angle) * 0.1; // Sinusoidal leg movement
    rightLeg.speed = Math.cos(rightLeg.angle) * 0.1;

    // Apply torque to the bot's body
    if (leftLeg.angle > Math.PI / 4 || rightLeg.angle < -Math.PI / 4) {
        bot.velocityX += bot.walkingSpeed; // Move the bot forward if legs are placed well
    }

    // Draw the bot body (represented as a rectangle)
    ctx.fillStyle = '#3498db';
    ctx.fillRect(bot.x - BOT_WIDTH / 2, bot.y - BOT_HEIGHT / 2, BOT_WIDTH, BOT_HEIGHT);

    // Draw the left leg
    ctx.save();
    ctx.translate(leftLeg.x, leftLeg.y);
    ctx.rotate(leftLeg.angle);
    ctx.fillStyle = '#2ecc71';
    ctx.fillRect(-LEG_WIDTH / 2, 0, LEG_WIDTH, LEG_LENGTH);
    ctx.restore();

    // Draw the right leg
    ctx.save();
    ctx.translate(rightLeg.x, rightLeg.y);
    ctx.rotate(rightLeg.angle);
    ctx.fillStyle = '#e74c3c';
    ctx.fillRect(-LEG_WIDTH / 2, 0, LEG_WIDTH, LEG_LENGTH);
    ctx.restore();

    // Repeat the update loop
    requestAnimationFrame(update);
}

// Start the simulation
update();
