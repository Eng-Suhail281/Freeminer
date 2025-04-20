<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EarnController extends Controller
{
    // عرض صفحة الإحالة مع رابط الإحالة والمكافآت
    public function index(Request $request)
    {
        // الحصول على المستخدم الحالي
        $user = auth()->user();

        // التأكد من أن المستخدم مسجل دخول
        if ($user) {
            // توليد رابط الإحالة
            $referral_link = route('register') . '?ref=' . $user->referral_code;

            // عدد الإحالات المباشرة (المستوى الأول)
            $level1 = User::where('referred_by', $user->id)->get();
            $level1Count = $level1->count();

            // المستوى الثاني: الأشخاص الذين تمت إحالتهم من قبل المستوى الأول
            $level2Count = User::whereIn('referred_by', $level1->pluck('id'))->count();

            // المستوى الثالث: الأشخاص الذين تمت إحالتهم من قبل المستوى الثاني
            $level2 = User::whereIn('referred_by', $level1->pluck('id'))->get();
            $level3Count = User::whereIn('referred_by', $level2->pluck('id'))->count();

            // حساب عمولة تجريبية (مثلاً 100 لكل إحالة مباشرة)
            $commission = $level1Count * 100;

        } else {
            // مستخدم غير مسجل دخول
            $referral_link = route('register');
            $level1Count = 0;
            $level2Count = 0;
            $level3Count = 0;
            $commission = 0;
        }

        return view('earn', compact(
            'referral_link',
            'level1Count',
            'level2Count',
            'level3Count',
            'commission'
        ));
    }

    public function increaseGpuForReferrer($referrerId)
    {
        $referrer = User::find($referrerId);
        if ($referrer) {
            $referrer->gpu_power += 200;
            $referrer->save();
        }
    }

    public function increaseGpuOnFirstDeposit($userId)
    {
        $user = User::find($userId);
        if ($user && !$user->has_deposited) {
            $user->gpu_power += 2500;
            $user->has_deposited = true;
            $user->save();
        }
    }
}
