<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chess Board</title>
<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f0f0f0;
  }

  .board {
    display: grid;
    grid-template-columns: repeat(8, 50px);
    grid-template-rows: repeat(8, 50px);
    gap: 2px;
    background-color: #d18b47;
    padding: 2px;
    border: 2px solid #000; /* Add border for visual separation */
  }

  .square:nth-child(even) {
    background-color: #ffce9e;
  }

  .square:nth-child(odd) {
    background-color: #d18b47;
  }

  .piece {
    font-size: 36px;
    cursor: move;
    pointer-events: all; /* Ensure pieces can be interacted with */
  }

  .draggable {
    user-select: none; /* Prevent text selection during drag */
  }

</style>
</head>
<body>
<div class="board" id="board">
  <!-- Generate chessboard squares dynamically -->
  <!-- This section will be populated by JavaScript -->
</div>

<!-- Unicode characters for chess pieces -->
<div id="pieces">
  <span id="whiteKing" class="piece draggable">&#9812;</span>
  <span id="whiteQueen" class="piece draggable">&#9813;</span>
  <span id="whiteRook" class="piece draggable">&#9814;</span>
  <span id="whiteBishop" class="piece draggable">&#9815;</span>
  <span id="whiteKnight" class="piece draggable">&#9816;</span>
  <span id="whitePawn" class="piece draggable">&#9817;</span>
  <span id="blackKing" class="piece draggable">&#9818;</span>
  <span id="blackQueen" class="piece draggable">&#9819;</span>
  <span id="blackRook" class="piece draggable">&#9820;</span>
  <span id="blackBishop" class="piece draggable">&#9821;</span>
  <span id="blackKnight" class="piece draggable">&#9822;</span>
  <span id="blackPawn" class="piece draggable">&#9823;</span>
</div>

<script>
  // JavaScript to dynamically generate chessboard squares
  const board = document.getElementById('board');
  const squares = [];

  // Generate 64 squares (8x8 grid)
  for (let i = 0; i < 64; i++) {
    const square = document.createElement('div');
    square.classList.add('square');
    squares.push(square);
    board.appendChild(square);
  }

  // Alternate colors for chessboard
  squares.forEach((square, index) => {
    const isEvenRow = Math.floor(index / 8) % 2 === 0;
    const isEvenColumn = index % 2 === 0;
    if ((isEvenRow && !isEvenColumn) || (!isEvenRow && isEvenColumn)) {
      square.style.backgroundColor = '#ffce9e';
    } else {
      square.style.backgroundColor = '#d18b47';
    }
  });

  // Drag and drop functionality for pieces
  const pieces = document.querySelectorAll('.piece');

  pieces.forEach(piece => {
    piece.addEventListener('dragstart', dragStart);
    piece.addEventListener('dragend', dragEnd);
  });

  function dragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.id);
  }

  function dragEnd(event) {
    // do something when drag ends, if needed
  }

</script>
</body>
</html>
