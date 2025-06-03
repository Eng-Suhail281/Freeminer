@extends('layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<link rel="stylesheet" href="{{ asset('css/promoCode.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('css/deposit.css') }}">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endpush

@section('content')
    @php
        $fixedRates = [
            'tron' => 0.036555,    // 1 FMT
            'ton' => 0.00341111,      // 1 FMT
            'litecoin' => 0.00010288,  // 1 FMT
            'bnb' => 0.00001479       // 1 FMT
        ];
    @endphp
 <div class="Card_cntent">

     <form class="boxProwCode doposite_box wither_box" method="POST" action="{{ route('withdraw.submit', ['method' => 'tron']) }}" id="withdraw-form">
        <h1>سحب الرصيد</h1>
        @csrf
 <div class="details_promo">
    <label class="form-label" for="amount">رصيدك الحالي:
</label>
<strong class="strong_balance">{{ $balance }} FMT</strong>        </div>
        <div class="details_promo">
            <label for="method" class="form-label">اختر طريقة الدفع
             </label>
 <div class="form_createPromo">
                  <p class="select_option">
                <select id="method" name="method" class="form_createPromo" required>
                    <option value="">إختر طريقة الدفع</option>
                    <option value="tron">TRON</option>
                    <option value="bnb">BNB</option>
                    <option value="ton">TON Coin</option>
                    <option value="litecoin">Litecoin</option>
                </select></p>
</div>        </div>

 <div class="details_promo">
    <label class="form-label" for="amount">مبلغ السحب (بالـ FMT)</label>
       <input type="text" name="amount" id="amount"   min="1" max="{{ $balance }}"   class="form_createPromo" required>
        </div>
 <div class="details_promo">
    <label class="form-label" for="amount">مبلغ الاستلام</label>
                <div id="converted-amount" class="form_createPromo strong_balance">-------------------</div>
        </div>
        <div class="details_promo">
            <label for="wallet_address" class="form-label">عنوان المحفظة</label>
            <textarea value=   name="wallet_address" id="wallet_address"  class="form_createPromo textPromo" required rows="2"></textarea>
        </div>
              <button type="submit" class="buttons_promo copy_promo doposit_now"> تنفيذ السحب</button>
        </div>
        @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }} fsvndsjkv</div>
        @endif

        @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }} fsvndfsvndsjkvfsvndsjkvsjkv</div>

        @endif
    </form>
</div>
</div>


<script>
    const balance = {{ $balance }};
    const fixedRates = @json($fixedRates);

    document.getElementById('method').addEventListener('change', updateConvertedAmount);
    document.getElementById('amount').addEventListener('input', updateConvertedAmount);

    function updateConvertedAmount() {
        const method = document.getElementById('method').value;
        const fmtAmount = parseFloat(document.getElementById('amount').value) || 0;

        if (!method) {
            document.getElementById('converted-amount').innerText = '--';
            return;
        }

        if (fmtAmount > balance) {
            document.getElementById('converted-amount').innerText = `⚠️ لا يمكنك سحب أكثر من رصيدك (${balance} FMT)`;
            return;
        }

        const rate = fixedRates[method];
        if (!rate) {
            document.getElementById('converted-amount').innerText = '--';
            return;
        }

        const converted = fmtAmount * rate;
        document.getElementById('converted-amount').innerText = `${converted.toFixed(6)} ${method.toUpperCase()}`;
    }

    document.getElementById('withdraw-form').addEventListener('submit', function (e) {
        const method = document.getElementById('method').value;
        if (!method) {
            alert('يرجى اختيار طريقة السحب.');
            e.preventDefault();
            return;
        }
        this.action = `/withdraw/submit/${method}`;
    });
</script>
@if (session('success'))
<script>
  Toastify({
    text: "{{ session('success') }}",
    duration: 3000,
    close: true,
    gravity: "top",
    position: "right",
    backgroundColor: "#4CAF50",
    stopOnFocus: true,
  }).showToast();
</script>

@endif
@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
            Toastify({
                text: "{{ $error }}",
                duration: 4000,
                gravity: "top",
                position: "right",
                backgroundColor: "#f44336",
                close: true,
            }).showToast();
        @endforeach
    </script>
@endif

@endsection
