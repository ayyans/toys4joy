<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'cust_id',
        'card_type',
        'card_holder_name',
        'card_no',
        'exp_month',
        'exp_year',
        'cvv'
    ];
}
