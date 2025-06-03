<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>24-Hour Countdown</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>

    <div class="timer-box">
        <div class="timer" id="timer">24:00:00</div>
        <button class="start-btn" onclick="startCountdown()" id="startBtn">Start Countdown</button>
        <div class="label">Time remaining</div>
    </div>

    <script>
        let totalSeconds = 24 * 60 * 60;
        let timerInterval = null;
        let running = false;

        const timerDisplay = document.getElementById("timer");
        const startBtn = document.getElementById("startBtn");

        function pad(n) {
            return n < 10 ? '0' + n : n;
        }

        function updateTimer() {
            if (totalSeconds <= 0) {
                clearInterval(timerInterval);
                timerDisplay.textContent = "00:00:00";
                startBtn.textContent = "Finished";
                startBtn.disabled = true;
                return;
            }

            totalSeconds--;

            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            timerDisplay.textContent = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
        }

        function startCountdown() {
            if (!running) {
                timerInterval = setInterval(updateTimer, 1000);
                startBtn.textContent = "Running...";
                startBtn.disabled = true;
                running = true;
            }
        }
    </script>

</body>
</html>
