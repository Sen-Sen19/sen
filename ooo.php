<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Click the Odd One Out Game</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.game-container {
    text-align: center;
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.images {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin: 20px 0;
}

.image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    cursor: pointer;
    border-radius: 10px;
    transition: transform 0.2s ease;
}

.image:hover {
    transform: scale(1.1);
}

#feedback {
    font-size: 1.2em;
    margin-top: 10px;
    color: green;
}

#score {
    font-weight: bold;
}

    </style>
</head>
<body>
    <div class="game-container">
        <h1>Click the Odd One Out</h1>
        <div class="images">
            <img src="" alt="Image 1" id="img1" class="image" onclick="checkAnswer(1)">
            <img src="" alt="Image 2" id="img2" class="image" onclick="checkAnswer(2)">
            <img src="" alt="Image 3" id="img3" class="image" onclick="checkAnswer(3)">
            <img src="" alt="Image 4" id="img4" class="image" onclick="checkAnswer(4)">
            <img src="" alt="Image 5" id="img5" class="image" onclick="checkAnswer(5)">
        </div>
        <p id="feedback"></p>
        <p>Score: <span id="score">0</span></p>
    </div>

<script>
 let score = 0;
let correctAnswerIndex = 0;
const feedback = document.getElementById('feedback');
const scoreDisplay = document.getElementById('score');
const images = document.querySelectorAll('.image');

// Use Unsplash API to get random images
const categories = ['nature', 'animals', 'cars', 'technology', 'food'];

async function getRandomImage(category) {
    const response = await fetch(`https://api.unsplash.com/photos/random?query=${category}&client_id=YOUR_UNSPLASH_ACCESS_KEY`);
    const data = await response.json();
    return data[0].urls.thumb;  // Return the thumbnail URL of the random image
}

async function loadImages() {
    // Pick random categories for the images
    const categoryIndexes = [];
    while (categoryIndexes.length < 4) {
        let randomIndex = Math.floor(Math.random() * categories.length);
        if (!categoryIndexes.includes(randomIndex)) {
            categoryIndexes.push(randomIndex);
        }
    }

    // Pick the odd one out index (set it randomly)
    correctAnswerIndex = Math.floor(Math.random() * 5);

    // Fetch images from the API
    const selectedImages = await Promise.all(categoryIndexes.map(async (index) => {
        return await getRandomImage(categories[index]);
    }));

    // Assign images to the boxes
    for (let i = 0; i < 5; i++) {
        let image = images[i];
        if (i === correctAnswerIndex) {
            image.src = selectedImages[0];  // Assign the odd one out image
        } else {
            image.src = selectedImages[i % selectedImages.length];  // Assign the other random images
        }
    }

    feedback.textContent = ''; // Clear feedback
}

function checkAnswer(selectedIndex) {
    if (selectedIndex === correctAnswerIndex) {
        feedback.textContent = "Correct! Well done.";
        feedback.style.color = "green";
        score++;
    } else {
        feedback.textContent = "Oops! Try again.";
        feedback.style.color = "red";
    }

    scoreDisplay.textContent = score;
    setTimeout(loadImages, 1000); // Load new images after 1 second
}

// Start the game
loadImages();

</script>
</body>
</html>
