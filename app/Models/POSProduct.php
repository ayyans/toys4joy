<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSProduct extends Model
{
    use HasFactory;

    protected $table = 'pos_products';

    protected $fillable = ['name', 'arabic_name', 'price', 'code'];

    public function sales() {
        return $this->hasMany(POSInvoiceProduct::class, 'product_id')
            ->whereHas('invoice', fn ($q) => $q->where('type', 'sale'));
    }

    public function refunds() {
        return $this->hasMany(POSInvoiceProduct::class, 'product_id')
            ->whereHas('invoice', fn ($q) => $q->where('type', 'refund'));
    }
}
