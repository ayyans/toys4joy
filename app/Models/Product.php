<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function formatRecommendedAge($age) {
        $years = floor($age / 12);
        $months = $age % 12;
        $result = $years >= 1 ? $years . ($years == 1 ? ' year' : ' years') : '';
        $result .= $years >= 1 && $months >= 1 ? ' ' : '';
        $result .= $months >= 1 ? $months . ($months == 1 ? ' month' : ' months') : '';
        return $result ?: '0 month';
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

    public function paidOrderItems() {
        return $this->hasMany(OrderItem::class, 'product_id')->whereHas('order', function($query) {
            $query->where('payment_status', 'paid')->where('additional_details->is_abandoned', false);
        });
    }
}
