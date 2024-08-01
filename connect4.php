<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect Four</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: white; /* Light text */
        }

        #game {
            display: flex;
            flex-direction: column;
            border: 2px solid #fff; /* Light border */
            background-color: #1e1e1e; /* Darker background for the game area */
            margin-top: 20px;
        }

        .row {
            display: flex;
            height: 50px;
        }

        .cell {
            width: 50px;
            height: 50px;
            border: 1px solid #fff; /* Light border for cells */
            border-radius: 50%;
            margin: 0 2px;
            background-color: #282828; /* Dark cell background */
            cursor: pointer;
            transition: background-color 0.3s; /* Smooth transition */
        }

        .cell.yellow {
            background-color: #ffeb3b; 
        }
        .cell.red {
            background-color: #f44336; 
        }

        h1 {
            margin: 20px 0;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #424242; /* Dark button background */
            color: white; /* Light button text */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer;
        }

        button:hover {
            background-color: #616161; /* Lighter gray on hover */
        }
    </style>
</head>
<body>
    <h1>Connect Four</h1>
    <div id="game">
        <div class="row" id="row0"></div>
        <div class="row" id="row1"></div>
        <div class="row" id="row2"></div>
        <div class="row" id="row3"></div>
        <div class="row" id="row4"></div>
        <div class="row" id="row5"></div>
    </div>
    <button id="reset">Reset Game</button>
 <script>
    const rows = 6;
const columns = 7;
let currentPlayer = 'yellow';
let gameBoard = Array(rows).fill().map(() => Array(columns).fill(''));
const gameContainer = document.getElementById('game');
const resetButton = document.getElementById('reset');

function createCell(row, col) {
    const cell = document.createElement('div');
    cell.classList.add('cell');
    cell.addEventListener('click', () => dropDisc(col));
    document.getElementById(`row${row}`).appendChild(cell);
}

function dropDisc(col) {
    for (let row = rows - 1; row >= 0; row--) {
        if (!gameBoard[row][col]) {
            gameBoard[row][col] = currentPlayer;
            const cell = document.getElementsByClassName('cell')[row * columns + col];
            cell.classList.add(currentPlayer);
            if (checkWin(row, col)) {
                alert(`${currentPlayer} wins!`);
                return;
            }
            currentPlayer = currentPlayer === 'yellow' ? 'red' : 'yellow';
            break;
        }
    }
}

function checkWin(row, col) {
    return checkDirection(row, col, 1, 0) ||  // Horizontal
           checkDirection(row, col, 0, 1) ||  // Vertical
           checkDirection(row, col, 1, 1) ||  // Diagonal \
           checkDirection(row, col, 1, -1);    // Diagonal /
}

function checkDirection(row, col, deltaRow, deltaCol) {
    let count = 1;
    count += countDiscs(row, col, deltaRow, deltaCol);
    count += countDiscs(row, col, -deltaRow, -deltaCol);
    return count >= 4;
}

function countDiscs(row, col, deltaRow, deltaCol) {
    let count = 0;
    let r = row + deltaRow;
    let c = col + deltaCol;
    while (r >= 0 && r < rows && c >= 0 && c < columns && gameBoard[r][c] === currentPlayer) {
        count++;
        r += deltaRow;
        c += deltaCol;
    }
    return count;
}

function resetGame() {
    gameBoard = Array(rows).fill().map(() => Array(columns).fill(''));
    const cells = document.getElementsByClassName('cell');
    for (let i = 0; i < cells.length; i++) {
        cells[i].classList.remove('yellow', 'red');
    }
    currentPlayer = 'yellow';
}

resetButton.addEventListener('click', resetGame);

for (let col = 0; col < columns; col++) {
    for (let row = 0; row < rows; row++) {
        createCell(row, col);
    }
}

 </script>
</body>
</html>
