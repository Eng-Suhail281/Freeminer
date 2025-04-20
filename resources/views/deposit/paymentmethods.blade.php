@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Select Payment Method</h2>

        <div class="payment-methods">
            <a href="{{ route('deposit.form', ['method' => 'tron']) }}">
                <button class="payment-method">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Tron_logo.svg" alt="TRON">
                    <p>TRON</p>
                </button>
            </a>
            <a href="{{ route('deposit.form', ['method' => 'bnb']) }}">
                <button class="payment-method">
                    <img src="https://cryptologos.cc/logos/binance-coin-bnb-logo.svg" alt="BNB">
                    <p>BNB</p>
                </button>
            </a>
            <a href="{{ route('deposit.form', ['method' => 'ton']) }}">
                <button class="payment-method">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f8/Ton_Coin_logo.svg" alt="TON Coin">
                    <p>TON Coin</p>
                </button>
            </a>
            <a href="{{ route('deposit.form', ['method' => 'litecoin']) }}">
                <button class="payment-method">
                    <img src="https://cryptologos.cc/logos/litecoin-ltc-logo.svg" alt="Litecoin">
                    <p>Litecoin</p>
                </button>
            </a>
            <!-- Add more payment methods here -->
        </div>
    </div>
@endsection
