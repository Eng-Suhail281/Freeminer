@extends('layouts.app')

@section('content')
    <div class="header">
        <p>Withdrawal request submitted successfully!</p>
    </div>

    <div class="main-content">
        <h2>Success!</h2>
        <p>Your withdrawal request has been successfully submitted and is being processed.</p>

        <a href="{{ route('withdraw.index') }}" class="btn btn-primary">Back to Withdraw</a>
    </div>

    @include('layouts.footer')
@endsection
