@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('css/earn.css') }}">


  @endpush

@section('content')
<div class="table_responsive">
     <div class="flex_item">
<a href="{{ route('admin.dashboard') }}" class="contol_pannel">⬅️ العودة إلى لوحة التحكم</a>
<h1><strong>0</strong>📬 عرض الرسائل المفتوحة</h1>
</div>
     <div class="flex_item sendToAll">
<a href="{{ route('admin.send_message_form') }}" class="contol_pannel changeback"> إرسال الى جميع المستخدمين</a>
 </div>
<div class="content_messgae_show">
    @if(count($openTickets) < 0)
   <p class="messgae_show">لا يوجد رسائل لعرضها</p>
    @else
    @foreach($openTickets as $ticket)
    <div class="all_Data_Table_Open">
     <div class="Tickit_open">
        <p class="ticket_ele">الوصف 📌</p>
        <strong>{{ $ticket->subject }}</strong>
          </div>
           <div class="Tickit_open">
        <p class="ticket_ele">  الرسالة: 💬</p>
        <strong>{{ $ticket->message }}</strong>
          </div>
            <div class="Tickit_open">
        <p class="ticket_ele">  أُرسلت بتاريخ: 🕒</p>
        <strong>{{ $ticket->created_at->format('Y-m-d H:i') }}</strong>
          </div>
          <div class="Tickit_open">
        <p class="ticket_ele">    اكتب الرد: ✍️</p>
 <form method="POST" action="{{ route('admin.support.reply', $ticket->id) }}">
               @csrf
               <div class="mb-3">
                    <textarea name="reply" class="text_replay" rows="3" placeholder="اكتب الرد هنا..."></textarea>
               </div>
               <button type="submit" class="sent_response">إرسال الرد</button>
           </form>          </div>
         </div>
 @endforeach
   </div>
 </div>
    @endif
</p>

</div>

@endsection
