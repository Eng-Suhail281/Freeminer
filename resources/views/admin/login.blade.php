
<!DOCTYPE html>
<body lang="ar">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('css/earn.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}"></link>

      <title>تسجيل دخول الإدارة</title>
      <main class="main_body">
    <main class="shear_Class back_min_miner">
    <div class="back_min_miner Login">
        <div class="money-info contentLogin">
                 <div class="card_shadow">
                         <h1 class="">تسجيل دخول الإدارة</h1>
                        {{-- رسالة الخطأ --}}
                        @if(session('error'))
                            <div class="alert alert-danger text-center">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('admin.login.submit') }}">
                            @csrf

                            <div class="firts_section">
                            <label for="email" class="form_label">البريد الإلكتروني</label>
                                 <input type="email" name="email" id="email" class="input_invite emals"
                                       value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="firts_section">
                                <label for="password" class="form_label">كلمة المرور</label>
                                <input type="password" name="password" id="password" class="input_invite emals" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <button type="submit" class="Send_button log_in">دخول</button>
                        </form>
                    </div>
             </div>
        </div>
    </div>    </main>
</main>


 </body>
