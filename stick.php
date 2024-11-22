<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stick Jumper</title>
 <style>
    body {
  margin: 0;
  overflow: hidden;
  background: linear-gradient(to top, #76b852, #8dc26f);
}

#game {
  position: relative;
  width: 100vw;
  height: 100vh;
  overflow: hidden;
}

#character {
  position: absolute;
  bottom: 100px;
  left: 100px;
  width: 30px;
  height: 30px;
  background-color: #f00;
  border-radius: 50%;
}

#stick {
  position: absolute;
  bottom: 130px;
  left: 120px;
  width: 5px;
  height: 0;
  background-color: #000;
  transform-origin: bottom;
  transition: height 0.2s;
}

#platforms {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.platform {
  position: absolute;
  bottom: 0;
  width: 100px;
  height: 20px;
  background-color: #654321;
}

#score {
  position: absolute;
  top: 10px;
  left: 10px;
  color: #fff;
  font-family: Arial, sans-serif;
  font-size: 20px;
}

 </style>
</head>
<body>
  <div id="game">
    <div id="character"></div>
    <div id="stick"></div>
    <div id="platforms"></div>
    <div id="score">Score: 0</div>
  </div>
  <script>
    const game = document.getElementById('game');
const character = document.getElementById('character');
const stick = document.getElementById('stick');
const platforms = document.getElementById('platforms');
const scoreDisplay = document.getElementById('score');

let isHolding = false;
let stickHeight = 0;
let score = 0;
let currentPlatform = { left: 100, width: 100 };
let nextPlatform;

function createPlatform(left) {
  const platform = document.createElement('div');
  platform.className = 'platform';
  platform.style.left = `${left}px`;
  platform.style.width = `${100 + Math.random() * 50}px`;
  platforms.appendChild(platform);
  return platform;
}

function resetGame() {
  platforms.innerHTML = '';
  score = 0;
  stickHeight = 0;
  character.style.left = '100px';
  stick.style.height = '0px';
  nextPlatform = createPlatform(300);
  updateScore();
}

function updateScore() {
  scoreDisplay.textContent = `Score: ${score}`;
}

function growStick() {
  if (isHolding) {
    stickHeight += 5;
    stick.style.height = `${stickHeight}px`;
    requestAnimationFrame(growStick);
  }
}

function dropStick() {
  stick.style.transition = 'transform 0.5s';
  stick.style.transform = 'rotate(90deg)';
  const stickEnd = currentPlatform.left + stickHeight;
  const nextPlatformLeft = parseInt(nextPlatform.style.left, 10);
  const nextPlatformWidth = parseInt(nextPlatform.style.width, 10);

  if (stickEnd >= nextPlatformLeft && stickEnd <= nextPlatformLeft + nextPlatformWidth) {
    // Stick is accurate
    moveCharacter(nextPlatformLeft);
  } else {
    // Stick failed
    moveCharacter(currentPlatform.left + stickHeight, true);
  }
}

function moveCharacter(target, fail = false) {
  character.style.transition = 'left 0.5s';
  character.style.left = `${target}px`;

  setTimeout(() => {
    if (fail) {
      alert('Game Over! Your score: ' + score);
      resetGame();
    } else {
      currentPlatform = {
        left: target,
        width: parseInt(nextPlatform.style.width, 10),
      };
      platforms.removeChild(nextPlatform);
      nextPlatform = createPlatform(target + currentPlatform.width + Math.random() * 100 + 50);
      stickHeight = 0;
      stick.style.height = '0px';
      stick.style.transform = 'rotate(0deg)';
      stick.style.transition = 'none';
      score++;
      updateScore();
    }
  }, 500);
}

document.addEventListener('mousedown', () => {
  isHolding = true;
  growStick();
});

document.addEventListener('mouseup', () => {
  isHolding = false;
  dropStick();
});

// Initialize Game
resetGame();

  </script>
</body>
</html>
