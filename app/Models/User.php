<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Deposit;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'telegram_id',
    'username',
    'balance',
    'gpu_power',
    'hashes',
     'referred_by', 
     'referral_code'
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    

    public function payments()
{
    return $this->hasMany(Payment::class, 'user_id' , 'id');
}

// الكود الذي استخدمه هذا المستخدم
public function promoCode(): BelongsTo
{
    return $this->belongsTo(PromoCode::class, 'promo_code', 'code');
}

// إذا كان المؤثر، الأكواد التي أنشأها
public function deposits(): HasMany
{
    return $this->hasMany(Deposit::class);
}

// إذا أردت علاقة سريعة لجلب ما إذا كان المستخدم قد أودع عبر هذا الكود:
public function promoDeposits()
{
    return $this->deposits()->whereNotNull('amount');
}

}
