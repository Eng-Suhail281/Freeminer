<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link  href="{{ asset('css/index.css') }}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Free Miner</title>
    <style>
        i {
    font-size: 20px;

}
   a {   color: #fff;  text-decoration: none ;}
        body { font-family: sans-serif; background: #000; color: #fff; text-align: center; margin: 0; padding: 0; display: flex; flex-direction: column; /* التأكد من ترتيب العناصر عمودياً */}
        .header { display: flex; justify-content: space-between; padding: 10px; background: #111; width: 100%; /* التأكد من أن الهيدر يغطي العرض بالكامل */ }
        .balance { background: #222; padding: 5px 10px; border-radius: 10px; }
        .main { margin-top: 20px; flex-grow: 1; /* التأكد من أن المحتوى الرئيسي يأخذ المساحة المتاحة */}
         /* .hash-counter { font-size: 24px; background: #222; padding: 10px; margin: 20px auto; width: 150px; border-radius: 10px; } */
         .bottom-nav { border-top-left-radius: 40px;    width: 700px;
border-top-right-radius: 40px;  padding: .8rem 0;position: absolute;width: 100%;
            ; bottom: 0;  background: #222; display: flex; justify-content: space-around;}

    </style>

    @stack('styles')
</head>
<body>

<script async src="https://telegram.org/js/telegram-web-app.js"></script>
<script>
    const tg = window.Telegram.WebApp;
    tg.expand();

    const initData = tg.initDataUnsafe;

    fetch("/auth/telegram", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            telegram_id: initData.user?.id,
            first_name: initData.user?.first_name,
            last_name: initData.user?.last_name,
            username: initData.user?.username,
            photo_url: initData.user?.photo_url,
        })
    });
</script>



    <!-- <script>
        // Always wait 60 seconds before showing the main app
        setTimeout(function () {
            document.getElementById('loading-screen').style.display = 'none';
            document.getElementById('main_body').style.display = 'flex';
        }, 6000); // 60,000 milliseconds = 60 seconds
    </script> -->

<main class="main_body" id="main_body">
    <main class="shear_Class back_min_miner">
        @include('layouts.header')
        @yield('content')

    </main>
</main>


@stack('scripts')

</body>
</html>
