<?php

namespace App\Http\Livewire\Pos;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public $products = [];
    public $total = 0;
    public $selected = null;
    public $screen = 'main'; // main, edit, type, cash, card
    public $updatedQuantity = null;
    public $paymentType = null;
    public $cash = 0;
    public $card = null;

    protected $listeners = ['addProduct', 'selectProduct'];

    public function getChangeProperty() {
        return $this->cash - $this->total;
    }

    public function selectProduct($id) {
        $this->selected = $id;
    }

    public function addProduct($product) {
        $this->products[$product['code']] = [
            'id' => $product['code'],
            'name' => $product['name'],
            'code' => $product['code'],
            'quantity' => 1,
            'price' => $product['price']
        ];
        $this->updateTotal();
    }

    public function editProduct() {
        if (! $this->selected) return;
        $this->updatedQuantity = $this->products[$this->selected]['quantity'];
        $this->screen = 'edit';
    }

    public function deleteProduct() {
        if (! $this->selected) return;
        $this->products = array_filter(
            $this->products,
            fn($k) => $k !== $this->selected,
            ARRAY_FILTER_USE_KEY
        );
        $this->updateTotal();
        $this->reset('selected');
    }

    public function sale() {
        if ( count($this->products) === 0 ) return;
        $this->screen = 'type';
    }

    public function saveEdit() {
        $this->products[$this->selected]['quantity'] = $this->updatedQuantity;
        $this->updateTotal();
        $this->reset('updatedQuantity', 'selected');
        $this->screen = 'main';
    }

    public function discard() {
        $this->reset('updatedQuantity', 'selected', 'cash', 'paymentType', 'card');
        $this->screen = 'main';
    }

    public function paymentType($type) {
        $this->paymentType = $type;
        $this->screen = $type;
    }

    public function printReceipt($type) {
        dd('printing ' . $type . ' receipt.');
        // card details to upper case
    }

    private function updateTotal() {
        $this->total = array_reduce($this->products, fn($a, $p) => $a + ($p['price'] * $p['quantity']), 0);
    }

    public function render()
    {
        return view('livewire.pos.show');
    }
}
