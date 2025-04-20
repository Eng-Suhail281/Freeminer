@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-5 text-center">📝 الرسائل التي تم الرد عليها</h1>
    {{-- زر العودة --}}
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-4">⬅️ العودة إلى لوحة التحكم</a>
    
    @foreach($closedTickets as $ticket)
        <div class="card mb-4 border-success shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <strong>🎫 تذكرة من: {{ $ticket->telegram_id }}</strong>
                <span class="badge bg-success">تم الرد</span>
            </div>
            <div class="card-body">
                <h5 class="card-title mb-3">📌 {{ $ticket->subject }}</h5>
                <p><strong>💬 الرسالة:</strong> {{ $ticket->message }}</p>
                <p><strong>🕒 أُرسلت بتاريخ:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
                <div class="alert alert-secondary mt-3">
                    <strong>📢 الرد:</strong> {{ $ticket->reply }}
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
