@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4 text-center" style="max-width: 500px; width: 100%;">
        <div class="text-danger mb-3">
            <i class="bi bi-x-circle-fill" style="font-size: 4rem;"></i>
        </div>
        <h3 class="mb-3">تم إلغاء الدفع ❌</h3>
        <p class="text-muted">يبدو أنك قمت بإلغاء العملية. لا بأس! يمكنك المحاولة من جديد.</p>
        <a href="{{ route('deposit.deposit') }}" class="btn btn-outline-danger mt-3">العودة إلى صفحة الإيداع</a>
    </div>
</div>
@endsection
