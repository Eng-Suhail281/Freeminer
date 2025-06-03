<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MinerController extends Controller
{
    // عرض صفحة التعدين
    public function show()
    {
        // تحديد telegram_id يدويًا أثناء الاختبار المحلي
        session(['telegram_id' => 123456789]); // استبدل بالـ telegram_id الخاص بك
        $telegramId = session('telegram_id');

        // البحث عن المستخدم باستخدام telegram_id
        $user = User::where('telegram_id', $telegramId)->first();

        if (!$user) {
            abort(403, 'User not found.');
        }

        return view('miner', [
            'user' => $user,
            'userHashes' => $user->hashes ?? 0
        ]);
    }

    // بدء عملية التعدين
    public function startMining(Request $request)
    {
        $request->validate([
            'telegram_id' => 'required'
        ]);
    
        $user = User::where('telegram_id', $request->telegram_id)->first();
    
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }
    
        // تحديد وقت انتهاء التعدين بعد 8 ساعات
        $durationInMinutes = 8 * 60;
        $endsAt = now()->addMinutes($durationInMinutes);
    
        // تخزين وقت انتهاء التعدين في قاعدة البيانات
        $user->mining_ends_at = $endsAt;
        $user->save();
    
        // بدء التعدين
        $this->mine($user); // نفذ التعدين بشكل مستمر
    
        return response()->json([
            'status' => 'started',
            'mining_ends_at' => $endsAt->timestamp
        ]);
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
    public function miningStatus($telegram_id)
    {
        $user = User::where('telegram_id', $telegram_id)->first();

        if (!$user || !$user->mining_ends_at) {
            return response()->json(['status' => 'not_mining']);
        }

        if (now()->lt($user->mining_ends_at)) {
            return response()->json([
                'status' => 'mining',
                'mining_ends_at' => $user->mining_ends_at->timestamp
            ]);
        }

        return response()->json(['status' => 'not_mining']);
    }

    // تحديث الهاشات للمستخدم
    public function updateHashes(Request $request)
    {
        $request->validate([
            'telegram_id' => 'required',
            'hashes' => 'required|integer|min:0',
        ]);

        $user = User::where('telegram_id', $request->telegram_id)->first();

        if ($user) {
            $user->hashes = $request->hashes;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }

    // تحويل الهاشات إلى FMT
    public function exchangeHashes(Request $request)
    {
        $telegramId = session('telegram_id');
        $user = User::where('telegram_id', $telegramId)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $hashes = floatval($request->hashes);
        if ($hashes < 3) {
            return response()->json(['error' => 'Minimum 3 hashes required'], 400);
        }

        // 100 Hashes = 1 FMT
        $rate = 100;
        $fmt = $hashes / $rate;
        $user->hashes = 0;

        // تحديث رصيد المستخدم
        $user->balance = $user->balance + $fmt;
        $user->save();

        return response()->json([
            'success' => true,
            'balance' => $user->balance,
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
}
