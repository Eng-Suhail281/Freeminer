<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NowPaymentsService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Payment;

class WithdrawController extends Controller
{
    protected NowPaymentsService $nowPayments;

    public function __construct(NowPaymentsService $nowPayments)
    {
        $this->nowPayments = $nowPayments;
    }

    /**
     * 1. صفحة اختيار طريقة السحب
     */
    public function index()
    {
        return view('withdraw.index');
    }

    /**
     * 2. عرض نموذج السحب لعملة محددة
     */
    public function showForm(string $method)
    {
        // تأكد من صحة الطريقة
        $validMethods = ['tron', 'bnb', 'ton', 'litecoin'];
        if (!in_array($method, $validMethods)) {
            abort(404);
        }

        // جلب المستخدم الحالي باستخدام Telegram ID
        $telegramId = session('telegram_id');
        $user = User::where('telegram_id', $telegramId)->firstOrFail();

        return view('withdraw.form', [
            'method' => $method,
            'balance' => $user->balance,
        ]);
    }

    /**
     * 3. معالجة طلب السحب
     */
    public function submit(Request $request, string $method)
    {
        // تأكد من صحة الطريقة
        $validMethods = ['tron', 'bnb', 'ton', 'litecoin'];
        if (!in_array($method, $validMethods)) {
            abort(404);
        }

        // تحقق من المدخلات
        $request->validate([
            'amount'         => 'required|numeric|min:1',
            'wallet_address' => 'required|string',
        ]);

        // جلب المستخدم باستخدام Telegram ID
        $telegramId = session('telegram_id');
        $user = User::where('telegram_id', $telegramId)->firstOrFail();

        // تحقق من كفاية الرصيد
        if ($user->balance < $request->amount) {
            return back()->with('error', 'رصيدك غير كافٍ للسحب.');
        }

        // إرسال طلب السحب عبر NowPayments
        $result = $this->nowPayments->createPayout(
            $request->amount,
            $method,
            $request->wallet_address
        );

        if (isset($result['id'])) {
            // تسجيل السحب في قاعدة البيانات
            Payment::create([
                'user_id'       => $user->id,
                'telegram_id'   => $telegramId,
                'amount'        => $request->amount,
                'method'        => $method,
                'status'        => 'pending',
                'type'          => 'withdraw',
                'order_id'      => $result['id'],
            ]);

            // خصم المبلغ من رصيد المستخدم
            $user->balance -= $request->amount;
            $user->save();

            return redirect()->route('withdraw.success')
                             ->with('success', 'تم إرسال طلب السحب بنجاح، قيد المعالجة.');
        }

        // في حال فشل الطلب
        return back()->with('error', 'فشل إنشاء طلب السحب. حاول مرة أخرى لاحقًا.');
    }

    /**
     * 4. صفحة النجاح بعد إرسال طلب السحب
     */
    public function success()
    {
        return view('withdraw.success');
    }

    /**
     * 5. Webhook لمعالجة تحديث حالة السحب من NowPayments
     */
    public function callback(Request $request)
    {
        // مثال: الآن يتم استقبال IPN من NowPayments وتحديث الحالة بناءً على $request->status
        if ($request->status === 'successful') {
            $orderId = $request->id;
            Payment::where('order_id', $orderId)
                   ->where('type', 'withdraw')
                   ->first()
                   ?->update(['status' => 'completed']);
        } elseif (in_array($request->status, ['rejected', 'expired'])) {
            $orderId = $request->id;
            $payment = Payment::where('order_id', $orderId)
                              ->where('type', 'withdraw')
                              ->first();
            if ($payment) {
                // في حال فشل السحب، نعيد الرصيد للمستخدم
                $user = User::find($payment->user_id);
                $user->balance += $payment->amount;
                $user->save();

                $payment->update(['status' => 'failed']);
            }
        }

        return response()->json(['message' => 'IPN handled'], 200);
    }
}
