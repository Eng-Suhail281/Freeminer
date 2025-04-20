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
        .header {
            background-color: #2d3b47;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .main-content {
            padding: 20px;
            text-align: center;
        }
        .main-content h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .tasks {
            margin-bottom: 40px;
        }
        .task {
            background-color: #333;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .task p {
            margin: 0;
        }
        .task .task-icon {
            width: 40px;
            height: 40px;
        }
        .task .progress-bar {
            flex-grow: 1;
            height: 8px;
            background-color: #444;
            border-radius: 10px;
            margin-left: 10px;
        }
        .task .progress-bar span {
            display: block;
            height: 100%;
            background-color: #ff6a00;
        }
        .footer {
            background-color: #1a1a1a;
            padding: 20px;
            position: fixed;
            width: 100%;
            bottom: 0;
            display: flex;
            justify-content: space-around;
        }
        .footer div {
            text-align: center;
            color: #aaa;
        }
        .footer .active {
            color: #ff6a00;
        }
    </style>
@endpush

@section('content')
    <div class="header">
        <h1>Complete Tasks to earn more</h1>
    </div>

    <div class="main-content">
        <h2>FRIENDS</h2>

        <div class="tasks">
            <div class="task">
                <img class="task-icon" src="https://upload.wikimedia.org/wikipedia/commons/8/83/Telegram_Logo.svg" alt="Telegram">
                <div>
                    <p>Invite 1 friend</p>
                    <span>Reward: 200 GPU</span>
                </div>
                <div class="progress-bar">
                    <span style="width: 14%;"></span>
                </div>
                <p>0/1</p>
            </div>

            <div class="task">
                <img class="task-icon" src="https://upload.wikimedia.org/wikipedia/commons/8/83/Telegram_Logo.svg" alt="Telegram">
                <div>
                    <p>Invite 3 friends</p>
                    <span>Reward: 450 GPU</span>
                </div>
                <div class="progress-bar">
                    <span style="width: 43%;"></span>
                </div>
                <p>0/3</p>
            </div>

            <div class="task">
                <img class="task-icon" src="https://upload.wikimedia.org/wikipedia/commons/8/83/Telegram_Logo.svg" alt="Telegram">
                <div>
                    <p>Invite 7 friends</p>
                    <span>Reward: 1000 GPU</span>
                </div>
                <div class="progress-bar">
                    <span style="width: 0%;"></span>
                </div>
                <p>0/7</p>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    @include('layouts.footer')
@endsection
