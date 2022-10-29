<?php

namespace App\Http\Livewire\Pos;

use App\Models\POSProduct;
use Livewire\Component;

class Products extends Component
{

    public function getProductsProperty()
    {
        return POSProduct::all();
    }

    public function render()
    {
        return view('livewire.pos.products');
    }
}
