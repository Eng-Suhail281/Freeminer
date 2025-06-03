<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'description',
        'reward',
        'commission_rate',
        'total_users',
        'total_deposit_users',
        'total_deposit_amount',
    ];

    // 1) علاقة المستخدمين الذين استخدموا الكود (Users.promo_code → PromoCode.code)
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'promo_code', 'code');
    }

    // 2) علاقة المدفوعات التي قام بها هؤلاء المستخدمون (hasManyThrough)
    public function userPayments(): HasManyThrough
    {
        return $this->hasManyThrough(
            \App\Models\Payment::class,  // جدول المدفوعات
            \App\Models\User::class,     // جدول المستخدمين
            'promo_code',                // المفتاح في users يشير إلى promo_codes.code
            'telegram_id',               // المفتاح في payments يشير إلى users.telegram_id
            'code',                      // المفتاح المحلي في promo_codes
            'telegram_id'                // المفتاح المحلي في users
        );
    }
}
