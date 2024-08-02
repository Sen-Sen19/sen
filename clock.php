<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Include FontAwesome -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 0C5.383 0 0 5.383 0 12c0 6.617 5.383 12 12 12s12-5.383 12-12c0-6.617-5.383-12-12-12zm0 21c-5.514 0-10-4.486-10-10S6.486 1 12 1s10 4.486 10 10-4.486 10-10 10z'/%3E%3Cpath d='M12 5a1 1 0 0 1 1 1v5h4a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-5V6a1 1 0 0 1 1-1z'/%3E%3C/svg%3E">
    <title>My Timer</title>

    <style>
        body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #282c34;
    color: white;
}

.container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 90%; /* Adjusted width for responsiveness */
    max-width: 800px; /* Adjusted maximum width for responsiveness */
}

.clock-container,
.timers-container {
    text-align: center;
    border: 2px solid #61dafb;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    margin-bottom: 20px; /* Added margin between containers */
}

#clock {
    font-size: 3em; /* Adjusted font size for responsiveness */
    text-shadow: 0 0 3px #61dafb, 0 0 3px #61dafb; /* Adjusted text shadow for responsiveness */
}

.clock-container {
    margin-bottom: 20px; /* Added margin between clock and timers */
}

.timer {
    display: flex;
    justify-content: space-between;
    margin: 10px 0;
    font-size: 1.2em; /* Adjusted font size for responsiveness */
}

.timer span:first-child {
    text-align: left;
}

.timer span:last-child {
    text-align: right;
}

.neon-blue {
    color: #ffffff;
    text-shadow: 0 0 3px #61dafb, 0 0 3px #61dafb; /* Adjusted text shadow for responsiveness */
}

.neon-red {
    color: white;
    text-shadow: 0 0 3px red, 0 0 3px red; /* Adjusted text shadow for responsiveness */
}

/* Media query for smaller screens */
@media (max-width: 600px) {
    .container {
        width: 90%; /* Adjusted width for smaller screens */
    }
    
    #clock {            
        font-size: 2.5em; /* Adjusted font size for smaller screens */
    }
    
    .timer {
        font-size: 1em; /* Adjusted font size for smaller screens */
    }
}

    </style>
</head>

<body>
    <div class="container">
        <div class="clock-container">
            <h1>Clock</h1>
            <div id="clock"></div>
        </div>
        <div class="timers-container">
            <h1>Timer</h1>
            <div class="timer">
                <span>9 AM First Break: </span><span id="timer1" class="neon-blue"></span>
            </div>
            <div class="timer">
                <span>12 PM Lunch: </span><span id="timer2" class="neon-blue"></span>
            </div>
            <div class="timer">
                <span>3 PM Tea Break: </span><span id="timer3" class="neon-blue"></span>
            </div>
            <div class="timer">
                <span>6 PM Out: </span><span id="timer4" class="neon-blue"></span>
            </div>
        </div>
    </div>
    <script>
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; 
            const currentTime = `${hours}:${minutes}:${seconds} ${ampm}`;
            document.getElementById('clock').textContent = currentTime;
        }

        function calculateTimeDifference(targetHour, targetMinute) {
            const now = new Date();
            const targetTime = new Date();
            targetTime.setHours(targetHour, targetMinute, 0, 0);

            if (now > targetTime) {
                targetTime.setDate(targetTime.getDate() + 1);
            }

            const diff = targetTime - now;
            const hours = Math.floor((diff % 86400000) / 3600000);
            const minutes = Math.floor((diff % 3600000) / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);

            return { hours, minutes, seconds };
        }

        function formatTime({ hours, minutes, seconds }) {
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        function updateTimers() {
    const now = new Date();
    const currentHour = now.getHours();
    const currentMinute = now.getMinutes();
    const currentSecond = now.getSeconds();
    
    const timer1Diff = calculateTimeDifference(9, 15);
    const timer2Diff = calculateTimeDifference(12, 0);
    const timer3Diff = calculateTimeDifference(15, 0);
    const timer4Diff = calculateTimeDifference(18, 0);

    document.getElementById('timer1').textContent = formatTime(timer1Diff);
    document.getElementById('timer2').textContent = formatTime(timer2Diff);
    document.getElementById('timer3').textContent = formatTime(timer3Diff);
    document.getElementById('timer4').textContent = formatTime(timer4Diff);

    // Change to white font with red shadow if countdown reaches zero
    if (timer1Diff.hours === 0 && timer1Diff.minutes === 0 && timer1Diff.seconds === 0) {
        document.getElementById('timer1').classList.remove('neon-blue');
        document.getElementById('timer1').classList.add('neon-red');
    }
    if (timer2Diff.hours === 0 && timer2Diff.minutes === 0 && timer2Diff.seconds === 0) {
        document.getElementById('timer2').classList.remove('neon-blue');
        document.getElementById('timer2').classList.add('neon-red');
    }
    if (timer3Diff.hours === 0 && timer3Diff.minutes === 0 && timer3Diff.seconds === 0) {
        document.getElementById('timer3').classList.remove('neon-blue');
        document.getElementById('timer3').classList.add('neon-red');
    }
    if (timer4Diff.hours === 0 && timer4Diff.minutes === 0 && timer4Diff.seconds === 0) {
        document.getElementById('timer4').classList.remove('neon-blue');
        document.getElementById('timer4').classList.add('neon-red');
    }

    // Change to white font with red shadow if it's past the target time
    if (currentHour > 9 || (currentHour === 9 && currentMinute >= 15)) {
        document.getElementById('timer1').classList.remove('neon-blue');
        document.getElementById('timer1').classList.add('neon-red');
    }
    if (currentHour > 12 || (currentHour === 12 && currentMinute >= 0)) {
        document.getElementById('timer2').classList.remove('neon-blue');
        document.getElementById('timer2').classList.add('neon-red');
    }
    if (currentHour > 15 || (currentHour === 15 && currentMinute >= 0)) {
        document.getElementById('timer3').classList.remove('neon-blue');
        document.getElementById('timer3').classList.add('neon-red');
    }
    if (currentHour > 18 || (currentHour === 18 && currentMinute >= 0)) {
        document.getElementById('timer4').classList.remove('neon-blue');
        document.getElementById('timer4').classList.add('neon-red');
    }

    // Revert to default style at 7:30 AM (any second within the minute)
    if (currentHour === 7 && currentMinute === 30 && currentSecond < 60) {
        document.getElementById('timer1').classList.remove('neon-red');
        document.getElementById('timer1').classList.add('neon-blue');
        document.getElementById('timer2').classList.remove('neon-red');
        document.getElementById('timer2').classList.add('neon-blue');
        document.getElementById('timer3').classList.remove('neon-red');
        document.getElementById('timer3').classList.add('neon-blue');
        document.getElementById('timer4').classList.remove('neon-red');
        document.getElementById('timer4').classList.add('neon-blue');
    }
}

        // Update the clock and timers every second
        setInterval(() => {
            updateClock();
            updateTimers();
        }, 1000);

        // Initialize the clock and timers immediately on page load
        updateClock();
        updateTimers();
    </script>
</body>
</html>
