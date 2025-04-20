@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>{{ $ticket->subject }}</h2>
    <hr>

    <div class="mb-4">
        <h5>Your Message:</h5>
        <p>{{ $ticket->message }}</p>
    </div>

    @if($ticket->reply)
        <div class="alert alert-success">
            <strong>Admin Reply:</strong><br>
            {{ $ticket->reply }}
        </div>
    @else
        <p class="text-muted">No reply yet.</p>
    @endif

    <a href="{{ route('support.index') }}" class="btn btn-secondary mt-3">Back to Tickets</a>
</div>
@endsection
