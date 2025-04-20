@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-5 text-center">👥 قائمة المستخدمين</h1>
    {{-- زر العودة --}}
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-4">⬅️ العودة إلى لوحة التحكم</a>

    @foreach($users as $user)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
                <strong>مستخدم: {{ $user->username }} (ID: {{ $user->telegram_id }})</strong>
            </div>
            <div class="card-body">
                <p><strong>💰 الإيداع الكلي:</strong> {{ $user->payments->sum('amount') }} FMT</p>
                <p><strong>⚡ الطاقة المتاحة:</strong> {{ $user->balance }} GPU</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
