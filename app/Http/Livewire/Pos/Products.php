<?php

namespace App\Http\Livewire\Pos;

use App\Models\Product;
use Livewire\Component;

class Products extends Component
{

    public function getProductsProperty()
    {
        return [
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
    }

    public function render()
    {
        return view('livewire.pos.products');
    }
}
