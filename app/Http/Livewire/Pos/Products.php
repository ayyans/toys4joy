<?php

namespace App\Http\Livewire\Pos;

use App\Models\POSProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Products extends Component
{
    public $search;

    public function getProductsProperty()
    {
        // return POSProduct::all();
        return Product::select('id', 'title as name', DB::raw('case when discount = 0 then unit_price else discount end as price'), 'sku as code')
            ->where('title', 'LIKE', "%$this->search%")
            ->orWhere('barcode', 'LIKE', "%$this->search%")
            ->orWhere('sku', 'LIKE', "%$this->search%")
            ->limit(16)
            ->get();
    }

    public function render()
    {
        return view('livewire.pos.products');
    }
}
