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
            'hashes' => 0.00000, // ← إضافة هذا السطر
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



// App\Http\Controllers\MinerController.php
public function startMining(Request $request)
{
    $request->validate([
        'telegram_id' => 'required|numeric'
    ]);

    $user = User::where('telegram_id', $request->telegram_id)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // تحقق إذا كان المستخدم بالفعل يعمل على التعدين، لا تقم بإعادة التحديث
    if ($user->is_mining) {
        return response()->json(['message' => 'Already mining']);
    }

    $user->is_mining = 1;
    $user->mining_started_at = now();
    $user->gpu_power_at_start = $user->gpu_power;
    $user->save();

    return response()->json(['success' => true]);
}






public function getMiningData(Request $request)
{
    $user = auth()->user();

    if (!$user->mining_started_at || !$user->gpu_power_at_start) {
        return response()->json(['hashes' => $user->hashes, 'mining' => false]);
    }

    $hoursPassed = now()->diffInSeconds($user->mining_started_at) / 3600;
    if ($hoursPassed >= 12) {
        return response()->json(['hashes' => $user->hashes, 'mining' => false]);
    }

    $hashesGenerated = $hoursPassed * $user->gpu_power_at_start;
    return response()->json([
        'hashes' => floor($user->hashes + $hashesGenerated),
        'mining' => true
    ]);
}

public function stopAndSync(Request $request)
{
    $user = auth()->user();

    if (!$user->mining_started_at || !$user->gpu_power_at_start) {
        return response()->json(['success' => false]);
    }

    $hoursPassed = now()->diffInSeconds($user->mining_started_at) / 3600;
    $hashesGenerated = $hoursPassed * $user->gpu_power_at_start;

    $user->hashes += floor($hashesGenerated);
    $user->mining_started_at = null;
    $user->gpu_power_at_start = 0;
    $user->save();

    return response()->json(['success' => true, 'hashes' => $user->hashes]);
}



private function mine($user)
{
    $gpuPower = $user->gpu_power;
    $hashesPerMinute = $gpuPower * 0.1; // حساب عدد الهاشات لكل دقيقة بناءً على القوة

    // بدء التعدين على مدار الوقت المحدد
    $endTime = now()->addMinutes(8 * 60);
    while (now()->lt($endTime)) {
        // حساب الهاشات التي يتم توليدها في هذه الدقيقة
        $user->hashes += $hashesPerMinute;
        $user->save();

        // الانتظار لمدة دقيقة قبل التحديث التالي
        sleep(60);
    }

    // بعد انتهاء التعدين، التوقف عن تحديث الهاشات
}


// التحقق من حالة التعدين
public function miningStatus(Request $request)
{
    
    $user = User::where('telegram_id', $telegram_id)->first();

    if (!$user || !$user->mining_started_at) {
        return response()->json(['status' => 'not_mining']);
    }

    // هل ما زال التعدين فعالًا؟
    if (now()->diffInHours($user->mining_started_at) < 12) {
        return response()->json([
            'status' => 'mining',
            'mining_started_at' => $user->mining_started_at,
            'gpu_power_at_start' => $user->gpu_power_at_start,
            'hashes' => floor($user->hashes),
        ]);
    }

    return response()->json(['status' => 'not_mining']);
}


// تحديث الهاشات للمستخدم
public function updateHashes(Request $request)
{
    $user = User::where('telegram_id', $request->telegram_id)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $user->hashes = $request->hashes;
    $user->save();

    return response()->json(['success' => true]);
}


// تحويل الهاشات إلى FMT
public function exchangeHashes(Request $request)
{
    $telegramId = session('telegram_id');
    $user = User::where('telegram_id', $telegramId)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // استرجاع الهاشات الفعلية من قاعدة البيانات
    $userHashes = $user->hashes;

    // تأكد أن الهاشات كافية للتبادل
    if ($userHashes < 3) {
        return response()->json(['error' => 'At least 3 hashes required'], 400);
    }

    // حساب المبلغ بناءً على الهاشات
    $fmtAmount = $userHashes / 100;

    // تحديث رصيد المستخدم
    $user->balance += $fmtAmount;
    $user->hashes = 0; // أو تخصم الهاشات التي تم تحويلها
    $user->save();

    return response()->json([
        'success' => true,
        'balance' => $user->balance,
        'exchanged_hashes' => $userHashes
    ]);
}
// الحصول على رصيد المستخدم
public function getBalance(Request $request)
{
    $telegramId = session('telegram_id');
    $user = User::where('telegram_id', $telegramId)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    return response()->json([
        'balance' => number_format($user->balance, 2),
    ]);
}
    
// app/Http/Controllers/UserController.php

public function getHashes($telegram_id)
{
    $user = User::where('telegram_id', $telegram_id)->first();
    if (!$user) return response()->json(['hashes' => 0]);

    return response()->json(['hashes' => round($user->hashes, 5)]);
}

}
