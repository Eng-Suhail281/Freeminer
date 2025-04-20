<?php
// app/Http/Controllers/WebhookController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    // دالة لمعالجة التحديثات من NowPayments
    public function handlePayment(Request $request)
    {
        // التحقق من وجود بيانات الدفع
        $data = $request->all();

        // يمكن التحقق من التوقيع أو التحقق من بيانات الدفع هنا (اختياري)
        // $signature = $request->header('X-Signature');
        // تحقق من التوقيع إذا كنت تستخدمه مع NowPayments

        // تحقق إذا كانت المدفوعات ناجحة
        if ($data['payment_status'] == 'success') {
            // استخراج المعلومات المهمة مثل telegram_id و المبلغ المدفوع
            $telegramId = $data['user_data']; // استبدل هذا بالبيانات الحقيقية من NowPayments
            $amountPaid = $data['price_amount'];

            // العثور على المستخدم بناءً على telegram_id
            $user = User::where('telegram_id', $telegramId)->first();

            if ($user) {
                // حساب القوة (GPU Power) بناءً على المبلغ المدفوع
                $gpuPower = $amountPaid * 100;  // هذا افتراض، قم بتغيير الحساب وفقًا لما يتناسب مع مشروعك
                $user->gpu_power += $gpuPower;

                // إذا كانت هذه أول دفعة، أضف 25% بونص
                if (!$user->has_deposited) {
                    $user->gpu_power += $gpuPower * 0.25; // 25% بونص
                    $user->has_deposited = true;
                }

                // حفظ التحديثات
                $user->save();

                // تسجيل العملية بنجاح
                Log::info("Payment received for user {$user->telegram_id}. Amount: {$amountPaid}, GPU Power: {$user->gpu_power}");
            } else {
                Log::warning("User not found for telegram_id: {$telegramId}");
            }
        } else {
            Log::warning("Payment failed or not successful. Data: " . json_encode($data));
        }

        return response()->json(['status' => 'success']);
    }
}
