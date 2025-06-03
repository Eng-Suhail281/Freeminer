@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"></link>

  @endpush
@section('content')
<div class="table_responsive">
      <div class="table_responsives">





  <div class="flex_item">
    <form method="GET" class="" action="{{ route('admin.users') }}">

    <select class="Select_search_input" name="status">
        <option value="">كل الحالات</option>
        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>مفعل</option>
        <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>محظور</option>
    </select>

    <select class="Select_search_input" name="date_filter">
    <option value="">كل الوقت</option>
    <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>آخر 7 أيام</option>
    <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>هذا الشهر</option>
</select>
    <button class="btn_search_input Slect_button" type="submit">تصفية</button>
</form>

    <form method="GET" class="form_input_Search" action="{{ route('admin.users') }}" class="">
    <input type="text" name="search" placeholder="🔍    ابحث باسم أو بريد المستخدم" value="{{ request('search') }}"
        class="search_input">
    <button type="submit" class="btn_search_input">بحث</button>
</form>
 </div>
























        <div class="flex_item">
            <a href="{{ route('admin.dashboard') }}" class="contol_pannel">⬅️ العودة إلى لوحة التحكم</a>
            <h2 class="mb-5 text-center">👥 قائمة المستخدمين</h2>
        </div>
        <div class="">
             <table class="table Tabs">
                <thead class="table-dark">
                    <tr>
                    <th>تيليجرام ID</th>
                    <th>اسم المستخدم</th>
                    <th>إجمالي الإيداع  </th>
                    <th>كود الاحالة</th>
                    <th>promo code</th>
                    <th>الحالة</th>
                    <th>تاريخ الانضمام</th>
                    <th>ايداع الحالة</th>
                   <th> الخيارات المتاحة</th>
                    </tr>
                </thead>
                 <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->telegram_id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ number_format($user->deposit_amount ?? 0, 2) }}</td>
                    <td>{{ $user->referral_code }}</td>  <!-- كود الإحالة -->
                    <td>{{ $user->promo_code }}</td>  <!-- كود الإحالة -->
                    <td>{{ $user->status }}</td>
                    <td>{{ optional($user->created_at)->format('Y-m-d') }}</td>
                    <td>
                        @if($user->has_deposited)
                            ✅
                        @else
                            ❌
                        @endif
                    </td>
                    <div class="allOptions">
                    <td class="allOptions">
    <!-- زر التفعيل -->
     <span class="span_btn">



     @if ($user->status === 'disabled')
        <form method="POST" action="{{ route('admin.users.activate', $user->telegram_id) }}" style="display:inline;">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success">تفعيل</button>
        </form>
    @elseif ($user->status === 'active')
        <form method="POST" action="{{ route('admin.users.deactivate', $user->telegram_id) }}" style="display:inline;">
            @csrf
            @method('PUT')
            <button type="submit" class="buttonShares disabled">تعطيل</button>
        </form>
    @endif

     <!-- زر الحذف -->
    <form method="POST" action="{{ route('admin.users.destroy', $user->telegram_id) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف المستخدم؟');">
        @csrf
        @method('DELETE')
        <button type="submit" class="buttonShares destroy">حذف</button>
    </form>
       </span>

       <span >

    <button class="buttonShares sendMessges" data-toggle="modal" data-target="#messageModal{{ $user->id }}">
        إرسال رسالة
    </button>
       </span>

</td>

 </div>

                </tr>



                @endforeach
                <!-- <tbody>
                @foreach($users as $user)
                <tr class="th">
                  <td>
                   {{ $user->telegram_id }}
                            </td>
                            <td>
                            {{ $user->payments->sum('amount') }} FMT
                            </td>
                            <td>{{ $user->balance }} GPU</td>

                         </tr>
                         <tr class="th">
                  <td>
                   {{ $user->telegram_id }}
                            </td>
                            <td>
                            {{ $user->payments->sum('amount') }} FMT
                            </td>
                            <td>{{ $user->balance }} GPU</td>

                         </tr>
                         <tr class="th">
                  <td>
                   {{ $user->telegram_id }}
                            </td>
                            <td>
                            {{ $user->payments->sum('amount') }} FMT
                            </td>
                            <td>{{ $user->balance }} GPU</td>

                         </tr> <tr class="th">
                  <td>
                   {{ $user->telegram_id }}
                            </td>
                            <td>
                            {{ $user->payments->sum('amount') }} FMT
                            </td>
                            <td>{{ $user->balance }} GPU</td>

                         </tr> <tr class="th">
                  <td>
                   {{ $user->telegram_id }}
                            </td>
                            <td>
                            {{ $user->payments->sum('amount') }} FMT
                            </td>
                            <td>{{ $user->balance }} GPU</td>

                         </tr> <tr class="th">
                  <td>
                   {{ $user->telegram_id }}
                            </td>
                            <td>
                            {{ $user->payments->sum('amount') }} FMT
                            </td>
                            <td>{{ $user->balance }} GPU</td>

                         </tr> <tr class="th">
                  <td>
                   {{ $user->telegram_id }}
                            </td>
                            <td>
                            {{ $user->payments->sum('amount') }} FMT
                            </td>
                            <td>{{ $user->balance }} GPU</td>

                         </tr>
                         <tr class="th">
                  <td>
                   {{ $user->telegram_id }}
                            </td>
                            <td>
                            {{ $user->payments->sum('amount') }} FMT
                            </td>
                            <td>{{ $user->balance }} GPU</td>

                         </tr> <tr class="th">
                  <td>
                   {{ $user->telegram_id }}
                            </td>
                            <td>
                            {{ $user->payments->sum('amount') }} FMT
                            </td>
                            <td>{{ $user->balance }} GPU</td>

                         </tr>
                    @endforeach
                </tbody> -->
            </table>
        </div>

 </div>
@endsection
