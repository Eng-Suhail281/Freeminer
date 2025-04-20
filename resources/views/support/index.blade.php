@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="mb-4">Support</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('support.send') }}" method="POST">
        @csrf
        <div style="margin-bottom: 20px;">
            <label>Subject:</label><br>
            <input type="text" name="subject" style="width: 100%; max-width: 400px;">
        </div>
        <div style="margin-bottom: 20px;">
            <label>Message:</label><br>
            <textarea name="message" rows="4" style="width: 100%; max-width: 400px;"></textarea>
        </div>
        <button type="submit">Send</button>
    </form>
</div>

<!-- العنوان في المنتصف -->
<div class="container mt-5">
    <h4 class="text-center mb-3">Your Requests</h4>

    <!-- العناوين: Subject / Status -->
    <div class="d-flex justify-content-between px-2 mb-2" style="font-weight: bold;">
        <div>Subject</div>
        <div>Status</div>
    </div>

    <!-- عرض التذاكر -->
    @foreach($tickets as $ticket)
        <a href="{{ route('support.show', $ticket->id) }}" class="text-decoration-none text-dark">
            <div class="card mb-2 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center px-2">
                    <div>{{ $ticket->subject }}</div>
                    <div>
                        @if($ticket->reply)
                            <span class="badge bg-success">Closed</span>
                        @else
                            <span class="badge bg-warning text-dark">Open</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>

@endsection
