<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubCategory extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable=[
        'subcat_name',
        'parent_cat',
        'icon'
    ];

    public $translatable = ['subcat_name'];

    public function parentCategory() {
        return $this->belongsTo(Category::class, 'parent_cat', 'id');
    }
}
