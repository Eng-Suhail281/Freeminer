<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MinerController extends Controller
{
    public function exchangeHashes(Request $request)
    {
        // مؤقتًا: اختبر على المستخدم ذي الـ ID = 1
        $user = User::find(1);
        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $hashes = floatval($request->hashes);
        if ($hashes < 3) {
            // لا يسمح بالتبادل أقل من 3 hashes
            return response()->json(['error' => 'Minimum 3 hashes required'], 400);
        }

        $rate = 100; // 100 Hashes = 1 FMT
        $fmt = $hashes / $rate;

        // تحديث الرصيد
        $user->balance = $user->balance + $fmt;
        $user->save(); // يحفظ التغيير في قاعدة البيانات

        // نعيد الرصيد كرقم عائم، ونقوم بالتنسيق في الواجهة
        return response()->json([
            'success' => true,
            'balance' => $user->balance,
        ]);
    }

    public function getBalance(Request $request)
    {
        // بافتراض أنك تحفظ telegram_id في session عند المصادقة
        $telegramId = session('telegram_id');
        $user = User::where('telegram_id', $telegramId)->first();

        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json([
            'balance' => number_format($user->balance, 2),
        ]);
    }
}
