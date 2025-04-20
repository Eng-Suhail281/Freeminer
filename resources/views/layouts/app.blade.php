<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Free Miner</title>
    <style>
        body { font-family: sans-serif; background: #000; color: #fff; text-align: center; margin: 0; padding: 0; display: flex; flex-direction: column; /* التأكد من ترتيب العناصر عمودياً */}
        .header { display: flex; justify-content: space-between; padding: 10px; background: #111; width: 100%; /* التأكد من أن الهيدر يغطي العرض بالكامل */ }
        .balance { background: #222; padding: 5px 10px; border-radius: 10px; }
        .main { margin-top: 20px; flex-grow: 1; /* التأكد من أن المحتوى الرئيسي يأخذ المساحة المتاحة */}
        .start-btn { font-size: 30px; color: red; margin-top: 30px; cursor: pointer; }
        .hash-counter { font-size: 24px; background: #222; padding: 10px; margin: 20px auto; width: 150px; border-radius: 10px; }
        .power-box { background: #111; padding: 15px; margin: 10px auto; width: 80%; border-radius: 15px; }
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: #222; display: flex; justify-content: space-around; padding: 10px; }
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



@include('layouts.header')

<main>
    @yield('content')
</main>

@include('layouts.footer')

@stack('scripts')

</body>
</html>
