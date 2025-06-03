@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}"></link>

  @endpush
@section('content')
<div class="content_invites">
         <h1 class="content_invite_h2">Complete Tasks to earn more</h1>
     <div class="main-content">
        <h2 class="content_h2">FRIENDS</h2>
        <div class="tasks">
        <div class="task_card">
                <img class="telg" src="{{('asset/tel.jpg')}}" alt="Telegram">
                <div class="text_task">
                    <p class="textInvite"> Invite 3 friends</p>
                    <p class="reward">Reward: 450 GPU</p>
                </div>
                <div class="progress_content">
                    <progress class="progress" id="file" value="52" max="100"> 32% </progress>
                     <label class="count_number" for="file">   0/3 </label>
                 </div>
             </div>
             <div class="task_card">
                <img class="telg" src="{{('asset/tel.jpg')}}" alt="Telegram">
                <div class="text_task">
                    <p class="textInvite"> Invite 3 friends</p>
                    <p class="reward">Reward: 450 GPU</p>
                </div>
                <div class="progress_content">
                    <progress class="progress" id="file" value="52" max="100"> 32% </progress>
                     <label class="count_number" for="file">   0/3 </label>
                 </div>
             </div>
             <div class="task_card">
                <img class="telg" src="{{('asset/tel.jpg')}}" alt="Telegram">
                <div class="text_task">
                    <p class="textInvite"> Invite 3 friends</p>
                    <p class="reward">Reward: 450 GPU</p>
                </div>

                <div class="progress_content">
                    <progress class="progress" id="file" value="52" max="100"> 32% </progress>
                     <label class="count_number" for="file">   0/3 </label>
                 </div>
             </div>

            </div>

        </div>

        <div class="AllBONUS_CARD">
        <h2 class="content_h2">TOP UP BONUS</h2>
<div class="BONUS_CARD">
    <div class="dis_Boun">
    <img src="{{('asset/flag.png')}}" alt="English" class="flag-img">
    <div class="text_tasks">
                    <span class="textInvites"> Yop Up Balance : $5</span>
                    <p class="rewards">Reward: 45000 GPU</p>
                </div>
    </div>
  <p class="numTasks">0/3</p>

</div>
<div class="BONUS_CARD">
    <div class="dis_Boun">
    <img src="{{('asset/flag.png')}}" alt="English" class="flag-img">
    <div class="text_tasks">
                    <span class="textInvites"> Yop Up Balance : $5</span>
                    <p class="rewards">Reward: 45000 GPU</p>
                </div>
    </div>
  <p class="numTasks">0/3</p>

</div>
        </div>
        <div class="AllBONUS_CARD">
        <h2 class="content_h2">FOLLOW US</h2>
<div class="BONUS_CARD Follow">
    <div class="dis_Boun">
    <img src="{{('asset/flag.png')}}" alt="English" class="flag-img">
    <div class="text_tasks">
                    <span class="textInvites"> Follow Our News channel</span>
                    <p class="rewards">Reward: 45000 GPU</p>
                </div>
    </div>
    <div class="all_button">
    <a href="tg://resolve?domain=yourusername">
    <button class="Open" target="_blank" >Open</button>
    </a>

         <button class="Check" onclick="document.getElementById('id01').style.display='block'">Check</button>
     </div>
</div>
<div class="BONUS_CARD Follow">
    <div class="dis_Boun">
     <img src="{{('asset/flag.png')}}" alt="English" class="flag-img">

    <div class="text_tasks">
                    <span class="textInvites"> Follow Our News channel</span>
                    <p class="rewards">Reward: 45000 GPU</p>
                </div>
    </div>
    <div class="all_button">
        <button class="Open" >Open</button>
        <button class="Check" >Check</button>
     </div>
</div>
  </div>
<div class="AllBONUS_CARD">
        <h2 class="content_h2">OTHER</h2>
<div class="BONUS_CARD Follow">
    <div class="dis_Boun">
    <img src="{{('asset/flag.png')}}" alt="English" class="flag-img">
    <div class="text_tasks">
                    <span class="textInvites"> Follow Our News channel</span>
                    <p class="rewards">Reward: 45000 GPU</p>
                </div>
    </div>
    <div class="all_button">
        <button class="Open">Open</button>
        <button class="Check">Check</button>

     </div>

</div>
</div>


        </div>
</div>
        </div>
 <div id="id01" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
      <p>App Miner Faster</p>
      <p>Task Not Completed</p>
    </div>
    <button class="deposit-btn OKButton" onclick="document.getElementById('id01').style.display='none'" >OK</button>

  </div>
</div>
        </div>


@endsection
