<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'cust_id',
        'cust_add_id',
        'cust_card_id',
        'prod_id',
        'qty',
        'amount',
        'payment_id',
        'mode'        
    ];
}
