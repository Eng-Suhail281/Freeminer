let mining = false;
let hashes = parseInt(document.getElementById("hashes").innerText);
let sessionHashes = 0;
let miningStartTime = null;
let sessionTimer = 8 * 60 * 60 * 1000; // 8 ساعات
let miningInterval;
let updateInterval;
let miningEndTime;
let userTelegramId = document.getElementById("userTelegramId").value;
const currentRate = 0.01; // لا تُغير هذا هنا

function startMining() {
    if (mining) return;
    mining = true;
    miningStartTime = Date.now();
    miningEndTime = miningStartTime + sessionTimer;

    document.getElementById("startMiningBtn").style.display = "none";
    document.getElementById("stopMiningBtn").style.display = "inline-block";
    document.getElementById("miningStatus").innerText = "Mining in progress...";

    miningInterval = setInterval(() => {
        sessionHashes++;
        updateHashDisplay();
    }, 500); // تقليل السرعة ×100

    updateInterval = setInterval(() => {
        updateDisplay();
        checkSessionTimeout();
    }, 1000);

    saveMiningSession("start");
}

function stopMining() {
    mining = false;
    clearInterval(miningInterval);
    clearInterval(updateInterval);

    document.getElementById("startMiningBtn").style.display = "inline-block";
    document.getElementById("stopMiningBtn").style.display = "none";
    document.getElementById("miningStatus").innerText = "Mining stopped.";

    saveMiningSession("stop");
}

function updateHashDisplay() {
    const totalHashes = hashes + sessionHashes;
    document.getElementById("hashes").innerText = totalHashes;
    const fmtAmount = (totalHashes / 100).toFixed(2);
    document.getElementById("fmt").innerText = fmtAmount;
}

function updateDisplay() {
    const timeRemaining = miningEndTime - Date.now();
    const seconds = Math.max(0, Math.floor(timeRemaining / 1000));
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = seconds % 60;

    document.getElementById("sessionCountdown").innerText = `${hours}h ${minutes}m ${secs}s`;
}

function checkSessionTimeout() {
    if (Date.now() >= miningEndTime) {
        stopMining();
        alert("Your mining session has ended (8 hours). Please start a new one.");
    }
}

function convertHashes() {
    const totalHashes = hashes + sessionHashes;
    if (totalHashes < 3) {
        alert("You need at least 3 hashes to convert.");
        return;
    }

    fetch('/user/convert-hashes', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute("content"),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            telegram_id: userTelegramId,
            hashes: sessionHashes,
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Hashes converted successfully.");
            window.location.reload();
        } else {
            alert("Conversion failed.");
        }
    });
}

function saveMiningSession(state) {
    fetch('/user/save-session', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute("content"),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            telegram_id: userTelegramId,
            state: state,
            session_hashes: sessionHashes,
        })
    });
}

document.getElementById("startMiningBtn").addEventListener("click", startMining);
document.getElementById("stopMiningBtn").addEventListener("click", stopMining);
document.getElementById("convertButton").addEventListener("click", convertHashes);
