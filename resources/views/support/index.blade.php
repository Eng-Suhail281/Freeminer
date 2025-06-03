@extends('layouts.app')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
 <link rel="stylesheet" href="{{ asset('css/supoort.css') }}"></link>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js" integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous"></script>  </head>

 <!-- Toastify JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endpush
@section('content')


<div class="btn_support">

    <button class="addMessgeSupport" onclick="document.getElementById('id01').style.display='block'">Write Messge</button>
     <form id="id01" class="form_support" action="{{ route('support.send') }}" method="POST">
        @csrf
        <div class="Faq_cntent Subject " >
            <label class="sub_title_Page">Subject:</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="inputForm">
        </div>
        <div class="Faq_cntent Subject" >
            <label class="sub_title_Page">Message:</label>
            <textarea name="message" rows="4" class="message">{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="Send_button">SEND</button>
    </form>
    <div class="allcardSupports">

    @foreach($tickets as $ticket)

        <div class="cardSupports">
         <a href="{{ route('support.show', $ticket->id) }}" class="cardSupports allA">
                     <div class="textMessg">{{ $ticket->subject }}</div>
                    <div>
                        @if($ticket->reply)
                            <span class="badges">Show</span>
                        @else
                            <span class="badges">Open</span>
                        @endif
                    </div>
                </a>

             </div>

             @endforeach
            </div>
            </div>

@if (session('success'))
<script>
  Toastify({
    text: "{{ session('success') }}",
    duration: 3000,
    close: true,
    gravity: "top",
    position: "right",
    backgroundColor: "#4CAF50",
    stopOnFocus: true,
  }).showToast();
</script>
@endif


@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
            Toastify({
                text: "{{ $error }}",
                duration: 4000,
                gravity: "top",
                position: "right",
                backgroundColor: "#f44336",
                close: true,
            }).showToast();
        @endforeach
    </script>
@endif

@endsection
