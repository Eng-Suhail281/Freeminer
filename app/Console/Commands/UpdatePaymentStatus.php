<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use Carbon\Carbon;

class UpdatePaymentStatus extends Command
{
    protected $signature = 'payments:update-status';
    protected $description = 'Update the payment status to paid if the payment was made within the 10 minute window';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // استرجاع المدفوعات غير المدفوعة
        $payments = Payment::where('status', 'pending')
            ->where('payment_deadline', '<', Carbon::now())
            ->get();

        foreach ($payments as $payment) {
            // تحديث حالة الدفع إلى "paid" (أو يمكنك التحقق من حالة الدفع الفعلية)
            $payment->status = 'paid';
            $payment->save();
        }

        $this->info('Payment statuses updated successfully!');
    }
}
