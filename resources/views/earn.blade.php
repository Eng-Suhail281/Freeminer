@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/earn.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="card">
            <h1>Invite friends!</h1>
            <p>You and your friend will get bonuses</p>

            <div class="referral-link">
                <input type="text" id="referral-link" value="{{ $referral_link }}" readonly>
                <button class="share-btn" onclick="copyReferralLink()">Copy link</button>
            </div>

            <div class="money-info">
                <h2>Money for friends!</h2>
                <p>You will receive +200 GPU to your power for each user who comes through your unique link.</p>
                <p>Get 2,500 GPU for your friend's first deposit of any amount!</p>
                <p>You’ll receive an additional percentage of commissions from any spending made by the user on the project.</p>
                <button class="more-rewards-btn">More about rewards</button>
            </div>

            <div class="levels">
                <div class="level">
                    <span>Level 1</span>
                    <span>{{ $level1Count }} users</span> <!-- عرض عدد المستخدمين الذين جاءوا من خلال الرابط -->
                </div>
                <div class="level">
                    <span>Level 2</span>
                    <span>{{ $level2Count }} users</span>
                </div>
                <div class="level">
                    <span>Level 3</span>
                    <span>{{ $level3Count }} users</span>
                </div>
            </div>

            <div class="profile-commission">
                <div class="profile">
                    <span>Your referrals of 1 level:</span>
                    <span>{{ $level1Count }} referrals</span>
                </div>
                <div class="commission">
                    <span>Commission:</span>
                    <span>{{ number_format($commission) }}</span>
                </div>
            </div>

            <!-- Bottom Navigation -->
            @include('layouts.footer')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyReferralLink() {
            var copyText = document.getElementById("referral-link");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");
            alert("Referral link copied: " + copyText.value);
        }
    </script>
@endpush
