@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"></link>
<link rel="stylesheet" href="{{ asset('css/promoCode.css') }}"></link>

@endpush
@section('content')
<div class="create_codess">

<div class="create_codes">

    <div class="send_messages p-3 border rounded mx-auto" style="max-width:600px;">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.send_message') }}" class="boxProwCode">
    <h1 class="send_Title">🛠️ إرسال رسالة للمستخدمين</h1>

        @csrf
            <div class="details_promo">
                <label for="subject" class="form-label">الموضوع</label>
                <input type="text" name="subject" id="subject" class="form_createPromo" placeholder="اكتب موضوع الرسالة" required value="{{ old('subject') }}">
            </div>

            <div class="details_promo">
                <label for="message" class="form-label">نص الرسالة</label>
                <textarea name="message" id="message" rows="5" class="form_createPromo textPromo" placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
            </div>

                 <button type="submit" name="send_to" value="all" class="buttons_promo copy_promo send_all_item">إرسال لجميع المستخدمين</button>
                <button type="submit" name="send_to" value="depositors" class="buttons_promo copy_promo send_all_items">إرسال للمودعين فقط</button>
         </form>
    </div>
</div>
@endsection
