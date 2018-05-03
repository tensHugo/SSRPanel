<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ĺĺ
 * Class Goods
 * @package App\Http\Models
 */
class Goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'id';
    protected $fillable = [
        'sku',
        'name',
        'logo',
        'level',
        'traffic',
        'score',
        'type',
        'price',
        'desc',
        'days',
        'is_del',
        'status'
    ];

}