@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/promoCode.css') }}"></link>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"></link>

@section('content')
<div class="promoCode">
    <div class="levelPromo">
        <a href="{{ route('admin.promo-codes.create') }}" class="create_code">➕ إنشاء كود جديد</a>
        <h2>🎯 الأكواد الترويجية</h2>
    </div>

    @if($codes->count())
        <div class="all_boxProwCode">

    <div class="boxProwCode">
        @foreach ($codes as $promo)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card_title">كود: <strong>{{ $promo->code }}</strong></h5>
                    <div class="details_promo">الوصف:<p> {{ $promo->description ?? '-' }}</p></div>
                    <div class="details_promo">عنوان المحفظة:<p>{{ $influencer->wallet_address ?? 'لم يتم إضافة عنوان المحفظة بعد' }}</p> </div>
                    <div class="details_promo"  >مستخدمون: <p>
                   {{ $promo->users_count }} </p></div>
                    <div class="details_promo"  >أودعوا: <p> {{ $promo->deposit_users_count }}</p></div>
                    <div class="details_promo">مجموع الإيداعات:<p> {{ number_format($promo->users_deposit_amount_sum ?? 0, 2) }} USD</p></div>
                    <div class="details_promo">

                        <a href="{{ route('admin.promo-codes.users', $promo->id) }}" class="promo_users">👥 المستخدمون</a>
                      <div class="flex-item">

                          <form action="{{ route('admin.promo-codes.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الكود؟');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="buttons_promo destroyPromo">🗑️ حذف</button>
                            </form>
                            <a href="{{ route('admin.promo-codes.edit', $promo->id) }}" class="buttons_promo edits">✏️ تعديل</a>
                        </div>
</div>


                    <div class="flex-item copy_links">
                        <input type="text"
                               class="form_control"
                               id="link-{{ $promo->id }}"
                               value="{{ url('/?promo=' . $promo->code) }}"
                               readonly>
                        <button class="buttons_promo copy_promo"
                                onclick="copyToClipboard('link-{{ $promo->id }}')">
                            📋 نسخ
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $codes->links() }}
    </div>
    @else
    <div class="alert alert-warning text-center">لا توجد أكواد ترويجية حالياً.</div>
    @endif
</div>
</div>

<script>
function copyToClipboard(id) {
    const input = document.getElementById(id);
    input.select();
    document.execCommand('copy');
    alert('تم نسخ الرابط: ' + input.value);
}
</script>
@endsection
