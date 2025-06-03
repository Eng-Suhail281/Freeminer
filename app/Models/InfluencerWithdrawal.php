<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfluencerWithdrawal extends Model
{
    protected $fillable = [
        'influencer_id',
        'order_id',
        'amount',
        'price_currency',
        'pay_currency',
        'pay_address',
        'withdrawn_at',
        'status',
        'payment_id',
    ];

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }
}
