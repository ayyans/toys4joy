<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'prod_id',
        'qty',
        'cust_name',
        'cust_email',
        'cust_mobile',
        'city',
        'state',
        'apartment',
        'faddress',
        'payment_id',
        'mode'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'prod_id', 'id');
    }
}
