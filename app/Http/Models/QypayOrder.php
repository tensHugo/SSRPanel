<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 订单
 * Class Order
 * @package App\Http\Models
 */
class QypayOrder extends Model
{
    protected $table = 'qypay_order';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'uid',
        'pay_id',
        'money',
        'price',
        'type',
        'pay_no',
        'param',
        'pay_time',
        'pay_tag',
        'status',
        'creat_time',
        'up_time',
        'updated_at',
        'created_at'
    ];
	
	 public function User()
    {
        return $this->hasOne(User::class, 'id', 'uid');
    }

 
}