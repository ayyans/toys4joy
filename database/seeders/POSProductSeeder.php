<?php

namespace Database\Seeders;

use App\Models\POSProduct;
use Illuminate\Database\Seeder;

class POSProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Lusail Stadium',
                'arabic_name' => 'استاد لوسيل',
                'price' => 99,
                'code' => 'DD00008'
            ],
            [
                'name' => 'Al Thumama Stadium',
                'arabic_name' => 'استاد الثمامة',
                'price' => 99,
                'code' => 'DD00009'
            ],
            [
                'name' => 'Khalifa International Stadium',
                'arabic_name' => 'استاد خليفة الدولي',
                'price' => 99,
                'code' => 'DD00010'
            ],
            [
                'name' => 'Ahmad Bin Ali Stadium',
                'arabic_name' => 'استاد احمد بن علي',
                'price' => 99,
                'code' => 'DD00011'
            ],
            [
                'name' => 'Education City Stadium',
                'arabic_name' => 'استاد المدينة التعليمية',
                'price' => 99,
                'code' => 'DD00012'
            ],
            [
                'name' => 'Al Janoub Stadium',
                'arabic_name' => 'استاد الجنوب',
                'price' => 99,
                'code' => 'DD00013'
            ],
            [
                'name' => 'Al Bayt Stadium',
                'arabic_name' => 'استاد البيت',
                'price' => 99,
                'code' => 'DD00014'
            ],
            [
                'name' => 'Stadium 974',
                'arabic_name' => 'الاستاد 974',
                'price' => 99,
                'code' => 'DD00015'
            ],
            [
                'name' => '8 Qatar Stadiums',
                'arabic_name' => '8 ملاعب قطر',
                'price' => 699,
                'code' => 'BPSTADIUMS'
            ],
        ];

        foreach ($products as $product) {
            $pos_product = POSProduct::firstOrCreate(
                [
                    'code' => $product['code']
                ],
                [
                    'name' => $product['name'],
                    'price' => $product['price']
                ]
            );
            $pos_product->update(['arabic_name' => $product['arabic_name']]);
        }
    }
}
