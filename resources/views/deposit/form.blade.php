@extends('layouts.app')

@push('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1e1e1e;
            color: white;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #333;
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            margin-bottom: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #444;
            color: white;
        }
        .wallet-info {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #ccc;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h2>Deposit via {{ ucfirst($method) }}</h2>

        <form action="{{ route('deposit.form', ['method' => $method]) }}" method="POST" id="deposit-form">
    @csrf

    <label for="amount">Amount (USD):</label>
    <input type="number" name="amount" id="amount" value="{{ $amount }}" readonly>

    <input type="hidden" name="telegram_id" value="{{ $telegram_id }}">

    <label for="wallet">Wallet Address:</label>
    <input type="text" id="wallet" value="{{ $walletAddress }}" readonly>

    <div class="wallet-info">
        <p>Your balance will be topped up automatically after the funds are received in the wallet.</p>
    </div>

    <button type="submit" class="pay-button">I Paid</button>
</form>

    </div>
@endsection

@php
    // هذه دالة مساعدة لإرجاع العنوان بناءً على طريقة الدفع
    function getWalletAddress($method) {
        $walletAddresses = [
            'tron' => 'TJBZV6vjkQv7gfZ5Qmn3PfUQwVpKH97YY7', // عنوان محفظة TRON
            'bnb' => 'bnb1vhqekmkz0gyfgfkhk3bkh4xpxenp3zqw2kx93d', // عنوان محفظة BNB
            'litecoin' => 'LZsGngJX9rxKxxZTdeEm4Y9hvU6nR9V94h', // عنوان محفظة Litecoin
            // أضف المزيد من العناوين هنا حسب طرق الدفع
        ];

        return $walletAddresses[$method] ?? 'Unknown wallet address'; // القيمة الافتراضية
    }
@endphp

@push('scripts')
    <script>
        // استخدام AJAX للتحديث التلقائي بعد الدفع
        document.getElementById('deposit-form').addEventListener('submit', function(event) {
            event.preventDefault(); // منع الإرسال العادي للنموذج

            // سيتم إرسال الطلب عبر AJAX لتحديث الرصيد
            let formData = new FormData(this);

            fetch("{{ route('deposit.submit', ['method' => $method]) }}", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // قم بتحديث الواجهة أو الرصيد هنا
                    alert('Payment successful! Your balance will be updated.');
                    // يمكنك تحديث الرصيد أو تغيير الصفحة إذا كنت بحاجة إلى ذلك
                } else {
                    alert('Payment failed! Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong!');
            });
        });
    </script>
@endpush
