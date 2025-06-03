<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Bar</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>

    <div class="top-bar">
        <div class="top-bar-content">
             <div class="dropdown">
             <div class="language-flag">

    <a class="menu-icon">
    <i class="bi bi-list"></i>
    </a>

            <!-- Language Flag -->
            <div class="language-flag">
                <img src="{{('asset/flag.png')}}" alt="English" class="flag-img">
                <span>English</span>
            </div>
            </div>

    <div class="dropdown-menu">
    <a href="{{'/faq'}}">FAQ</a>

        <a href="{{ route('support.index') }}">Support</a>
        <a href="{{ route('user.transactions') }}">Transaction History</a>


        FAQ
    </div>
</div>
            <!-- <div class="menu-icon">
            <i class="bi bi-list"></i>
                 <i class="fas fa-bars"></i>
            </div> -->

            <!-- Dropdown Menu Trigger -->





            @php
    // إذا $user غير معرف أو فارغ، استعلم عن User::find(1)
    $user = $user ?? \App\Models\User::find(1);
@endphp
            <!-- Balance & Profile -->
             <div class="content_Profiles">
                    <!-- Deposit Button -->
            <form action="{{ route('deposit.deposit') }}" method="GET" style="display: inline;">
            <button type="submit" class="deposit-btn">Deposit</button>
            </form>
             <div class="balance-profile">
             <span class="bal_nce">Balance</span>

             <span class="balance-text"> {{ number_format($user->balance, 2) }} FMT</span>
              <!-- <img src="{{ asset('images/profile_pic.png') }}" alt="Profile" class="profile-img"> -->
            </div>
<i class="bi bi-person-square person"></i>

            </div>

        </div>
    </div>
    </div>


    <!-- Add your page content here -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
