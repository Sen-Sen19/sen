<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slot Machine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .slot-machine {
            display: flex;
            justify-content: center;
            margin: 20px auto;
            padding: 10px;
            border: 2px solid #fff;
            width: 250px;
            background-color: #444;
            overflow: hidden; /* Hide overflow for rolling effect */
        }

        .reel {
            font-size: 50px;
            margin: 0 10px;
            width: 60px;
            height: 60px;
            background-color: #222;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            transition: transform 0.5s ease; /* Animation for rolling effect */
        }

        .lever {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #ff6347;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
        }

        .lever:hover {
            background-color: #ff4500;
        }

        #result {
            margin-top: 20px;
            font-size: 24px;
            color: #0f0;
        }

        .rolling {
            animation: roll 1s forwards; /* Roll animation */
        }

        @keyframes roll {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-200px); /* Roll upwards off screen */
            }
            100% {
                transform: translateY(0); /* Return to original position */
            }
        }
    </style>
</head>
<body>
    <div class="slot-machine">
        <div class="reel" id="reel1">🍒</div>
        <div class="reel" id="reel2">🍋</div>
        <div class="reel" id="reel3">🍊</div>
    </div>
    <button class="lever" id="lever">Pull Lever</button>
    <div id="result"></div>

    <script>
        document.getElementById("lever").addEventListener("click", spin);

        function spin() {
            const reel1 = document.getElementById("reel1");
            const reel2 = document.getElementById("reel2");
            const reel3 = document.getElementById("reel3");
            const result = document.getElementById("result");

            const symbols = ["🍒", "🍋", "🍊", "🍉", "🍇", "🔔", "💎", "🍀", "⭐️", "⚡️", "🃏", "7️⃣"];
            const symbolNames = ["Cherry", "Lemon", "Orange", "Watermelon", "Grape", "Bell", "Diamond", "Lucky Horseshoe", "Star", "Lightning Bolt", "Wild", "Seven"];

            // Add rolling class to each reel
            reel1.classList.add("rolling");
            reel2.classList.add("rolling");
            reel3.classList.add("rolling");

            // Randomly select a symbol for each reel after a short delay
            setTimeout(() => {
                const symbol1 = symbols[Math.floor(Math.random() * symbols.length)];
                const symbol2 = symbols[Math.floor(Math.random() * symbols.length)];
                const symbol3 = symbols[Math.floor(Math.random() * symbols.length)];

                // Update each reel with the new symbol
                reel1.textContent = symbol1;
                reel2.textContent = symbol2;
                reel3.textContent = symbol3;

                // Remove the rolling animation class after finishing
                reel1.classList.remove("rolling");
                reel2.classList.remove("rolling");
                reel3.classList.remove("rolling");

                // Determine the result
                if (symbol1 === symbol2 && symbol2 === symbol3) {
                    result.textContent = `🎉 Jackpot! You Win with ${symbolNames[symbols.indexOf(symbol1)]}! 🎉`;
                } else if (symbol1 === "🃏" || symbol2 === "🃏" || symbol3 === "🃏") {
                    result.textContent = "Wild Symbol! You have a chance to win!";
                } else {
                    result.textContent = "Try Again!";
                }
            }, 1000); // Wait for 1s before displaying results to match the animation
        }
    </script>
</body>
</html>
