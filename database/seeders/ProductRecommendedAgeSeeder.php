<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductRecommendedAgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $str = $product->unit;
            if (strpos($str, 'Recommended Age') !== false) {
                preg_match_all('/\d+ month.|\d+ year.|\d+ to \d+ year.|\d+ to \d+ month./', $str, $matches);
                $result = PHP_INT_MAX;
                foreach ($matches[0] as $match) {
                    if (preg_match('/\d+ to \d+ year./', $match)) {
                        preg_match_all('/\d+/', $match, $numbers);
                        $value = min($numbers[0]) * 12;
                    } else if (preg_match('/\d+ to \d+ month./', $match)) {
                        preg_match_all('/\d+/', $match, $numbers);
                        $value = min($numbers[0]);
                    } else if (preg_match('/\d+ year./', $match)) {
                        preg_match('/\d+/', $match, $year);
                        $value = $year[0] * 12;
                    } else if (preg_match('/\d+ month./', $match)) {
                        preg_match('/\d+/', $match, $month);
                        $value = $month[0];
                    }
                    $result = $value < $result ? $value : $result;
                }
                $product->update([
                    'recommended_age' => $result == PHP_INT_MAX ? null : $result
                ]);
            }
        }
    }
}
