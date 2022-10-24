<?php

namespace App\Http\Livewire\Pos;

use App\Models\Product;
use Livewire\Component;

class Products extends Component
{
    public function render()
    {
        return view('livewire.pos.products', [
            'products' => Product::active()->paginate(50)
        ]);
    }
}
