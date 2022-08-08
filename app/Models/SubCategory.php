<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'subcat_name',
        'parent_cat',
        'icon'
    ];

    public function parentCategory() {
        return $this->belongsTo(Category::class, 'parent_cat', 'id');
    }
}
