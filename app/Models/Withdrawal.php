<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    // إضافة 'influencer_id' إلى الـ fillable
    protected $fillable = [
        'influencer_id',
        'amount',
        'withdrawn_at',
    ];

    // علاقة مع موديل Influencer
    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }
}
