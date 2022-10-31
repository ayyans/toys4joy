<?php

namespace App\Http\Livewire\Pos;

use App\Models\POSInvoice;
use Livewire\Component;

class Show extends Component
{
    public $products = [];
    public $adminPassword = '12345678';
    public $selected = null;
    public $screen = 'main';
    public $updatedQuantity = null;
    public $paymentType = null;
    public $cash = 0;
    public $card = ['name' => '', 'type' => '', 'number' => ''];
    public $isRefund = false;
    public $password = null;
    public $authRedirect = null;
    public $isPasswordError = false;
    public $invoiceNumber = null;

    protected $listeners = ['addProduct', 'selectProduct'];

    public function getChangeProperty() {
        return ($this->cash ?: 0) - $this->total;
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

    public function mount() {
        $this->invoiceNumber = $this->generateInvoiceNumber();
    }

    public function addProduct($product) {
        $quantity = $this->products[$product['id']]['quantity'] ?? 0;
        $this->products[$product['id']] = $product;
        $this->products[$product['id']]['quantity'] = ++$quantity;
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
    }

    public function saveEdit() {
        $updatedQuantity = $this->updatedQuantity > 0 ? $this->updatedQuantity : 1;
        $this->products[$this->selected]['quantity'] = $updatedQuantity;
        $this->reset('updatedQuantity', 'selected');
        $this->screen = 'main';
    }

    public function discard() {
        if ($this->isRefund) $this->inversePriceAndQuantity();
        $this->resetExcept('products', 'adminPassword');
    }

    public function paymentType($type) {
        $this->paymentType = $type;
        $this->screen = $type;
    }

    public function saveInvoice() {
        // creating invoice
        $invoice = POSInvoice::create([
            'invoice_number' => $this->invoiceNumber,
            'type' => $this->isRefund ? 'refund' : 'sale',
            'method' => $this->paymentType === 'cash' ? 'cash' : strtolower($this->card['type']),
            'quantity' => $this->quantity,
            'total' => $this->total,
            'cash' => $this->cash,
            'change' => $this->change
        ]);
        // creating invoice products
        foreach($this->products as $product) {
            $invoice->products()->create([
                'product_id' => $product['id'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'total' => $product['price'] * $product['quantity']
            ]);
        }
        // reseting everything
        $this->reset('products');
        $this->discard();
        $this->mount();
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

    private function generateInvoiceNumber(){
        $invoiceNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $exists = POSInvoice::where('invoice_number', $invoiceNumber)->exists();
        return $exists ? $this->generateInvoiceNumber() : $invoiceNumber;
    }

    public function render()
    {
        return view('livewire.pos.show');
    }
}
