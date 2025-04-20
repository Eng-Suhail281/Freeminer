@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4 text-center" style="max-width: 500px; width: 100%;">
        <div class="text-success mb-3">
            <i class="bi bi-check-circle-fill" style="font-size: 4rem;"></i>
        </div>
        <h3 class="mb-3">تم الدفع بنجاح ✅</h3>
        <p class="text-muted">شكراً لك، تم استلام دفعتك بنجاح وسيتم تفعيل قوة التعدين قريباً.</p>
        <a href="{{ url('/') }}" class="btn btn-outline-success mt-3">العودة إلى الصفحة الرئيسية</a>
    </div>
</div>
@endsection
