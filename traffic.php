<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AI Walking Character</title>
  <style>
    body {
      margin: 0;
      overflow: hidden;
      background-color: #f0f0f0;
    }
    #canvas {
      display: block;
      background-color: #fff;
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <canvas id="canvas"></canvas>

  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
  <script>
    // Setup Canvas
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    // Character's body and limbs
    let bodyX = canvas.width / 2, bodyY = canvas.height - 100;
    let headRadius = 20;
    let bodyWidth = 60, bodyHeight = 40;
    let limbLength = 30;
    let armAngle = 0, legAngle = 0;
    let velocity = 0;
    let isFalling = false;

    // Simple state for the model: [x, y, armAngle, legAngle, velocity]
    const state = [bodyX, bodyY, armAngle, legAngle, velocity];
    
    // Neural network model for reinforcement learning
    const model = tf.sequential();
    model.add(tf.layers.dense({units: 16, activation: 'relu', inputShape: [5]})); // State: body position, limb angles, velocity
    model.add(tf.layers.dense({units: 4, activation: 'linear'})); // Actions: change limb angles

    model.compile({optimizer: 'adam', loss: 'meanSquaredError'});

    // Simple training data (you'd replace this with your learning loop)
    const trainingData = tf.tensor2d([[0, 0, 0, 0, 0]]);
    const targetData = tf.tensor2d([[0, 0, 0, 0]]);

    // Draw the character on the canvas
    function drawCharacter() {
      ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas on every frame

      // Body
      ctx.fillStyle = '#ff6600';
      ctx.fillRect(bodyX - bodyWidth / 2, bodyY - bodyHeight / 2, bodyWidth, bodyHeight);

      // Head
      ctx.beginPath();
      ctx.arc(bodyX, bodyY - bodyHeight / 2 - headRadius, headRadius, 0, Math.PI * 2);
      ctx.fillStyle = '#ffcc00';
      ctx.fill();

      // Arms
      ctx.save();
      ctx.translate(bodyX, bodyY - bodyHeight / 2); // Set origin to body
      ctx.rotate(armAngle); // Rotate arm based on the angle
      ctx.fillStyle = '#00ff00';
      ctx.fillRect(0, -limbLength / 2, limbLength, 10); // Draw arm
      ctx.restore();

      // Legs
      ctx.save();
      ctx.translate(bodyX, bodyY + bodyHeight / 2); // Set origin to body
      ctx.rotate(legAngle); // Rotate leg based on the angle
      ctx.fillStyle = '#00ff00';
      ctx.fillRect(0, limbLength / 2, limbLength, 10); // Draw leg
      ctx.restore();
    }

    // Simple reward function
    function reward() {
      if (bodyY < canvas.height - 100) {
        isFalling = true; // Penalty if falling
        return -1;
      } else if (velocity > 1) {
        return 1; // Reward for moving forward
      }
      return 0;
    }

    // Update state and move character
    function updateCharacter(action) {
      // Apply the action to adjust angles
      armAngle += action[0];
      legAngle += action[1];
      
      // Update the body position based on velocity (forward movement)
      velocity += 0.1;
      bodyX += velocity;

      // Check for reward/penalty
      const currentReward = reward();

      return currentReward;
    }

    // Training loop (For now just a placeholder)
    async function trainModel() {
      await model.fit(trainingData, targetData, {epochs: 100});
    }

    // Predict action from model based on current state
    async function predictAction(state) {
      const prediction = await model.predict(tf.tensor2d([state]));
      return prediction.dataSync(); // Action to move limbs
    }

    // Game loop
    function gameLoop() {
      // Get predicted action from model
      predictAction(state).then((action) => {
        // Update character's movement based on the predicted action
        const rewardValue = updateCharacter(action);
        
        // Training based on reward (reinforcement learning)
        // For simplicity, we’re directly adjusting target data
        targetData.set([rewardValue, rewardValue, rewardValue, rewardValue], 0, 0);

        // Draw the updated character
        drawCharacter();

        // Call the next frame
        requestAnimationFrame(gameLoop);
      });
    }

    // Start the game loop
    gameLoop();
  </script>
</body>
</html>
