@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/deposit.css') }}">
@endpush

@section('content')
    <div class="container">

        <!-- Power Sale Section -->
        <div class="power-sale">
            <h2>Power Sale</h2>
            <p>Purchase from $ 25: BONUS +25%</p>
            <p>Purchase from $ 100: BONUS +50%</p>
            <p>Purchase from $ 500: BONUS +75%</p>
            <p>Purchase from $ 2000: BONUS +100%</p>
            <p class="time-left">TIME LEFT: 84 h. 59 min. 54 sec.</p>
        </div>

        <!-- Power Shop Section -->
        <div class="power-shop">
            <h3>Power Shop</h3>
            <form id="depositForm" method="GET">
                <label for="amount">Enter the amount (USD):</label>
                <input type="number" id="amount" name="amount" placeholder="USD" required>

                <!-- Power Calculator -->
                <div id="powerCalculator" class="power-calculator">
                    <h5>PROFIT CALCULATOR</h5>
                    <p>Power: <span id="power">0</span> GPU</p>
                    <p id="bonusText" class="bonus-text" style="display:none;">+25% Bonus: <span id="bonus">0</span> GPU</p>
                    <p>Total power: <span id="totalPower">0</span> GPU</p>
                    <hr>
                    <p>Interest rate: 1.92% Profit per day</p>
                    <p>Profit per day: <span id="profitDay">0</span> Hash</p>
                    <p>Profit per month: <span id="profitMonth">0</span> Hash</p>
                    <p>Profit over 6 months: <span id="profit6Month">0</span> Hash</p>
                </div>

                <!-- اختيار طريقة الدفع -->
                <label for="method">Select Payment Method:</label>
                <select id="method" name="method" required>
                    <option value="">-- Choose Method --</option>
                    <option value="tron">TRON</option>
                    <option value="bnb">BNB</option>
                    <option value="ton">TON Coin</option>
                    <option value="litecoin">Litecoin</option>
                </select>

                <!-- Telegram ID -->
                <input type="hidden" id="telegram_id" name="telegram_id" value="{{ $telegramId }}">

                <button type="submit" class="pay-button">Pay</button>
            </form>
        </div>

        <!-- Next Mining Machine Section -->
        <div class="next-mining-machine">
            <p>Next mining machine: To unlock: 249 900 GPU</p>
            <button class="unlock-button">UNLOCK</button>
        </div>

        <!-- Footer Info -->
        <div class="footer-info">
            <p>@MineFast_bot</p>
        </div>

    </div>
@endsection

@push('scripts')
<script>
    // هل هذا أول إيداع؟ (مؤقتًا = true، لاحقًا نرسله من السيرفر)
    const isFirstDeposit = true;

    function updateCalculator() {
        const amountInput = document.getElementById('amount');
        const power = document.getElementById('power');
        const bonus = document.getElementById('bonus');
        const totalPower = document.getElementById('totalPower');
        const bonusText = document.getElementById('bonusText');
        const profitDay = document.getElementById('profitDay');
        const profitMonth = document.getElementById('profitMonth');
        const profit6Month = document.getElementById('profit6Month');

        const amount = parseFloat(amountInput.value) || 0;
        const basePower = amount * 10000;
        const bonusPower = isFirstDeposit ? basePower * 0.25 : 0;
        const total = basePower + bonusPower;
        const dailyProfit = total * 0.0192;

        power.textContent = basePower.toLocaleString();
        bonus.textContent = bonusPower.toLocaleString();
        totalPower.textContent = total.toLocaleString();

        profitDay.textContent = Math.floor(dailyProfit).toLocaleString();
        profitMonth.textContent = Math.floor(dailyProfit * 30).toLocaleString();
        profit6Month.textContent = Math.floor(dailyProfit * 180).toLocaleString();

        bonusText.style.display = isFirstDeposit ? 'block' : 'none';
    }

    document.getElementById('amount').addEventListener('input', updateCalculator);
    document.addEventListener('DOMContentLoaded', updateCalculator);

    document.getElementById('depositForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const method = document.getElementById('method').value;
        const amount = document.getElementById('amount').value;
        const telegramId = document.getElementById('telegram_id').value;

        if (!method || !amount) {
            alert('Please enter amount and select a payment method.');
            return;
        }

        const url = `/deposit/form/${method}?amount=${amount}&telegram_id=${telegramId}`;
        window.location.href = url;
    });
</script>
@endpush
