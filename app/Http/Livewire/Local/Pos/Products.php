<?php

namespace App\Http\Livewire\Local\Pos;

use App\Models\Product;
use Livewire\Component;

class Products extends Component
{
    public $search;

    public function getProductsProperty()
    {
        return Product::select('id', 'title as name', 'unit_price as price', 'sku as code')
            ->where('title', 'LIKE', "%$this->search%")
            ->orWhere('barcode', 'LIKE', "%$this->search%")
            ->orWhere('sku', 'LIKE', "%$this->search%")
            ->limit(8)
            ->get();
    }

    public function render()
    {
        return view('livewire.local.pos.products');
    }
}
