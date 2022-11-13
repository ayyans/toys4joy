<?php

namespace App\Http\Livewire\Local\Pos;

use App\Models\Product;
use Livewire\Component;

class Products extends Component
{

    public function getProductsProperty()
    {
        return Product::select('id', 'title as name', 'unit_price as price', 'sku as code')->limit(8)->get();
    }

    public function render()
    {
        return view('livewire.local.pos.products');
    }
}
