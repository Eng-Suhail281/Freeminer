<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'telegram_id' => 'required|unique:users',
            'username' => 'required|string|max:255',
            'referred_by' => 'nullable|string|exists:users,referral_code', // تحقق من صحة كود الإحالة (اختياري)
        ]);

        do {
            $referral_code = Str::random(10);
        } while (User::where('referral_code', $referral_code)->exists()); // كود إحالة عشوائي

        // إضافة المستخدم إلى قاعدة البيانات
        $user = User::create([
            'telegram_id' => $request->telegram_id,
            'username' => $request->username,
            'referral_code' => $referral_code, // إضافة كود الإحالة
            'referred_by' => $request->referred_by, // قد تكون null
        ]);

        return response()->json(['status' => 'success', 'user' => $user]);
    }


    public function generateReferralCode($telegram_id)
{
    // العثور على المستخدم باستخدام Telegram ID
    $user = User::where('telegram_id', $telegram_id)->first();

    if ($user) {
        // توليد كود إحالة جديد
        $referral_code = Str::random(10);
        $user->referral_code = $referral_code;
        $user->save();
        
        return response()->json(['referral_code' => $referral_code]);
    }

    return response()->json(['error' => 'User not found'], 404);
}


//عرض صفحة الearn
public function showEarnPage(Request $request)
{
    // Telegram ID اختياري: إذا ما وُجد، استخدم قيمة افتراضية للفحص
    $telegram_id = $request->query('telegram_id') ?? session('telegram_id') ?? '123456';

    // تأكد من حفظ الـ telegram_id في الجلسة
    session(['telegram_id' => $telegram_id]);

    // أنشئ المستخدم في قاعدة البيانات إذا لم يكن موجود
    $user = User::firstOrCreate(
        ['telegram_id' => $telegram_id],
        ['username' => 'test_user', 'referral_code' => \Illuminate\Support\Str::random(10)]
    );

    $referral_link = url('/register') . '?ref=' . $user->referral_code;

    return view('earn', compact('referral_link'));
}

public function transactionHistory(Request $request)
{
    $telegramId = $request->get('telegram_id'); // أو من session حسب الطريقة التي تستخدمها

    $transactions = Payment::where('telegram_id', $telegramId)
                            ->orderBy('created_at', 'desc')
                            ->get();

    return view('transaction-history', compact('transactions'));
}

}
