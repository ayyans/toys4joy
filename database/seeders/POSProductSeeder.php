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
                'price' => 99,
                'code' => 'DD00008'
            ],
            [
                'name' => 'Al Thumama Stadium',
                'price' => 99,
                'code' => 'DD00009'
            ],
            [
                'name' => 'Khalifa International Stadium',
                'price' => 99,
                'code' => 'DD00010'
            ],
            [
                'name' => 'Ahmad Bin Ali Stadium',
                'price' => 99,
                'code' => 'DD00011'
            ],
            [
                'name' => 'Education City Stadium',
                'price' => 99,
                'code' => 'DD00012'
            ],
            [
                'name' => 'Al Janoub Stadium',
                'price' => 99,
                'code' => 'DD00013'
            ],
            [
                'name' => 'Al Bayt Stadium',
                'price' => 99,
                'code' => 'DD00014'
            ],
            [
                'name' => 'Stadium 974',
                'price' => 99,
                'code' => 'DD00015'
            ],
            [
                'name' => '8 Qatar Stadiums',
                'price' => 699,
                'code' => 'BPSTADIUMS'
            ],
        ];

        foreach ($products as $product) {
            POSProduct::firstOrCreate(
                [
                    'code' => $product['code']
                ],
                [
                    'name' => $product['name'],
                    'price' => $product['price']
                ]
            );
        }
    }
}
