<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI-Powered Text Adventure Game</title>
   <style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #1c1c1c;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.game-container {
    text-align: center;
    max-width: 600px;
    padding: 20px;
    background-color: #333;
    border-radius: 10px;
}

button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 10px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}

#choices button {
    width: 100%;
    max-width: 300px;
    margin: 10px auto;
}

   </style>
</head>
<body>
    <div class="game-container">
        <h1>AI-Powered Text Adventure</h1>
        <div id="story"></div>
        <div id="choices">
            <button id="choice1" onclick="makeChoice(1)">Choice 1</button>
            <button id="choice2" onclick="makeChoice(2)">Choice 2</button>
            <button id="choice3" onclick="makeChoice(3)">Choice 3</button>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chance@1.1.8/chance.min.js"></script>
<script>
// Initialize Chance.js
const chance = new Chance();

// Function to generate random story elements
function generateStory() {
    const location = chance.city();
    const character = chance.name();
    const action = chance.word();
    const object = chance.animal();

    const storyText = `You find yourself in a mysterious place, perhaps a city called ${location}. You see a person named ${character} who seems to be ${action} with a strange ${object}. What do you do?`;

    const choices = [
        { text: `Approach ${character}`, nextStory: 1 },
        { text: `Run away from the ${object}`, nextStory: 2 },
        { text: `Look for clues around the city`, nextStory: 3 }
    ];

    return { storyText, choices };
}

let currentStoryIndex = 0;

function startGame() {
    currentStoryIndex = 0;
    updateStory();
}

// Function to update the story and choices
function updateStory() {
    const { storyText, choices } = generateStory();
    document.getElementById("story").innerText = storyText;

    // Update buttons with random choices
    for (let i = 0; i < 3; i++) {
        const choiceButton = document.getElementById(`choice${i + 1}`);
        if (choices[i]) {
            choiceButton.style.display = "inline-block";
            choiceButton.innerText = choices[i].text;
        } else {
            choiceButton.style.display = "none";
        }
    }
}

// Function to handle the player's choice
function makeChoice(choiceNumber) {
    const choice = generateStory().choices[choiceNumber - 1];
    currentStoryIndex = choice.nextStory;
    updateStory();
}

startGame();

</script>
</body>
</html>
