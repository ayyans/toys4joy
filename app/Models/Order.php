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

    public static function getTotalAmount($order_id) {
        return self::where('orderid', $order_id)->sum('amount');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'prod_id', 'id');
    }

    public function address() {
        return $this->belongsTo(CustomerAddress::class, 'cust_add_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(User::class, 'cust_id', 'id');
    }
}
