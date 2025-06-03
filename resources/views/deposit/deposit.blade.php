@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/deposit.css') }}">
@endpush
@section('content')

<div class="disposite_content">
<div class="cardfirst">
    <div class="some_text">
    <span class="PowerText"> Power Shop
    </span>
   <p class="sub_texxt">Enter the sum you want to use for buying mining power:</p>
    </div>
                <form id="depositForm" action="{{ route('deposit.handlePay') }}" method="POST">
    @csrf
    <div class="some_texts">
        <input class="number_usd"  type="number" id="amount" name="amount" placeholder="USD" required/>
<label for="amount" class="usd">USD</label>
    </div>

</div>
 <div class="Power_Sale">
 <h2>Power Sale</h2>
 <div class="power-sale">
             <div class="detalis_power"> <p >Purchase from $ 25:</p><p>   BONUS +25%</p> </div>
            <div class="detalis_power"> <p>Purchase from $ 25:</p><p>   BONUS +25%</p> </div>
            <div class="detalis_power"> <p>Purchase from $ 25:</p><p>   BONUS +25%</p> </div>
            <hr class="hr" />
            <div class="detalis_power"> <p>Purchase from $ 25:</p><p>   BONUS +25%</p> </div>
            <div class="detalis_power"> <p>Purchase from $ 25:</p><p>   BONUS +25%</p> </div>

             <p class="time-left">TIME LEFT: 84 h. 59 min. 54 sec.</p>
        </div>
        </div>
         <div class="Power_Sale Shpos" id="powerCalculator">
 <h2>Power Shop</h2>
 <div class="power-sale">
             <div class="detalis_power"> <p >Power: </p><p id="power"> GPU</p> </div>
             <div class="detalis_power"> <p>BONUS for action:
                </p><p id="bonusText">    GPU</p> </div>
             <div class="detalis_power"> <p>Total power:
            </p><p id="totalPower">    GPU</p> </div>
            <hr class="hr" />

            <div class="detalis_power"> <p>Interest rate:
            </p><p>   1.92% Profit per day</p> </div>
             <div class="detalis_power"> <p>Profit per day:
            </p><p id="profitDay"> Hash</p> </div>
            <hr class="hr" />

              <div class="detalis_power"> <p>Profit per month:
            </p><p id="profitMonth">    Hash</p> </div>
            <div class="detalis_power"> <p>Profit over 6 months:  </p><p id="profit6Month"> Hash</p>
         </div>
<br />
   <p class="ChoosePay">Choose Payment Method  </p>

                 <div class="detalis_power">
                 <label for="method">Select Payment Method:</label>
                 <p>
                <select id="method" name="method" required>
                    <option value="">Choose Method</option>
                    <option value="usdt">USDT (TRC20)</option>
                    <option value="tron">TRON(TRX)</option>
                    <option value="bnb">BNB</option>
                    <option value="ton">TON Coin</option>
                    <option value="litecoin">Litecoin</option>
                </select></p>
</div>
<br />
           <!-- Telegram ID -->
                <input type="hidden" id="telegram_id" name="telegram_id" value="{{ $telegramId }}">
            <button type="submit" class="Send_button">Pay</button>
            </div>
        </div>
                    </form>
        <!-- <div class="some_texts machine" >
            <p>Next mining machine:  </p>
            <p>To unlock: 249 900 GPU</p>
            <button class="unlock-button" type="submit" >UNLOCK</button>
        </div> -->

        <!-- Power Shop Section -->

         </div>


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
    const bonus = document.getElementById('bonusText'); // fixed
    const totalPower = document.getElementById('totalPower');
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

