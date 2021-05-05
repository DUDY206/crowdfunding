<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'account_id',
        'invest_id',
        'contract_url',
        'invest_type_id',
        'is_signature',
        'signature',
        'amount',
        'payment_method',
        'payment_status'
    ];

    protected $with = [
        'user'
    ];

    protected $appends = [
        'pay_method',
        'pay_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'account_id', 'id');
    }

    public function getamountAttribute($value)
    {
        return $value + 0;
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y h:m:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y h:m:s', strtotime($value));
    }

    public function getPayMethodAttribute()
    {
        $method = '';

        if ($this->payment_method == 1) {
            $method = 'VNpay';
        } else {
            $method = 'Chuyển khoản sau';
        }

        return $method;
    }

    public function getPayStatusAttribute()
    {
        $status = '';

        if ($this->payment_status == 1) {
            $status = 'Đang xác nhận thông tin';
        }

        if ($this->payment_status == 2) {
            $status = 'Đang chờ thanh toán';
        }

        if ($this->payment_status == 3) {
            $status = 'Đã thanh toán';
        }

        return $status;
    }
}
