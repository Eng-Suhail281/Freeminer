@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-5 text-center">📬 الرسائل التي لم يتم الرد عليها</h1>
    {{-- زر العودة --}}
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-4">⬅️ العودة إلى لوحة التحكم</a>
    @foreach($openTickets as $ticket)
        <div class="card mb-4 border-warning shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <strong>🎫 تذكرة من: {{ $ticket->telegram_id }}</strong>
                <span class="badge bg-warning">مفتوحة</span>
            </div>
            <div class="card-body">
                <h5 class="card-title mb-3">📌 {{ $ticket->subject }}</h5>
                <p><strong>💬 الرسالة:</strong> {{ $ticket->message }}</p>
                <p><strong>🕒 أُرسلت بتاريخ:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</p>

                <form method="POST" action="{{ route('admin.support.reply', $ticket->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="reply" class="form-label">✍️ اكتب الرد:</label>
                        <textarea name="reply" class="form-control" rows="3" placeholder="اكتب الرد هنا..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">إرسال الرد</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
