<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'category_name',
        'category_type',
        'cat_banner',
        'cat_icon',
    ];

    public $translatable = ['category_name'];
}
