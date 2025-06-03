@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"></link>
<link rel="stylesheet" href="{{ asset('css/deposit.css') }}">

  @endpush
@section('content')
       <div class="flex_item">
<a href="{{ route('admin.dashboard') }}" class="contol_pannel">⬅️ العودة إلى لوحة التحكم</a>
<h1 class="mb-5 text-center">
     <!-- <span>0</span> -->
📝 الرسائل التي تم الرد عليها</h1>
 </div>
<div class="content_messgae_show">
    @if(count($closedTickets) <= 0)
   <p class="messgae_show">لا يوجد رسائل لعرضها</p>
    @else
              @foreach($closedTickets as $ticket)
    <div class="all_Data_Table_Open">
     <div class="Tickit_open">
        <p class="ticket_ele">Tickit User</p>
        <strong>{{ $ticket->user_id }}</strong>
          </div>
            <div class="Tickit_open">
        <p class="ticket_ele">Response</p>
        <strong>{{ $ticket->subject }}</strong>
          </div>
            <div class="Tickit_open">
        <p class="ticket_ele">Message</p>
        <strong>{{ $ticket->message }}</strong>
          </div>
           <div class="Tickit_open">
        <p class="ticket_ele">  Time Sent Date:</p>
        <strong>{{ $ticket->created_at->format('Y-m-d H:i') }}</strong>
          </div>
            <div class="Tickit_open">
        <p class="ticket_ele">  Reply</p>
        <strong>{{ $ticket->reply }}</strong>
          </div>
          </div>
        @endforeach
        </div>
        @endif
        </p>
</div>
</div>

@endsection
