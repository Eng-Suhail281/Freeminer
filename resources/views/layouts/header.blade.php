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
            <!-- Menu Icon -->
            <div class="menu-icon">
                <i class="fas fa-bars"></i>
            </div>

            <!-- Dropdown Menu Trigger -->
<div class="dropdown">
    <button class="menu-icon">
        <i class="fas fa-bars"></i>
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('support.index') }}">Support</a>
        <a href="{{ route('user.transactions') }}">Transaction History</a>
    </div>
</div>

            <!-- Language Flag -->
            <div class="language-flag">
                <img src="{{ asset('images/uk_flag.png') }}" alt="English" class="flag-img">
            </div>
            <!-- Deposit Button -->
            <form action="{{ route('deposit.deposit') }}" method="GET" style="display: inline;">
            <button type="submit" class="deposit-btn">Deposit</button>
            </form>

            
            @php
    // إذا $user غير معرف أو فارغ، استعلم عن User::find(1)
    $user = $user ?? \App\Models\User::find(1);
@endphp
            <!-- Balance & Profile -->
            <div class="balance-profile">
            <span class="balance-text">Balance {{ number_format($user->balance, 2) }} FMT</span>
                <img src="{{ asset('images/profile_pic.png') }}" alt="Profile" class="profile-img">
            </div>
        </div>
    </div>

    <!-- Add your page content here -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>