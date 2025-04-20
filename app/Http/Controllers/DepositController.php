<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class DepositController extends Controller
{
    // 1. صفحة الإيداع
    public function index(Request $request)
    {
        $telegramId = $request->telegram_id ?? session('telegram_id');
        return view('deposit.deposit', compact('telegramId'));
    }

    // 2. معالجة الدفع (اختيار الطريقة أو NowPayments)
    public function handlePay(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'telegram_id' => 'required|string',
            'method' => 'required|string|in:tron,bnb,litecoin,ton,nowpayments',
        ]);

        if ($request->method === 'nowpayments') {
            return $this->createNowPayment($request);
        }

        session([
            'deposit_amount' => $request->amount,
            'payment_method' => $request->method,
        ]);

        return redirect()->route('deposit.paymentmethods');
    }

    // 3. صفحة طرق الدفع اليدوية
    public function paymentMethods()
    {
        $methods = [
            'tron' => 'TRON (TRC20)',
            'ton' => 'TON',
            'btc' => 'Bitcoin (BTC)',
            'usdc' => 'USDC (ERC20)',
            'ethereum' => 'Ethereum (ERC20)',
            'usdt' => 'USDT (TRC20)',
            'litecoin' => 'Litecoin (LTC)',
            'bnb' => 'BNB (BEP20)',
        ];

        return view('deposit.paymentmethods', compact('methods'));
    }

    // 4. إنشاء دفعة NowPayments
    public function createNowPayment(Request $request)
    {
        $telegramId = $request->input('telegram_id');
        $amount = $request->input('amount') ?? session('deposit_amount');
        $paymentMethod = $request->input('payment_method') ?? session('payment_method');

        $user = User::where('telegram_id', $telegramId)->first();

        // أثناء التطوير فقط: استخدام مستخدم تجريبي في بيئة local
        if (!$user && app()->environment('local')) {
            $user = User::find(1);
            $telegramId = $user?->telegram_id ?? '123456';
        }

        if (!$user) {
            return back()->with('error', 'المستخدم غير موجود.');
        }

        $orderId = $telegramId;

        $response = Http::withHeaders([
            'x-api-key' => env('NOWPAYMENTS_API_KEY'),
        ])->post('https://api.nowpayments.io/v1/invoice', [
            'price_amount' => $amount,
            'price_currency' => 'USD',
            'pay_currency' => 'USDTTRC20',
            'order_id' => $orderId,
            'order_description' => 'Deposit for ' . $user->name,
            'ipn_callback_url' => route('nowpayments.callback'),
            'success_url' => route('deposit.success'),
            'cancel_url' => route('deposit.cancel'),
        ]);

        $data = $response->json();

        if (isset($data['invoice_url'])) {
            Payment::create([
                'user_id' => $user->id,
                'telegram_id' => $telegramId,
                'amount' => $amount,
                'method' => 'nowpayments',
                'status' => 'pending',
                'order_id' => $orderId,
            ]);

            return redirect($data['invoice_url']);
        }

        return back()->with('error', 'فشل إنشاء رابط الدفع: ' . ($data['message'] ?? ''));
    }

    // 5. معالجة الطلب اليدوي المباشر (مثل /form/btc)
    public function form(Request $request, $method)
    {
        $amount = $request->input('amount');
        $telegramId = $request->input('telegram_id');

        if (!$telegramId || !$amount) {
            return redirect()->route('deposit.deposit')->with('error', 'Missing data');
        }

        // نعيد بناء الريكوست لتمريره لـ createNowPayment
        $newRequest = new Request([
            'payment_method' => $method,
            'amount' => $amount,
            'telegram_id' => $telegramId,
        ]);

        return $this->createNowPayment($newRequest);
    }

    // 6. Webhook من NowPayments
    public function handleNowPayments(Request $request)
    {
        if ($request->payment_status === 'finished') {
            $telegramId = $request->order_id;
            $amount = $request->price_amount;

            $gpu = $amount * 10000;

            $user = User::where('telegram_id', $telegramId)->first();
            if (!$user) return;

            if (!$user->has_deposited) {
                $gpu += $gpu * 0.20; // مكافأة 20%
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

            // تحديث رصيد الطاقة
            $user->gpu_power += $gpu;
            $user->save();

            // تحديث حالة الدفع
            Payment::where('telegram_id', $telegramId)
                ->where('status', 'pending')
                ->latest()
                ->first()
                ?->update(['status' => 'completed']);

            // إشعار المستخدم
            $this->sendTelegramMessage(
                $telegramId,
                "✅ تم معالجة دفعتك بقيمة {$amount}$ بنجاح، وتمت إضافة الطاقة إلى حسابك."
            );
        }
    }
}
