@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/supoort.css') }}"></link>

  @endpush
@section('content')
<div class="allmessfes">
    <h1>{{ $ticket->subject }}</h1>
    <hr>
    <div class="levelShowmessage">
        <h5>Your Message:</h5>
        <p class="small_text">{{ $ticket->message }}</p>
    </div>
    @if($ticket->reply)
        <div class="levelShowmessage">
            <h5>Admin Reply:</h5>
         <p class="small_text">{{ $ticket->reply }}</p>
        </div>
    @else
     <div class="levelShowmessage">
            <h5>Admin Reply:</h5>
        <p class="text-muted">No reply yet.</p>

        </div>
     @endif
   <div class="levelShowmessages">
            <h5> </h5>
     <a href="{{ route('support.index') }}" class="backControl">Back to Tickets</a>

        </div>
 </div>
@endsection
