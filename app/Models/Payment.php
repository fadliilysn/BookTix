<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_type',
        'transaction_status',
        'raw_response',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
