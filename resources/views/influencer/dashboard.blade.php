<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة المؤثر</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
     <link  href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

            <link rel="stylesheet" href="{{ asset('css/influencer.css') }}"></link>
            <link rel="stylesheet" href="{{ asset('css/promoCode.css') }}"></link>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"></link>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<main class="main_body" id="main_body">
    <main class="shear_Class back_min_miner">

        <div class="headr_info">
             <div class="content_Profiles">
                 <i class="bi bi-person-square person"></i>
                         <h4 class="name_info">{{ $influencer->name }}
                         </h4>
        </div>
        <div>

             <a href="{{ route('influencer.logout') }}" class="btn btn-outline-danger logout">تسجيل الخروج</a>
        </div>
        </div>        <div class="promoCode">


        <div class="boxProwCode new_info">
            <div class="card-body">
            <h5 class="card_title">إحصائيات الكود: <strong>{{ $promoCode->code }}</strong></h5>
                <div class="details_promo"><p>الوصف:</p> {{ $promoCode->description ?? 'لا يوجد' }}</div>
                <div class="details_promo"><p>عدد المستخدمين:</p> {{ $totalUsers }}</div>
                <div class="details_promo"><p>عدد من أودعوا:</p> {{ $depositUsers }}</div>
                <div class="details_promo"><p>مجموع الإيداعات:</p> ${{ number_format($totalDepositAmount, 2) }}</div>
            </div>
        </div>

        <div class="boxProwCode new_info">
            <div class="card-body">
                <h5 class="details_promo">العمولة المكتسبة <p>{{ number_format($promoCode->commission_earned, 2) }} $</p></h5>
                 <div class="details_promo">المبلغ المتاح للسحب <p>{{ number_format($promoCode->commission_available, 2) }} $</p></div>

                @if ($promoCode->commission_available > 0)
                    <form action="{{ route('influencer.withdraw') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-3">سحب {{ number_format($promoCode->commission_available, 2) }}$</button>
                    </form>
                @else
                    <p class="no_many">لا يوجد مبلغ متاح للسحب حالياً.</p>
                @endif
            </div>
        </div>

        @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

        <div class="boxProwCode new_info">
<div class="details_infos">

    <label for="promo-link" class="form_labels"> الرابط الخاص بك  </label>
    <div class="flex-item info_link">
        <input id="promo-link" type="text" class="form_control input_info" readonly value="{{ url('/?ref=' . $promoCode->code) }}" class="form-control" onclick="this.select(); document.execCommand('copy');" style="cursor: pointer;">
        <button class="copy_links_info">اضغط لنسخ الرابط</button>
    </div>
</div>
                </div>
                </div>




            </main>
        </main>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    </body>

    </html>
