@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/earn.css') }}">
@endpush

@section('content')
    <div class="content_invite">
        <div class="card">
            <h1>Invite friends!</h1>
            <p class="text_small">You and your friend will get bonuses</p>
            <div class="referral-link">
                <div class="shearLinks">
                    <input type="text" id="referral-link" value="{{ $referral_link }}" class="input_invite" readonly>
                    <!-- <button class="share-btn" onclick="">Shear Link</button> -->
                </div>

                <button class="share-btn" onclick="copyReferralLink()">Copy link</button>
            </div>
            <div class="all_earn_count">
             <div class="money-info">
                <h2>Money for friends!</h2>
                <p>You will receive +200 GPU to your power for each user who comes through your unique link.</p>
                <p>Get 2,500 GPU for your friend's first deposit of any amount!</p>
                <p>You’ll receive an additional percentage of commissions from any spending made by the user on the project.</p>
                <button class="more-rewards-btn">More about rewards</button>
            </div>
            <div class="levels">
                <div class="ll">

                 <div class="level">
                    <span class="level_number">Level 1</span>
                    <span class="numberLevels">  {{ $level1Count }} </span> <!-- عرض عدد المستخدمين الذين جاءوا من خلال الرابط -->
                </div>
                <div class="level">
                    <span class="level_number">Level 2</span>
                    <span class="numberLevels">  {{ $level2Count }} </span>
                </div>

                </div>
                <div class="level">
                    <span class="level_number">Level 3</span>
                    <span class="numberLevels">  {{ $level3Count }}  </span>
                </div>
                <div class="profile-commission">
                <div class="">
 <p class="sub_title_Page"> Your referrals of  level 1
 </p>
</div>
       <div class="commission">
       <div class="profile">
                    <span class="Commission_name">Commission :</span>
                    <span class="Commission_number">{{ number_format($commission) }}</span>
                    </div>
                    <div class="profile">
                    <span class="Commission_name"> Profile :</span>
                    <span class="Commission_number">{{ number_format($commission) }}</span>
                    </div>

                </div>

<p>                You have no referrals of level 1
</p>
</div>

            </div>
            </div>
            </div>



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
