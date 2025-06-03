<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NowPaymentsService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
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
        $telegramId = session('telegram_id');
    $user = User::where('telegram_id', $telegramId)->firstOrFail();

    return view('withdraw.index', [
        'balance' => $user->balance,
    ]);
    }

    /**
     * 2. عرض نموذج السحب لعملة محددة
     */
    public function showForm(string $method)
{
    $validMethods = ['tron', 'bnb', 'ton', 'litecoin'];
    if (!in_array($method, $validMethods)) {
        abort(404);
    }

    $telegramId = session('telegram_id');
    $user = User::where('telegram_id', $telegramId)->firstOrFail();

    // حساب قيمة 1 FMT = 0.01 USDT
    $usdtAmount = $user->balance / 100;

    // نحول من USDT إلى العملة المختارة
    $rate = $this->nowPayments->getExchangeRate('usdt', $method);

    $estimatedAmount = $rate ? $usdtAmount * $rate : 0;

    return view('withdraw.form', [
        'method'           => $method,
        'balance'          => $user->balance,
        'estimatedAmount'  => $estimatedAmount,
        'rate'             => $rate,
    ]);
}


    /**
     * 3. معالجة طلب السحب
     */
   public function submit(Request $request, string $method)
{
            $fixedRates = [
            'tron' => 0.036555,    // 1 FMT 
            'ton' => 0.00341111,      // 1 FMT 
            'litecoin' => 0.00010288,  // 1 FMT 
            'bnb' => 0.00001479       // 1 FMT 
        ];
        
    if (!isset($fixedRates[$method])) {
        return back()->with('error', 'طريقة السحب غير مدعومة حالياً.');
    }

    $request->validate([
        'amount'         => 'required|numeric|min:1',
        'wallet_address' => 'required|string',
    ]);

    $telegramId = session('telegram_id');
    $user = User::where('telegram_id', $telegramId)->firstOrFail();

    if ($user->balance < $request->amount) {
        return back()->with('error', 'رصيدك غير كافٍ للسحب.');
    }

    if ($user->status !== 'active') {
        return back()->with('error', 'حسابك غير مفعل ولا يمكنك سحب الأموال.');
    }

    // حساب المبلغ بالعملة المختارة باستخدام السعر الثابت
    $usdtAmount = $request->amount / 100; // تحويل FMT إلى USDT
    $rate = $fixedRates[$method];
    $estimatedAmount = $usdtAmount * $rate;

    $result = $this->nowPayments->createPayout(
        $estimatedAmount,
        $method,
        $request->wallet_address
    );

    if (isset($result['id'])) {
        Payment::create([
            'user_id'     => $user->id,
            'telegram_id' => $telegramId,
            'amount'      => $request->amount, // بـ FMT
            'method'      => $method,
            'status'      => 'pending',
            'type'        => 'withdraw',
            'order_id'    => $result['id'],
        ]);

        $user->balance -= $request->amount;
        $user->save();

        return redirect()->route('withdraw.success')
                         ->with('success', 'تم إرسال طلب السحب بنجاح، قيد المعالجة.');
    }

    Log::error('فشل في إنشاء السحب', ['response' => $result]);

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
     * 5. Webhook لمعالجة تحديث حالة السحب من NowPayments (بدون تحقق توقيع)
     */
    public function callback(Request $request)
    {
        $status = $request->status;
        $orderId = $request->id;

        if ($status === 'successful') {
            Payment::where('order_id', $orderId)
                   ->where('type', 'withdraw')
                   ->first()
                   ?->update(['status' => 'completed']);
        } elseif (in_array($status, ['rejected', 'expired'])) {
            $payment = Payment::where('order_id', $orderId)
                              ->where('type', 'withdraw')
                              ->first();
            if ($payment) {
                $user = User::find($payment->user_id);
                if ($user) {
                    $user->balance += $payment->amount;
                    $user->save();
                }

                $payment->update(['status' => 'failed']);
            }
        }

        return response()->json(['message' => 'IPN handled'], 200);
    }
}
