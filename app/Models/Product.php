<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'linked_categories' => 'json',
    ];

    public function scopeActive($query) {
        $query->where('status', 2)->whereHas('brand', fn($q) => $q->where('status', 2));
    }

    public function getRewardPointsAttribute() {
        $qarInPoints = Setting::where('name', 'qar_in_points')->value('value') ?? 2;
        $price = $this->discount ?: $this->unit_price;
        return $price * $qarInPoints;
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subCategory() {
        return $this->belongsTo(SubCategory::class, 'sub_cat', 'id');
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function deliveredOrderItems() {
        return $this->hasMany(OrderItem::class, 'product_id')->whereHas('order', function($query) {
            $query->where('order_status', 'delivered');
        });
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'prod_id');
    }
}
