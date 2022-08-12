<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'additional_details' => 'json',
    ];

    // protected $fillable = [
    //     'cust_id',
    //     'cust_add_id',
    //     'cust_card_id',
    //     'prod_id',
    //     'qty',
    //     'amount',
    //     'payment_id',
    //     'mode'
    // ];

    // public static function getTotalAmount($order_id) {
    //     return self::where('orderid', $order_id)->sum('amount');
    // }

    // public function product() {
    //     return $this->belongsTo(Product::class, 'prod_id', 'id');
    // }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function address() {
        return $this->belongsTo(CustomerAddress::class, 'address_id');
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function giftcards() {
        return $this->hasMany(giftcards::class);
    }
}
