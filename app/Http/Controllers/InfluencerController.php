<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Influencer;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Hash;
use App\Models\InfluencerWithdrawal;




class InfluencerController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function showLogin()
    {
        return view('influencer.login');
    }

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $influencer = Influencer::where('email', $request->email)->first();

        if ($influencer && Hash::check($request->password, $influencer->password)) {
            session(['influencer_id' => $influencer->id]);
            return redirect()->route('influencer.dashboard');
        }

        return back()->withErrors(['login' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة']);
    }

    // عرض Dashboard للمؤثّرين
    public function dashboard()
{
    if (!session()->has('influencer_id')) {
        return redirect()->route('influencer.login');
    }

    $influencer = Influencer::find(session('influencer_id'));
    if (!$influencer) {
        session()->forget('influencer_id');
        return redirect()->route('influencer.login');
    }

    $promoCode = PromoCode::where('code', $influencer->promo_code)->first();

    // نُحمّل المستخدمين المرتبطين
    $users = \App\Models\User::where('promo_code', $promoCode->code)->get();

    $totalUsers = $users->count();
    $depositUsers = $users->where('has_deposited', 1)->count();
    $totalDepositAmount = \App\Models\user::whereIn('telegram_id', $users->pluck('telegram_id'))->sum('deposit_amount');
    $totalDeposits = $users->sum('deposit_amount');
    $commission = $totalDeposits * 0.10;

    // حساب العمولة المتاحة للسحب
    $commissionAvailable = $commission - $promoCode->commission_withdrawn;

    // تحديث الحقول في قاعدة البيانات (اختياري)
    $promoCode->commission_earned = $commission;
    $promoCode->commission_available = $commissionAvailable;
    $promoCode->save();

    return view('influencer.dashboard', compact(
        'influencer', 'promoCode', 'totalUsers', 'depositUsers', 'totalDepositAmount','commission','commissionAvailable'
    ));
}



public function withdrawCommission(Request $request)
{
      // تحقق من وجود المعرف في الجلسة
      if (!session()->has('influencer_id')) {
        return back()->with('error', 'يرجى تسجيل الدخول أولاً.');
    }

    // استرجاع بيانات المؤثر
    $influencer = Influencer::find(session('influencer_id'));

    if (!$influencer) {
        return back()->with('error', 'المؤثر غير موجود.');
    }

    $promo = PromoCode::where('code', $influencer->promo_code)->first();

    if (!$promo) {
        return back()->with('error', 'لم يتم العثور على كود البرومو.');
    }

    if ($promo->commission_available <= 0) {
        return back()->with('error', 'لا يوجد مبلغ متاح للسحب.');
    }

    $amountToWithdraw = $promo->commission_available;

    if ($amountToWithdraw > $promo->commission_available) {
        return back()->with('error', 'المبلغ المطلوب سحبه أكثر من المبلغ المتاح.');
    }

    // تحقق من وجود عنوان محفظة
    if (!$influencer->wallet_address) {
        return back()->with('error', 'يرجى إضافة عنوان محفظتك أولاً.');
    }

    if ($amountToWithdraw < 1.0) {
    return back()->with('error', 'الحد الأدنى للسحب هو 1 دولار.');
}

// قبل إرسال الطلب
$orderId = uniqid('inf_');

// إرسال الطلب إلى NowPayments
$nowPaymentsApiKey = 'M024JEP-MQ2MTRQ-JV0XQWG-KD5E712';
$response = Http::withHeaders([
    'x-api-key' => $nowPaymentsApiKey,
])->post('https://api.nowpayments.io/v1/payment', [
    'price_amount'     => $amountToWithdraw,
    'price_currency'   => 'USD',           // أو $request->price_currency
    'pay_currency'     => 'usdttrc20',      // أو $request->pay_currency
    'ipn_callback_url' => route('nowpayments.influencer.webhook'),
    'order_id'         => $orderId,
    'pay_address'      => $influencer->wallet_address,
]);

\Log::error('NowPayments error response:', ['body' => $response->body()]);

if (!$response->successful()) {
    \Log::error('NowPayments error:', $response->json());
    return back()->with('error', 'حدث خطأ أثناء الاتصال بـ NowPayments.');
}


$data = $response->json();
\Log::info('NowPayments Withdraw Response:', $data);


// تحقق من نجاح الطلب ووجود payment_id
if (!isset($data['payment_id'])) {
    return back()->with('error', 'فشل في إنشاء عملية الدفع. تأكد من إعدادات NowPayments.');
}

// بعد التأكد من النجاح:
InfluencerWithdrawal::create([
    'influencer_id'   => $influencer->id,
    'order_id'        => $orderId,
    'amount'          => $amountToWithdraw,
    'price_currency'  => 'USDT',
    'pay_currency'    => 'usdttrc20',
    'pay_address'     => $influencer->wallet_address,
    'withdrawn_at'    => now(),
    'status'          => 'pending',
    'payment_id'      => $data['payment_id'],
]);

    // خصم المبلغ من العمولة المتاحة
    $promo->commission_withdrawn += $amountToWithdraw;
    $promo->commission_available = $promo->commission_earned - $promo->commission_withdrawn;
    $promo->save();

    return back()->with('success', 'تم إرسال طلب السحب بنجاح، في انتظار المعالجة.');
}


public function handleInfluencerWebhook(Request $request)
{
    $paymentId     = $request->input('payment_id');
    $paymentStatus = $request->input('payment_status'); // e.g. "finished", "failed"

    $withdrawal = InfluencerWithdrawal::where('payment_id', $paymentId)->first();
    if (!$withdrawal) return response('Not Found', 404);

    // عند النجاح
    if ($paymentStatus === 'finished') {
        $withdrawal->status = 'completed';
    }
    // عند الفشل
    elseif (in_array($paymentStatus, ['failed','expired'])) {
        $withdrawal->status = 'failed';
        // (اختياري) يمكنك هنا ترجيع المبلغ للمؤثر بإعادة تحديث commission_available
    }
    $withdrawal->save();

    return response('OK', 200);
}



    // تسجيل الخروج
    public function logout()
    {
        session()->forget('influencer_id');
        return redirect()->route('influencer.login');
    }
}
