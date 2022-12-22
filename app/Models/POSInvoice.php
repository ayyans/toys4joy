<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSInvoice extends Model
{
    use HasFactory;

    protected $table = 'pos_invoices';

    protected $fillable = ['invoice_number', 'instance', 'type', 'method', 'quantity', 'total', 'discount', 'final', 'cash', 'change', 'name', 'phone', 'card'];

    public function scopeSale($query) {
        return $query->where('type', 'sale');
    }

    public function scopeRefund($query) {
        return $query->where('type', 'refund');
    }

    public function scopeToday($query) {
        return $query->whereDate('created_at', today());
    }

    public function products() {
        return $this->hasMany(POSInvoiceProduct::class, 'invoice_id');
    }
}
