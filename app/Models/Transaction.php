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

    protected $hidden = [
        'created_at',
        'updated_at',
        'pay_date',
    ];

    protected $appends = [
        'format_amount',
        'format_created_at',
        'format_updated_at',
        'format_pay_date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getFormatAmountAttribute()
    {
        return $this->amount + 0;
    }

    public function getFormatCreatedAtAttribute()
    {
        return date('h:m:s d/m/Y', strtotime($this->created_at));
    }

    public function getFormatUpdatedAtAttribute()
    {
        return date('h:m:s d/m/Y', strtotime($this->updated_at));
    }

    public function getFormatPayDateAttribute()
    {
        return date('h:m:s d/m/Y', strtotime($this->pay_date));
    }
}
