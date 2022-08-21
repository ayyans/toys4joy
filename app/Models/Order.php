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

    public function getFullAddressAttribute() {
        $address = '';
        if (!$this->user_id) {
            $address .= isset($this->additional_details['unit_no']) ? "Unit No: {$this->additional_details['unit_no']}" : '';
            $address .= isset($this->additional_details['building_no']) ? ", Building No: {$this->additional_details['building_no']}" : '';
            $address .= isset($this->additional_details['zone']) ? ", Zone: {$this->additional_details['zone']}" : '';
            $address .= isset($this->additional_details['street']) ? ", Street: {$this->additional_details['street']}" : '';
        }
        return $address;
    }

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

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }
}
