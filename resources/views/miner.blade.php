@extends('layouts.app')

@section('content')
<div class="main">
    <h2 id="mining-status" style="color:red;">MINING STOPPED</h2>
    <div class="start-btn" onclick="startMining()">START</div>

    <div class="hash-counter" id="hashes">0.00000 Hashes</div>

    <!-- Exchange Section -->
    <div class="exchange-section" style="margin:20px 0; padding:10px; border:1px solid #ccc; border-radius:8px;">
        <p><strong>Mined Hashes:</strong> <span id="minedHashes">0.00000</span></p>
        <button class="btn btn-primary" onclick="showExchangeModal()">Exchange ↔</button>
        <p><strong>Current balance:</strong>
           <span id="currentBalance">{{ number_format($user->balance, 2) }}</span> FMT
        </p>
    </div>

    <div style="background:green; padding:10px; border-radius:10px;">
        Power sale 🎁 <br>
        Time left: <span id="countdown">86h 48m 05s</span>
    </div>

    <div class="power-box">
        <strong>Current power</strong><br>
        @php
    $basePower = 1000;
    $totalPower = $basePower + $user->gpu_power;
@endphp
<p>{{ number_format($totalPower) }} GPU</p>
        <button>Buy power in the store 🛒</button>
    </div>
</div>

<!-- Exchange Modal -->
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

@push('styles')
<style>
.custom-modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-box {
    background: #fff;
    padding: 25px 20px;
    border-radius: 12px;
    width: 90%;
    max-width: 360px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    text-align: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.modal-box h4 {
    margin-bottom: 15px;
    color: #222;
    font-size: 18px;
    font-weight: bold;
}

#modalMessage {
    color: #444;
    font-size: 14px;
    margin-top: 10px;
    white-space: pre-line;
    line-height: 1.6;
}

.modal-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.modal-buttons .btn {
    width: 48%;
}
</style>
@endpush

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let mining = false;
let hashes = 0;
let interval;
const incrementRate = 0.00001;
const updateInterval = 50;

function startMining() {
    if (mining) return;
    mining = true;
    document.getElementById('mining-status').innerText = 'MINING STARTED';
    document.getElementById('mining-status').style.color = 'green';

    interval = setInterval(() => {
        hashes += incrementRate;
        const display = hashes.toFixed(5);
        document.getElementById('hashes').innerText = display + ' Hashes';
        document.getElementById('minedHashes').innerText = display;
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
@endpush
