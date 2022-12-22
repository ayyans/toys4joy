<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSInvoiceProduct extends Model
{
    use HasFactory;

    protected $table = 'pos_invoice_products';

    protected $fillable = ['invoice_id', 'product_id', 'price', 'quantity', 'total'];

    public function invoice() {
        return $this->belongsTo(POSInvoice::class, 'invoice_id');
    }

    public function pos_product() {
        return $this->belongsTo(POSProduct::class, 'product_id');
    }

    public function website_product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
