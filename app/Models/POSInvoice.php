<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSInvoice extends Model
{
    use HasFactory;

    protected $table = 'pos_invoices';

    protected $fillable = ['invoice_number', 'type', 'method', 'quantity', 'total'];

    public function products() {
        return $this->hasMany(POSInvoiceProduct::class, 'invoice_id');
    }
}
