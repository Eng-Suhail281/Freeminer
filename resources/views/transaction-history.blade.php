@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-center">💳 سجل المعاملات</h3>

    @if($transactions->isEmpty())
        <div class="alert alert-info text-center">لا توجد معاملات حالياً.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>💰 المبلغ</th>
                        <th>📄 النوع</th>
                        <th>📆 التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                        <tr>
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    @if($tx->type === 'deposit')
                                        <i class="bi bi-box-arrow-in-down"></i> إيداع
                                    @elseif($tx->type === 'withdraw')
                                        <i class="bi bi-box-arrow-up"></i> سحب
                                    @else
                                        {{ ucfirst($tx->type) }}
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
