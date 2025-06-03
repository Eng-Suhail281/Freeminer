@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/promoCode.css') }}"></link>

@section('content')
<div class="create_codess">

<div class="create_codes">
    <h2 class="mb-4 text-center">➕ إنشاء كود ترويجي جديد</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.promo-codes.store') }}" method="POST" class="boxProwCode">
        @csrf

        {{-- بيانات الكود --}}
        <div class="details_promo">
            <label class="form-label">🔑 كود الترويج</label>
            <input type="text" name="code" class="form_createPromo" required>
        </div>
        <div class="details_promo">
            <label class="form-label">📝 الوصف (اختياري)</label>
            <textarea name="description" class="form_createPromo textPromo" rows="2"></textarea>
        </div>
        <div class="details_promo">
        <label for="wallet_address" class="form-label">عنوان المحفظة</label>
        <input type="text" id="wallet_address" name="wallet_address" class="form_createPromo">
    </div>


        <hr class="my-4">
        {{-- بيانات المؤثر --}}
        <h3 class="infoDetails">بيانات المؤثر</h3>
        <div class="details_promo">
            <label class="form-label">اسم المستخدم (Username)</label>
            <input type="text" name="influencer_name" class="form_createPromo" required>
        </div>
        <div class="details_promo">
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="influencer_email" class="form_createPromo" required>
        </div>
        <div class="details_promo">
            <label class="form-label">كلمة المرور</label>
            <input type="password" name="influencer_password" class="form_createPromo" required>
        </div>

        <div class="details_promo">
            <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary">🔙 العودة</a>
            <button type="submit" class="buttons_promo copy_promo">✅ إنشاء الكود والمؤثر</button>
        </div>
    </form>
</div>
</div>

@endsection
