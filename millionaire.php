<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Who Wants to Be a Millionaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            margin: 0;
        }

        .game-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #34495e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        #question-container {
            margin-bottom: 20px;
        }

        h2 {
            font-size: 24px;
            font-weight: 600;
        }

        .answer-btn {
            display: block;
            width: 80%;
            padding: 15px;
            margin: 10px auto;
            background-color: #3498db;
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .answer-btn:hover {
            background-color: #2980b9;
        }

        .correct {
            background-color: #2ecc71;
        }

        .incorrect {
            background-color: #e74c3c;
        }

        .reset-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f39c12;
            color: white;
            font-size: 18px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .reset-btn:hover {
            background-color: #e67e22;
        }

        #score-container {
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="game-container">
        <div id="question-container">
            <h2 id="question">Loading Question...</h2>
        </div>
        <div id="answers-container">
            <button class="answer-btn" id="answer-1">Answer 1</button>
            <button class="answer-btn" id="answer-2">Answer 2</button>
            <button class="answer-btn" id="answer-3">Answer 3</button>
            <button class="answer-btn" id="answer-4">Answer 4</button>
        </div>
        <div id="score-container">
            <p>Score: <span id="score">0</span></p>
        </div>
        <button class="reset-btn" id="reset-game" style="display: none;">Start New Game</button>
    </div>

<script>
 let currentQuestion = 0;
let score = 0;
let questions = [];
let correctAnswer = "";
let difficulty = 'easy';  // Start with easy difficulty

// Decode HTML entities in the string
function decodeHTML(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

// Fetch questions from Open Trivia Database API
async function fetchQuestions() {
    const response = await fetch(`https://opentdb.com/api.php?amount=10&type=multiple&difficulty=${difficulty}`);
    const data = await response.json();
    questions = data.results;
    loadQuestion();
}

// Load a new question
function loadQuestion() {
    if (currentQuestion >= questions.length) {
        alert('Game Over! Your score is ' + score);
        document.getElementById('reset-game').style.display = 'inline-block';
        return;
    }

    const question = questions[currentQuestion];
    // Decode the HTML entities in the question text
    document.getElementById('question').textContent = decodeHTML(question.question);

    // Shuffle answers
    let answers = [...question.incorrect_answers, question.correct_answer];
    answers = answers.sort(() => Math.random() - 0.5);  // Shuffle array

    // Set answers to buttons
    correctAnswer = question.correct_answer;
    for (let i = 0; i < 4; i++) {
        const btn = document.getElementById(`answer-${i + 1}`);
        // Decode the HTML entities in the answers
        btn.textContent = decodeHTML(answers[i]);
        btn.classList.remove('correct', 'incorrect'); // Reset colors
        btn.disabled = false; // Enable buttons again for the next question
    }
}

// Handle answer selection
function handleAnswer(selectedAnswer) {
    const selectedButton = document.getElementById(`answer-${selectedAnswer}`);
    const correct = selectedButton.textContent === correctAnswer;

    // Highlight correct/incorrect answer
    if (correct) {
        score += 100;
        document.getElementById('score').textContent = score;
        selectedButton.classList.add('correct');
        alert('Correct!');
    } else {
        selectedButton.classList.add('incorrect');
        highlightCorrectAnswer();
        alert('Wrong answer! Game Over');
    }

    // Disable buttons after an answer is selected
    disableButtons();

    // Automatically load next question after 4 seconds
    setTimeout(() => {
        currentQuestion++;
        // After every 3 questions, increase the difficulty
        if (currentQuestion % 3 === 0 && difficulty !== 'hard') {
            difficulty = 'medium';  // Change difficulty to medium after 3 questions
        } 
        if (currentQuestion % 6 === 0 && difficulty !== 'hard') {
            difficulty = 'hard';  // Change difficulty to hard after 6 questions
        }
        loadQuestion();
    }, 4000); // Changed from 2000ms to 4000ms for a 4-second delay
}

// Highlight the correct answer if the user selects the wrong answer
function highlightCorrectAnswer() {
    for (let i = 1; i <= 4; i++) {
        const button = document.getElementById(`answer-${i}`);
        if (button.textContent === correctAnswer) {
            button.classList.add('correct');
        }
    }
}

// Disable all answer buttons after selection
function disableButtons() {
    for (let i = 1; i <= 4; i++) {
        document.getElementById(`answer-${i}`).disabled = true;
    }
}

// Event listeners for the answers
document.getElementById('answer-1').addEventListener('click', () => handleAnswer(1));
document.getElementById('answer-2').addEventListener('click', () => handleAnswer(2));
document.getElementById('answer-3').addEventListener('click', () => handleAnswer(3));
document.getElementById('answer-4').addEventListener('click', () => handleAnswer(4));

// Reset the game
document.getElementById('reset-game').addEventListener('click', () => {
    currentQuestion = 0;
    score = 0;
    difficulty = 'easy';  // Reset difficulty to easy
    document.getElementById('score').textContent = score;
    document.getElementById('reset-game').style.display = 'none';
    fetchQuestions();
});

// Start the game by fetching questions
fetchQuestions();
</script>
</body>
</html>
