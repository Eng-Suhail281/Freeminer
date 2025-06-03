@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"></link>
<link rel="stylesheet" href="{{ asset('css/promoCode.css') }}"></link>

  @endpush
@section('content')
<div class="create_codess" >
    <h1 class="mb-5 text-center">🛠️ لوحة تحكم الإدارة</h1>
    <div class="rowBox">
         <div class="box_dashboard greens">
                 <div class="details_box">
                    <h4>إجمالي الإيداع</h4>
                    <p class="num textGreen">{{ $totalDeposits }} FMT</p>
                </div>
                <div class="box_icons">
            <i class="bi bi-disc-fill iconSizeBx"></i>

            </div>
         </div>
         <div class="box_dashboard ">
                 <div class="details_box">
                    <h4>التذاكر المفتوحة</h4>
                    <p class="num numBlue">{{ $openTickets->count() }} </p>
                </div>
                <div class="box_icons numBlues">
            <i class="bi bi-disc-fill iconSizeBx"></i>

            </div>
         </div>

         <div class="box_dashboard">
                 <div class="details_box">
                    <h4>عدد المستخدمين</h4>
                    <p class="num textRed">{{ $userCount }}</p>
                </div>
                <div class="box_icons boxRed">
            <i class="bi bi-disc-fill iconSizeBx"></i>

            </div>
         </div>

    </div>

    <div class="all_Sahow">

        <a href="{{ route('admin.support.open') }}" class="show_data">عرض الرسائل المفتوحة</a>
        <a href="{{ route('admin.support.closed') }}" class="show_data">عرض الرسائل التي تم الرد عليها</a>
        <a href="{{ route('admin.users') }}" class="show_data">عرض المستخدمين</a>
        <a href="{{ route('admin.promo-codes.index') }}" class="show_data">إدارة Promo Codes</a>
    <a href="{{ route('admin.send_message_form') }}" class="show_data">إرسال رسالة للمستخدمين</a>


    </div>

</div>
@endsection
