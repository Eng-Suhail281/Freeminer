@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/promoCode.css') }}"></link>

@section('content')
<div class="create_codess">

<div class="create_codes">
    <h1>تعديل كود برومو</h1>

    <form action="{{ route('admin.promo-codes.update', $promoCode->id) }}" class="boxProwCode edit_Promo" method="POST">
        @csrf
        @method('PUT')

        <div class="details_promo">
            <label>الكود</label>
            <input type="text" name="code" value="{{ $promoCode->code }}" class="form_createPromo" required>
        </div>

        <div class="details_promo">
            <label>الوصف</label>
            <input type="text" name="description" value="{{ $promoCode->description }}" class="form_createPromo">
        </div>

        <div class="details_promo">
            <label>المكافأة</label>
            <input type="number" name="reward" value="{{ $promoCode->reward }}" class="form_createPromo" step="0.01" required>
        </div>

        <div class="details_promo">
            <label>نسبة العمولة</label>
            <input type="number" name="commission_rate" value="{{ $promoCode->commission_rate }}" class="form_createPromo" step="0.01" required>
        </div>

        <button type="submit" class="saveChanges">حفظ التعديلات</button>
        <a href="{{ route('admin.promo-codes.index') }}" class="back">رجوع</a>
    </form>
    </div>
    </div>


@endsection
