<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdAttr extends Model
{
    use HasFactory;
    protected $fillable = [
        'prod_id',
        'attr_id',
        'attrval_id'
    ];
}
