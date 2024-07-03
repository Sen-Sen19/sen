<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin Flip</title>
  <style>
    /* styles.css */
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f0f0f0;
    margin: 0;
    font-family: Arial, sans-serif;
}

.container {
    text-align: center;
}

.coin {
    width: 150px;
    height: 150px;
    position: relative;
    perspective: 1000px;
    margin: 20px auto;
}

.side {
    width: 100%;
    height: 100%;
    position: absolute;
    backface-visibility: hidden;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    color: white;
    background: #007bff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.heads, .tails {
    border: 2px solid #ccc;
    background: #007bff; /* Default color, replaced by image */
}

.heads img, .tails img {
    width: 90%;
    height: auto;
    border-radius: 50%;
}

.tails {
    transform: rotateY(180deg);
}

button {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

#result {
    font-size: 18px;
    margin-top: 10px;
}

  </style>
</head>
<body>
    <div class="container">
        <div class="coin" id="coin">
            <div class="side heads">
                <img src="heads.png" alt="Heads">
            </div>
            <div class="side tails">
                <img src="tails.png" alt="Crow">
            </div>
        </div>
        <button id="flipButton">Flip Coin</button>
        <p id="result"></p>
    </div>
    <script>
        /* script.js */
document.getElementById("flipButton").addEventListener("click", function() {
    var coin = document.getElementById("coin");
    var resultText = document.getElementById("result");

    // Reset result text
    resultText.textContent = "";

    // Determine result
    var result = Math.random() < 0.5 ? "heads" : "tails";

    // Add flipping animation
    coin.style.transition = "transform 1s";
    coin.style.transform = result === "heads" ? "rotateY(0deg)" : "rotateY(180deg)";

    // Display result after animation
    setTimeout(function() {
        resultText.textContent = result === "heads" ? "Heads!" : "Crow!";
    }, 1000);
});

    </script>
</body>
</html>
