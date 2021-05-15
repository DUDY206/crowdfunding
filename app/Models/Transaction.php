<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'order_id',
        'transaction_no',
        'amount',
        'bank_code',
        'card_type',
        'pay_date',
        'order_info',
        'response_code'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
