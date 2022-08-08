<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'cust_id',
        'unit_no',
        'building_no',
        'zone',
        'street',
        'faddress'
    ];
}
