@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">👥 المستخدمون المرتبطون بالكود: {{ $promoCode->code }}</h1>

    <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary mb-3">
        ⬅️ رجوع إلى قائمة الأكواد
    </a>

    @if($promoCode->users->count())
        <div class="row">
            @foreach($promoCode->users as $user)
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>{{ $user->username ?? '—' }}</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>🆔 تيليجرام ID:</strong> {{ $user->telegram_id }}</p>
                            <p>
                                <strong>💰 مبلغ الإيداع:</strong><br>
                                {{ number_format($user->deposit_amount ?? 0, 2) }} USD
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning text-center">
            لا يوجد مستخدمون مرتبطون بهذا الكود بعد.
        </div>
    @endif
</div>
@endsection
