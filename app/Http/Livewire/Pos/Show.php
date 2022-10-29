<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;

class Show extends Component
{
    public $products = [];
    public $selected = null;
    public $screen = 'main'; // main, edit, type, cash, card
    public $updatedQuantity = null;
    public $paymentType = null;
    public $cash = 0;
    public $card = ['name' => null, 'type' => null, 'number' => null];
    public $isRefund = false;
    public $adminPassword = '12345678';
    public $password = null;
    public $authRedirect = null;
    public $isPasswordError = false;

    protected $listeners = ['addProduct', 'selectProduct'];

    public function getChangeProperty() {
        return $this->cash - $this->total;
    }

    public function getTotalProperty() {
        return array_reduce($this->products, fn($a, $p) => $a + ($p['price'] * $p['quantity']), 0);
    }

    public function getQuantityProperty() {
        return array_reduce($this->products, fn($a, $p) => $a + $p['quantity'], 0);
    }

    public function selectProduct($id) {
        $this->selected = $id;
    }

    public function addProduct($product) {
        $quantity = $this->products[$product['code']]['quantity'] ?? 0;
        $this->products[$product['code']] = [
            'id' => $product['code'],
            'name' => $product['name'],
            'code' => $product['code'],
            'quantity' => ++$quantity,
            'price' => $product['price']
        ];
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
        $this->reset('selected');
    }

    public function sale() {
        if ( count($this->products) === 0 ) return;
        $this->isRefund = false;
        $this->screen = 'type';
    }

    public function auth($type) {
        if ($type === 'refund') {
            if ( count($this->products) === 0 ) return;
        }
        $this->authRedirect = $type;
        $this->screen = 'auth';
    }

    public function proceed() {
        if ( $this->password !== $this->adminPassword ) {
            $this->isPasswordError = true;
            return;
        }

        if ($this->authRedirect === 'refund') {
            $this->refund();
        }

        $this->reset('password', 'authRedirect', 'isPasswordError');
    }

    public function saveEdit() {
        $this->products[$this->selected]['quantity'] = $this->updatedQuantity;
        $this->reset('updatedQuantity', 'selected');
        $this->screen = 'main';
    }

    public function discard() {
        if ($this->isRefund) $this->inversePriceAndQuantity();
        $this->reset('updatedQuantity', 'selected', 'cash', 'paymentType', 'card', 'password', 'authRedirect', 'isPasswordError', 'isRefund');
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

    private function refund() {
        $this->isRefund = true;
        $this->inversePriceAndQuantity();
        $this->screen = 'type';
    }

    private function inversePriceAndQuantity() {
        $this->products = array_map(function($p) {
            $p['price'] *= -1;
            return $p;
        }, $this->products);
        $this->quantity *= -1;
    }

    public function render()
    {
        return view('livewire.pos.show');
    }
}
