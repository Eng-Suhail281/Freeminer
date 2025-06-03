@extends('layouts.app')

@section('content')
<div class="all_content_table">
    @if($transactions->isEmpty())
    <div class="records">
         <p class="images">💳</p>
         <div class="no_record">لا توجد معاملات حالياً</div>
</div>
    @else
        <div class="table-responsive">
            <h1>Transactions History</h1>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th> المبلغ 💰  </th>
                        <th> النوع 📄  </th>
                        <th> التاريخ 📆  </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                        <tr class="th">
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>

                        <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
                                    @endif
                                </span>
                            </td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>  <tr class="th">
                            <td>
                                <span class="fw-bold text-{{ $tx->type === 'deposit' ? 'success' : 'danger' }}">
                                    {{ $tx->amount }} FMT
                                    jdsjkjsd
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
                                        ssjckjs
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
