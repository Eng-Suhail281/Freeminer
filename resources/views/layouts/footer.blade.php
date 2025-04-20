<div class="bottom-nav">
    <a href="{{ route('deposit.deposit') }}" class="{{ request()->is('power') ? 'active' : '' }}">
        <div>Power</div>
    </a>

    <a href="{{ url('/earn') }}" class="{{ request()->is('earn') ? 'active' : '' }}">
        <div>Earn</div>
    </a>

    <a href="{{ url('/') }}" class="{{ request()->is('miner') ? 'active' : '' }}">
        <div><b>Miner</b></div>
    </a>

    <a href="{{ route('withdraw.index') }}" class="{{ request()->is('withdraw*') ? 'active' : '' }}">
        <div>Withdraw</div>
    </a>

    <a href="{{ url('/tasks') }}" class="{{ request()->is('tasks') ? 'active' : '' }}">
        <div>Tasks</div>
    </a>
</div>

@push('styles')
<style>
    .bottom-nav {
        background-color: #1a1a1a;
        padding: 15px 0;
        display: flex;
        justify-content: space-around;
        position: fixed;
        width: 100%;
        bottom: 0;
        border-top: 1px solid #333;
    }

    .bottom-nav a {
        text-decoration: none;
        color: #aaa;
        font-size: 14px;
        text-align: center;
    }

    .bottom-nav a.active {
        color: #ff6a00;
        font-weight: bold;
    }

    .bottom-nav a div {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
</style>
@endpush
