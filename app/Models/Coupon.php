<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'coupontype',
        'coupon_title',
        'coupon_code',
        'exp_date',
        'offer',
        'desc'
    ];
}
