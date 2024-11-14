<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sudoku Game</title>
  <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    text-align: center;
}

.sudoku-grid {
    display: grid;
    grid-template-columns: repeat(9, 40px);
    grid-template-rows: repeat(9, 40px);
    gap: 2px;
    margin: 20px 0;
    background-color: #333;
    border: 3px solid #444;
}

.sudoku-grid input {
    width: 40px;
    height: 40px;
    font-size: 18px;
    text-align: center;
    border: 1px solid #ccc;
    background-color: #fff;
}

.sudoku-grid input:disabled {
    background-color: #f0f0f0;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    background-color: #5cb85c;
    border: none;
    color: white;
    border-radius: 5px;
}

button:hover {
    background-color: #4cae4c;
}

  </style>
</head>
<body>
    <div class="container">
        <h1>Sudoku</h1>
        <div class="sudoku-grid" id="sudokuGrid"></div>
        <button onclick="resetBoard()">Reset</button>
    </div>
   <script>
    // Initialize a basic Sudoku puzzle
const sudokuBoard = [
    [5, 3, 0, 0, 7, 0, 0, 0, 0],
    [6, 0, 0, 1, 9, 5, 0, 0, 0],
    [0, 9, 8, 0, 0, 0, 0, 6, 0],
    [8, 0, 0, 0, 6, 0, 0, 0, 3],
    [4, 0, 0, 8, 0, 3, 0, 0, 1],
    [7, 0, 0, 0, 2, 0, 0, 0, 6],
    [0, 6, 0, 0, 0, 0, 2, 8, 0],
    [0, 0, 0, 4, 1, 9, 0, 0, 5],
    [0, 0, 0, 0, 8, 0, 0, 7, 9]
];

function generateSudokuGrid() {
    const grid = document.getElementById('sudokuGrid');
    grid.innerHTML = ''; // Clear any existing cells

    for (let row = 0; row < 9; row++) {
        for (let col = 0; col < 9; col++) {
            const cell = document.createElement('input');
            cell.type = 'text';
            cell.maxLength = 1;
            cell.value = sudokuBoard[row][col] === 0 ? '' : sudokuBoard[row][col];

            // Disable cells that are pre-filled
            if (sudokuBoard[row][col] !== 0) {
                cell.disabled = true;
            }

            // Add event listener for user input
            cell.addEventListener('input', () => updateBoard(row, col, cell));

            grid.appendChild(cell);
        }
    }
}

function updateBoard(row, col, cell) {
    const value = parseInt(cell.value);
    if (isNaN(value) || value < 1 || value > 9) {
        sudokuBoard[row][col] = 0;
        cell.value = '';
    } else {
        sudokuBoard[row][col] = value;
    }
}

function resetBoard() {
    sudokuBoard.forEach((row, rowIndex) => {
        row.forEach((value, colIndex) => {
            if (value === 0) {
                document.querySelectorAll('input')[rowIndex * 9 + colIndex].value = '';
            }
        });
    });
}

window.onload = generateSudokuGrid;

   </script>
</body>
</html>
