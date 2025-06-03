@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{ asset('css/miner.css') }}"></link>
 @section('content')
<div class="main shear_Class min_miner">
<link rel="stylesheet" href="{{ asset('css/index.css') }}"></link>
  <div class="slider-container">
        <div class="slides" id="slideWrapper">
            <div class="slide"><img src="{{('asset/one.jpg')}}" alt=""></div>
            <div class="slide"><img src="{{('asset/one.jpg')}}" alt=""></div>
            <div class="slide"><img src="{{('asset/one.jpg')}}" alt=""></div>
            <div class="slide"><img src="{{('asset/one.jpg')}}" alt=""></div>
        </div>
        <div class="controls">
            <button class="btn" onclick="moveSlide(-1)">&#10094;</button>
            <button class="btn" onclick="moveSlide(1)">&#10095;</button>
        </div>
    </div>
     <h2 id="startBtn" class="TitleMinner">MINING STOPPED</h2>
<div class="BoxFirsthashes">
    <div class="timer-box">
        <div class="start-btn" onclick="startMining()">START</div>
        <div class="timer" id="timer">24:00:00</div>
        <!-- <button class="start-btn" onclick="startCountdown()" id="startBtn">Start Countdown</button> -->
    </div>
    <div >
    <div class="hash-counter" id="hashes">0.00000 Hashes</div>
</div>
</div>
<hr/>
<div class="BoxFirsthashes newJashes">
   <!-- Exchange Section -->
    <div class="Current_balance">
        <span><strong>Mined Hashes : </strong> <span class="minedHashe" id="minedHashes">0.00000</span></span>
     </div>
       <button class="btn btn-primary ex_Change" onclick="showExchangeModal()">↔</button>
        <div class="Current_balance editBalance">
         <span>Current balance:
             <span class="minedHashe" id="currentBalance">{{ number_format($user->balance, 2) }}</span> FMT
            </span>
    </div>
</div>
<div class="BoxFirsthashes unBoxFirsthashes ">
     <div class="minedHashe Power_sale ">
      <strong>Power sale 🎁</strong>   <br>
        Time left: <span id="countdown">86h 48m 05s</span>
    </div>
 <div class="minedHashe power-box">
        <strong>Current power</strong><br>
        @php
    $basePower = 1000;
    $totalPower = $basePower + $user->gpu_power;
@endphp
<p>{{ number_format($totalPower) }} GPU</p>
     </div>
</div>
<button type="submit" class="Send_button sendExchangehash">Buy power in the store 🛒</button>
</div>

 Exchange Modal
 <div id="exchangeModal" class="custom-modal">
    <div class="modal-box">
        <h4>Exchange Confirmation</h4>
        <p id="modalMessage"></p>
        <div class="modal-buttons">
         <button class="btn btn-success" onclick="confirmExchange()">Confirm</button>
         <button class="btn btn-secondary" onclick="closeExchangeModal()">Cancel</button>
        </div>
    </div>
</div>
@endsection
  @push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
let mining = false;
let hashes = 0;
let interval;
const incrementRate = 0.00001;
const updateInterval = 50;
function startMining() {
    startCountdown()
    if (mining) return;
    mining = true;
    document.getElementById('startBtn').innerText = 'MINING STARTED';
    document.getElementById('startBtn').style.color = '#00c3ff';
    document.getElementById('hashes').style.color = '#00c3ff';
    interval = setInterval(() => {
        hashes += incrementRate;
        const display = hashes.toFixed(5);
        document.getElementById('hashes').innerText = display + ' Hashes';
        document.getElementById('minedHashes').innerText = display;
            document.getElementById('minedHashes').style.color = '#00c3ff';
            document.getElementById('minedHashes').style.fontWeight = 'bolder';
    }, updateInterval);
}
function showExchangeModal() {
    if (hashes < 3) {
        // لا يسمح بالتبادل إذا أقل من 3 hashes
        alert('You need at least 3 hashes to exchange.');
        return;
    }
    const rate = 100;
    const currentHashes = parseFloat(hashes.toFixed(5));
    const fmt = (currentHashes / rate).toFixed(5);
    const message = `
Your result: ${currentHashes} hashes
Exchange rate: ${rate} hashes = 1 FMT
You will receive: ${fmt} FMT

Proceed with the exchange?
`;
    document.getElementById('modalMessage').innerText = message;
    document.getElementById('exchangeModal').style.display = 'flex';
}
function closeExchangeModal() {
    document.getElementById('exchangeModal').style.display = 'none';
}
function confirmExchange() {
    const currentHashes = parseFloat(hashes.toFixed(5));
    fetch('{{ route("exchange.hashes") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ hashes: currentHashes })
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        }
        else if (data.balance !== undefined) {
            document.getElementById('currentBalance').innerText = parseFloat(data.balance).toFixed(2);
            hashes = 0;
            document.getElementById('hashes').innerText = '0.00000 Hashes';
            document.getElementById('minedHashes').innerText = '0.00000';
        }
        closeExchangeModal();
    })
    .catch(error => {
        console.error('Exchange failed:', error);
        closeExchangeModal();
    });
}
</script>
    <script>
        let currentIndex = 0;
        const wrapper = document.getElementById("slideWrapper");
        const totalSlides = wrapper.children.length;
        function moveSlide(direction) {
            currentIndex += direction;

            if (currentIndex < 0) currentIndex = totalSlides - 1;
            if (currentIndex >= totalSlides) currentIndex = 0;

            wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
        }
    </script>
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
@endpush
