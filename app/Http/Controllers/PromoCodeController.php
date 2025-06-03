<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromoCode;
use App\Models\Influencer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PromoCodeController extends Controller
{
    // 1. عرض قائمة الأكواد
    public function index(Request $request)
{
    $codes = PromoCode::withCount([
                        'users',
                        'users as deposit_users_count' => function ($q) {
                            $q->where('has_deposited', true);
                        },
                    ])
                    // هنا نضيف withSum على علاقة users وحقل deposit_amount
                    ->withSum('users', 'deposit_amount')
                    ->paginate(10);

    return view('admin.promo_codes.index', compact('codes'));
}

    

    // 2. عرض صفحة الإنشاء
    public function create()
    {
        return view('admin.promo_codes.create');
    }

    // 3. معالجة الحفظ
    public function store(Request $request)
    {
        $request->validate([
            'code'                  => 'required|unique:promo_codes,code',
            'description'           => 'nullable|string',
            'influencer_name'   => 'required|string|unique:influencers,name',
            'influencer_email'      => 'required|email|unique:influencers,email',
            'influencer_password'   => 'required|string|min:6',
            'wallet_address' => 'nullable|string',
        ]);

        // إنشاء الكود
        $promoCode = PromoCode::create([
            'code' => $request->code,
            'description' => $request->description,
            'reward' => 1000,
            'commission' => 0.10,
            'total_users' => 0,
            'total_deposit_users' => 0,
            'total_deposit_amount' => 0,
        ]);
        $promoCode->refresh(); // <- يجلب القيم المحدثة من قاعدة البيانات
        // فقط للتأكيد: تأكد من وجود الكود
        if (!$promoCode->code) {
            return back()->with('error', 'فشل في حفظ كود الإحالة. الرجاء المحاولة مجددًا.');
        }
        
        
        
        // إنشاء المؤثر وربطه
        Influencer::create([
            'name'      => $request->influencer_name,
            'email'         => $request->influencer_email,
            'password'      => Hash::make($request->influencer_password),
            'promo_code_id' => $promoCode->id,
            'promo_code' => $promoCode->code, // تأكد أنك تضع الكود النصي
            'wallet_address' => $request->wallet_address,

        ]);

        return redirect()
            ->route('admin.promo-codes.index')
            ->with('success', 'تم إنشاء الكود والمؤثر بنجاح.');
    }
    // عرض صفحة التعديل
public function edit($id)
{
    $promoCode = PromoCode::findOrFail($id);
    return view('admin.promo_codes.edit', compact('promoCode'));
}

// تنفيذ التعديل
public function update(Request $request, $id)
{
    
    $request->validate([
        'code' => 'required|string|unique:promo_codes,code,' . $id,
        'description' => 'nullable|string',
        
    ]);

    $promoCode = PromoCode::findOrFail($id);
    $promoCode->update([
        'code' => $request->code,
        'description' => $request->description,
        'reward' => 1000,
        'commission' => 0.10,
    ]);

    return redirect()->route('admin.promo-codes.index')->with('success', 'تم تعديل الكود بنجاح');
}

// حذف الكود
public function destroy($id)
{
    $promoCode = PromoCode::findOrFail($id);
    $promoCode->delete();

    return redirect()->route('admin.promo-codes.index')->with('success', 'تم حذف الكود بنجاح');
}

public function users($id)
{
    $promoCode = PromoCode::with('users')->findOrFail($id);
    return view('admin.promo_codes.users', compact('promoCode'));
}


}
