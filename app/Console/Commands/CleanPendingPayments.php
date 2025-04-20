<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment; // تأكد من استيراد نموذج الدفع الخاص بك
use Carbon\Carbon;

class ClearPendingPayments extends Command
{
    protected $signature = 'payments:clear';
    protected $description = 'حذف المدفوعات المعلقة لأكثر من 10 دقائق';

    public function handle()
    {
        $cutoffTime = Carbon::now()->subMinutes(10);
        
        Payment::where('status', 'pending')
               ->where('created_at', '<=', $cutoffTime)
               ->delete();

        $this->info('تم حذف المدفوعات المعلقة القديمة بنجاح.');
    }
}