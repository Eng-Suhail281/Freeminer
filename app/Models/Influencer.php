<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'promo_code_id',
        'promo_code', 
        'wallet_address',
    ];

    protected $hidden = [
        'password',
    ];

    // ربط المؤثر بالأكواد الترويجية التي تخصه
    public function promoCodes()
    {
        return $this->hasMany(PromoCode::class);
    }
}
