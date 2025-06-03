<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\PromoCode;
use App\Models\InfluencerWithdrawal;

class DepositController extends Controller
{
    /**
     * خريطة تحويل قيمة الـ select إلى رموز يفهمها NowPayments
     */
    protected $currencyMap = [
        'usdt'     => 'USDTTRC20',
        'tron'     => 'TRX',
        'bnb'      => 'BNB',
        'litecoin' => 'LTC',
        'ton'      => 'TON',
    ];

    /**
     * 1. صفحة الإيداع
     */
    public function index(Request $request)
    {
        $telegramId = $request->telegram_id ?? session('telegram_id');
        return view('deposit.deposit', compact('telegramId'));
    }

    /**
     * 2. معالجة الدفع وتمريره مباشرةً لإنشاء دفعة NowPayments
     */
    public function handlePay(Request $request)
    {
        $data = $request->validate([
            'amount'      => 'required|numeric|min:1',
            'telegram_id' => 'required|string',
            'method'      => 'required|string|in:tron,bnb,litecoin,ton',
        ]);

        // نحول المفتاح 'method' إلى 'payment_method'
        $request->merge(['payment_method' => $data['method']]);

        // جميع الطرق تمرّ عبر NowPayments
        return $this->createNowPayment($request);
    }

    /**
     * 4. إنشاء دفعة على NowPayments
     */
    public function createNowPayment(Request $request)
    {
        $telegramId  = $request->input('telegram_id');
        $amount      = $request->input('amount');
        $methodKey   = $request->input('payment_method');
        $payCurrency = $this->currencyMap[$methodKey] ?? 'USDTTRC20';

        // جلب المستخدم
        $user = User::where('telegram_id', $telegramId)->first();

        // أثناء التطوير في local
        if (!$user && app()->environment('local')) {
            $user = User::find(1);
            $telegramId = $user?->telegram_id;
        }

        if (!$user) {
            return back()->with('error', 'المستخدم غير موجود.');
        }

        // إنشاء الفاتورة عبر API
        $response = Http::withHeaders([
            'x-api-key' => env('NOWPAYMENTS_API_KEY'),
        ])->post('https://api.nowpayments.io/v1/invoice', [
            'price_amount'      => $amount,
            'price_currency'    => 'USD',
            'pay_currency'      => $payCurrency,
            'order_id'          => $telegramId,
            'order_description' => 'Deposit for ' . $user->name,
            'ipn_callback_url'  => route('nowpayments.callback'),
            'success_url'       => route('deposit.success'),
            'cancel_url'        => route('deposit.cancel'),
        ]);

        $data = $response->json();

        if (!isset($data['invoice_url'])) {
            return back()->with('error', 'فشل إنشاء رابط الدفع: ' . ($data['message'] ?? ''));
        }

        // حفظ المدفوعات في الحالة pending
        Payment::create([
            'user_id'     => $user->id,
            'telegram_id' => $telegramId,
            'amount'      => $amount,
            'method'      => 'nowpayments',
            'status'      => 'pending',
            'order_id'    => $telegramId,
        ]);

        // إعادة التوجيه الخارجي إلى صفحة الدفع
        return redirect()->away($data['invoice_url']);
    }

    /**
     * 5. معاملة GET من /deposit/form/{method}
     */
    public function form(Request $request, $method)
    {
        $amount     = $request->input('amount');
        $telegramId = $request->input('telegram_id');

        if (!$telegramId || !$amount) {
            return redirect()->route('deposit.deposit')->with('error', 'Missing data');
        }

        // نبني طلبًا جديدًا لتوحيد المعالجة
        $newRequest = new Request([
            'payment_method' => $method,
            'amount'         => $amount,
            'telegram_id'    => $telegramId,
        ]);

        return $this->createNowPayment($newRequest);
    }

    /**
     * Webhook للمؤثرين
     */
    public function handleInfluencerWebhook(Request $request)
    {
        $paymentId     = $request->input('payment_id');
        $paymentStatus = $request->input('payment_status');

        $withdrawal = InfluencerWithdrawal::where('payment_id', $paymentId)->first();
        if ($withdrawal) {
            if ($paymentStatus === 'finished') {
                $withdrawal->status = 'completed';
            } elseif (in_array($paymentStatus, ['failed', 'expired'])) {
                $withdrawal->status = 'failed';
            }
            $withdrawal->save();
        }

        return response('OK');
    }

    /**
     * 6. Webhook من NowPayments
     */
    public function handleNowPayments(Request $request)
    {
        if ($request->payment_status === 'finished') {
            $telegramId = $request->order_id;
            $amount     = $request->price_amount;
            $gpu        = $amount * 10000;

            $user = User::where('telegram_id', $telegramId)->first();
            if (!$user) {
                return;
            }

            if (!$user->has_deposited) {
                $bonusGpu = $gpu * 0.20;
                $gpu += $bonusGpu;
                $user->has_deposited = true;

                if ($user->referred_by) {
                    $referrer = User::where('referral_code', $user->referred_by)->first();
                    if ($referrer) {
                        $referrer->gpu_power += 2500;
                        $referrer->save();
                        $this->sendTelegramMessage(
                            $referrer->telegram_id,
                            "🎉 لقد حصلت على 2500 GPU لأن أحد الأشخاص استخدم رابط الإحالة الخاص بك!"
                        );
                    }
                }
            }

            $user->deposit_amount += $amount;
            $user->gpu_power += $gpu;
            $user->save();

            if ($user->promo_code) {
                $promo = PromoCode::where('code', $user->promo_code)->first();
                if ($promo) {
                    $commission = $amount * 0.10;
                    $promo->commission_earned += $commission;
                    $promo->save();
                }
            }

            Payment::where('telegram_id', $telegramId)
                ->where('status', 'pending')
                ->latest()
                ->first()
                ?->update(['status' => 'completed']);

            $this->sendTelegramMessage(
                $telegramId,
                "✅ تم معالجة دفعتك بقيمة {$amount}$ بنجاح، وتمت إضافة الطاقة إلى حسابك."
            );
        }
    }
}
