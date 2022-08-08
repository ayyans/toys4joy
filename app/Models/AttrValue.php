<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttrValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'attr_id',
        'attr_value'
    ];
}
