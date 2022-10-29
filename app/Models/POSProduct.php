<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSProduct extends Model
{
    use HasFactory;

    protected $table = 'pos_products';

    protected $fillable = ['name', 'price', 'code'];
}
