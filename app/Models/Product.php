<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'category_id',
        'brand_id',
        'unit',
        'min_qty',
        'sub_cat',
        'barcode',
        'featured_img',
        'video_provider',
        'videolink',
        'unit_price',
        'discount',
        'price_discount_unit',
        'points',
        'qty',
        'sku',
        'short_desc',
        'long_desc',
        'shiping_type',
        'mul_prod_qty',
        'low_qty_warning',
        'stock_visibilty',
        'featured_status',
        'todays_deal',
        'shiping_time',
        'tax',
        'tax_unit',
        'vat',
        'vat_unit',
        'recommended_age'
    ];

    public function formatRecommendedAge($age) {
        $years = floor($age / 12);
        $months = $age % 12;
        $result = $years >= 1 ? $years . ($years == 1 ? ' year' : ' years') : '';
        $result .= $years >= 1 && $months >= 1 ? ' ' : '';
        $result .= $months >= 1 ? $months . ($months == 1 ? ' month' : ' months') : '';
        return $result;
    }
}
