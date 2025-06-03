<div class="bottom-nav">
    <div class="icon_text">
     <i class="bi bi-file-ruled-fill iconSize"></i>
    <a href="{{ route('deposit.deposit') }}" class="{{ request()->is('power') ? 'active' : '' }}">
        <div>Power</div>
    </a>
    </div>
    <div class="icon_text">
     <i class="bi bi-people-fill iconSize"></i>

    <a href="{{ url('/earn') }}" class="{{ request()->is('earn') ? 'active' : '' }}">
        <div class="text_footer">Earn</div>
    </a>
    </div>

    <div class="icon_text">
     <i class="bi bi-disc-fill iconSize"></i>
    <a href="{{ url('/') }}" class="{{ request()->is('miner') ? 'active' : '' }}">
        <div class="text_footer"><b>Miner</b></div>
    </a>
    </div>

    <div class="icon_text">
     <i class="bi bi-folder-fill iconSize"></i>
    <a href="{{ route('withdraw.index') }}" class="{{ request()->is('withdraw*') ? 'active' : '' }}">
        <div class="text_footer">Withdraw</div>
    </a>
    </div>
    <div class="icon_text">
     <i class="bi bi-layout-text-window iconSize"></i>
    <a href="{{ url('/tasks') }}" class="{{ request()->is('tasks') ? 'active' : '' }}">
        <div class="text_footer">Tasks</div>
    </a>
    </div>

</div>

@push('styles')
<style>
    .bottom-nav {
           justify-content: space-around;
   max-width: 100%;
        bottom: 0;
        border-top: 1px solid #333;
    }
.icon_text{
    display: flex;
    flex-direction: column;


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
