<?php

namespace App\Http\Livewire\Pos;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public $products = [];
    public $total = 0;
    public $selected = null;

    protected $listeners = ['addProduct', 'selectProduct'];

    public function selectProduct($id) {
        $this->selected = $id;
    }

    public function addProduct(Product $product) {
        $this->products[$product->id] = [
            'id' => $product->id,
            'name' => $product->title,
            'code' => $product->sku,
            'quantity' => 1,
            'price' => $product->unit_price
        ];
        $this->updateTotal();
    }

    public function editProduct() {
        if (! $this->selected) return;
    }

    public function deleteProduct() {
        if (! $this->selected) return;
        $this->products = array_filter(
            $this->products,
            fn($k) => $k !== $this->selected,
            ARRAY_FILTER_USE_KEY
        );
        $this->updateTotal();
    }

    private function updateTotal() {
        $this->total = array_reduce($this->products, fn($a, $p) => $a + ($p['price'] * $p['quantity']), 0);
    }

    public function render()
    {
        return view('livewire.pos.show');
    }
}
