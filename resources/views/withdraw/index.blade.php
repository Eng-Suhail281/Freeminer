@extends('layouts.app')

@push('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1e1e1e;
            color: white;
        }
        .header {
            background-color: #2d3b47;
            padding: 20px;
            text-align: center;
        }
        .header button {
            background-color: #ff6a00;
            border: none;
            padding: 10px 20px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .main-content {
            padding: 20px;
            text-align: center;
        }

        .withdraw-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .withdraw-option {
            background-color: #333;
            border: none;
            padding: 15px;
            width: 140px;
            height: 150px;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .withdraw-option:hover {
            background-color: #444;
        }

        .withdraw-option img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .withdraw-option p {
            margin: 0;
            font-size: 16px;
        }

        a {
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
    <div class="header">
        <p>Pay using the balance to increase power and receive a bonus +5%</p>
        <button>MORE DETAILS</button>
    </div>

    <div class="main-content">
        <h2>Withdraw funds</h2>
        <p>Choose a withdrawal method:</p>

        <!-- Select Method -->
        <div class="withdraw-options">
            <a href="{{ route('withdraw.form', ['method' => 'tron']) }}">
                <button class="withdraw-option">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Tron_logo.svg" alt="TRON">
                    <p>TRON</p>
                </button>
            </a>
            <a href="{{ route('withdraw.form', ['method' => 'bnb']) }}">
                <button class="withdraw-option">
                    <img src="https://cryptologos.cc/logos/binance-coin-bnb-logo.svg" alt="BNB">
                    <p>BNB</p>
                </button>
            </a>
            <a href="{{ route('withdraw.form', ['method' => 'ton']) }}">
                <button class="withdraw-option">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f8/Ton_Coin_logo.svg" alt="TON Coin">
                    <p>TON</p>
                </button>
            </a>
            <a href="{{ route('withdraw.form', ['method' => 'litecoin']) }}">
                <button class="withdraw-option">
                    <img src="https://cryptologos.cc/logos/litecoin-ltc-logo.svg" alt="Litecoin">
                    <p>Litecoin</p>
                </button>
            </a>
        </div>
    </div>

    @include('layouts.footer')
@endsection
