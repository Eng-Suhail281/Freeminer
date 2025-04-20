// admin/support_tickets.blade.php
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>إدارة التذاكر</h2>
    <table class="table">
        <thead>
            <tr>
                <th>الموضوع</th>
                <th>الرسالة</th>
                <th>الحالة</th>
                <th>الرد</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->subject }}</td>
                    <td>{{ $ticket->message }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>
                        @if($ticket->status == 'open')
                            <form action="{{ route('admin.replyTicket', $ticket->id) }}" method="POST">
                                @csrf
                                <textarea name="response" rows="3" class="form-control"></textarea>
                                <button type="submit" class="btn btn-primary mt-2">إرسال الرد</button>
                            </form>
                        @else
                            <p>تم الرد</p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
