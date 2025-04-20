@extends('layouts.app')

@section('content')
    <div class="header">
        <p>Withdraw your funds using {{ strtoupper($method) }}.</p>
    </div>

    <div class="main-content">
        <h2>Withdraw {{ strtoupper($method) }} Funds</h2>

        <form action="{{ route('withdraw.submit', ['method' => $method]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="amount">Amount ({{ strtoupper($method) }})</label>
                <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" min="1" required>
            </div>

            <div class="form-group">
                <label for="wallet_address">Wallet Address</label>
                <input type="text" name="wallet_address" id="wallet_address" class="form-control" value="{{ old('wallet_address') }}" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit Withdrawal Request</button>
            </div>
        </form>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>

    @include('layouts.footer')
@endsection
