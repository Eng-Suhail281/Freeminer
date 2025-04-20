<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment; // تأكد من استيراد نموذج الدفع الخاص بك
use Carbon\Carbon;

class CheckPendingPayments extends Command
{
    protected $signature = 'payments:clear';
    protected $description = 'حذف المدفوعات المعلقة لأكثر من 10 دقائق';

    public function handle()
{
    $pendingPayments = Payment::where('status', 'binding')
                            ->where('created_at', '<', now()->subMinutes(10))
                            ->get();

    foreach ($pendingPayments as $payment) {
        // التحقق من الدفع باستخدام API لكل طريقة
        $this->checkPaymentStatus($payment);
    }
}

public function checkPaymentStatus($payment)
{
    // افترض هنا أننا نتحقق من الدفع عبر API لطرق الدفع المختلفة
    $paymentMethod = $payment->method;

    if ($paymentMethod == 'tron') {
        // تحقق من الدفع باستخدام TRON API
    } elseif ($paymentMethod == 'bnb') {
        // تحقق من الدفع باستخدام BNB API
    }
    // بعد التحقق:
    $payment->status = 'paid'; // إذا تم الدفع
    $payment->save();
}

}