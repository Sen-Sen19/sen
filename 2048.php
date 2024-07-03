<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dama Game</title>
    <style>
        .board {
            display: grid;
            grid-template-columns: repeat(8, 50px);
            grid-template-rows: repeat(8, 50px);
            gap: 2px;
        }

        .tile {
            width: 50px;
            height: 50px;
            background-color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .piece {
            width: 80%;
            height: 80%;
            border-radius: 50%;
        }

        .piece-black {
            background-color: black;
        }

        .piece-white {
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="board">
        <!-- Board tiles and pieces will be dynamically created using JavaScript -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const board = document.querySelector('.board');
            let currentPlayer = 'black'; // Player to start

            // Initialize the board
            function initializeBoard() {
                for (let row = 0; row < 8; row++) {
                    for (let col = 0; col < 8; col++) {
                        const tile = document.createElement('div');
                        tile.classList.add('tile');
                        tile.dataset.row = row;
                        tile.dataset.col = col;
                        if ((row + col) % 2 === 0) {
                            tile.classList.add('light');
                        } else {
                            tile.classList.add('dark');
                        }
                        board.appendChild(tile);
                    }
                }
            }

            // Add pieces to the board
            function addPieces() {
                // Placing initial black pieces
                placePiece(0, 1, 'black');
                placePiece(0, 3, 'black');
                placePiece(0, 5, 'black');
                placePiece(0, 7, 'black');
                placePiece(1, 0, 'black');
                placePiece(1, 2, 'black');
                placePiece(1, 4, 'black');
                placePiece(1, 6, 'black');
                placePiece(2, 1, 'black');
                placePiece(2, 3, 'black');
                placePiece(2, 5, 'black');
                placePiece(2, 7, 'black');

                // Placing initial white pieces
                placePiece(5, 0, 'white');
                placePiece(5, 2, 'white');
                placePiece(5, 4, 'white');
                placePiece(5, 6, 'white');
                placePiece(6, 1, 'white');
                placePiece(6, 3, 'white');
                placePiece(6, 5, 'white');
                placePiece(6, 7, 'white');
                placePiece(7, 0, 'white');
                placePiece(7, 2, 'white');
                placePiece(7, 4, 'white');
                placePiece(7, 6, 'white');
            }

            // Function to place a piece on a specific tile
            function placePiece(row, col, color) {
                const tile = document.querySelector(`.tile[data-row="${row}"][data-col="${col}"]`);
                if (tile) {
                    const piece = document.createElement('div');
                    piece.classList.add('piece', `piece-${color}`);
                    tile.appendChild(piece);
                }
            }

            // Handle player's move
            function handlePlayerMove(tile) {
                if (currentPlayer === 'black') {
                    // Place black piece
                    if (!tile.querySelector('.piece')) {
                        const piece = document.createElement('div');
                        piece.classList.add('piece', 'piece-black');
                        tile.appendChild(piece);
                        currentPlayer = 'white'; // Switch turn to white player
                    }
                }
            }

            // AI opponent's move
            function makeAIMove() {
                // Basic AI logic - make a random move for the opponent
                const tiles = Array.from(document.querySelectorAll('.tile'));
                const emptyTiles = tiles.filter(tile => !tile.querySelector('.piece'));

                if (emptyTiles.length > 0) {
                    const randomTile = emptyTiles[Math.floor(Math.random() * emptyTiles.length)];
                    const aiPiece = document.createElement('div');
                    aiPiece.classList.add('piece', 'piece-white');
                    randomTile.appendChild(aiPiece);
                    currentPlayer = 'black'; // Switch turn back to black player after AI move
                }
            }

            // Initialize the game
            function initGame() {
                initializeBoard();
                addPieces();

                // Event listener for player's move (click event on tiles)
                board.addEventListener('click', function(event) {
                    const tile = event.target.closest('.tile');
                    if (tile) {
                        handlePlayerMove(tile);
                        // After player moves, make AI move
                        makeAIMove();
                    }
                });
            }

            // Start the game
            initGame();
        });
    </script>
</body>
</html>
