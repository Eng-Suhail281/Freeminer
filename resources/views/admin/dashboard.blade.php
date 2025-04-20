@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-5 text-center">🛠️ لوحة تحكم الإدارة</h1>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4>عدد المستخدمين</h4>
                    <p class="fs-1">{{ $userCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4>إجمالي الإيداع</h4>
                    <p class="fs-1">{{ $totalDeposits }} FMT</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4>التذاكر المفتوحة</h4>
                    <p class="fs-1">{{ $openTickets->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <a href="{{ route('admin.support.open') }}" class="btn btn-warning">عرض الرسائل المفتوحة</a>
        <a href="{{ route('admin.support.closed') }}" class="btn btn-success">عرض الرسائل التي تم الرد عليها</a>
        <a href="{{ route('admin.users') }}" class="btn btn-primary">عرض المستخدمين</a>
    </div>
</div>
@endsection
