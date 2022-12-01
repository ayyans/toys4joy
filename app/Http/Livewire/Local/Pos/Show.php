<?php

namespace App\Http\Livewire\Local\Pos;

use App\Models\POSInvoice;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public $products = [];
    public $adminPassword = '12345678';
    public $selected = null;
    public $screen = 'main';
    public $updatedQuantity = null;
    public $updatedPrice = null;
    public $paymentType = null;
    public $cash = 0;
    public $discount = 0;
    public $name = null;
    public $phone = null;
    public $card = ['type' => '', 'number' => ''];
    public $isRefund = false;
    public $password = null;
    public $authRedirect = null;
    public $isPasswordError = false;
    public $invoiceNumber = null;
    public $isReport = false;
    public $saleStats = [];
    public $salesCash = 0;
    public $salesCard = 0;
    public $salesTotal = 0;
    public $refundStats = [];
    public $refundCash = 0;
    public $refundCard = 0;
    public $refundTotal = 0;
    public $isReprint = false;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'addProduct',
        'selectProduct'
    ];

    public function getChangeProperty() {
        return ($this->cash ?: 0) - $this->final;
    }

    public function getTotalProperty() {
        return array_reduce($this->products, fn($a, $p) => $a + ($p['price'] * $p['quantity']), 0);
    }

    public function getTotalDiscountProperty() {
        return $this->getTotalProperty() * (($this->discount ?: 0) / 100);
    }

    public function getQuantityProperty() {
        return array_reduce($this->products, fn($a, $p) => $a + $p['quantity'], 0) *
            ($this->isRefund ? -1 : 1);
    }

    public function getFinalProperty() {
        return $this->getTotalProperty() - $this->getTotalDiscountProperty();
    }

    public function selectProduct($id) {
        $this->selected = $id;
    }

    public function mount() {
        $this->invoiceNumber = $this->generateInvoiceNumber();
    }

    public function addProduct($product) {
        if ( isset( $product['quantity'] ) ) {
            $quantity = --$product['quantity'];
        } else {
            $quantity = $this->products[$product['id']]['quantity'] ?? 0;
        }
        $this->products[$product['id']] = $product;
        $this->products[$product['id']]['quantity'] = ++$quantity;
    }

    public function editProduct() {
        if (! $this->selected) return;
        $this->updatedQuantity = $this->products[$this->selected]['quantity'];
        $this->updatedPrice = $this->products[$this->selected]['price'];
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
        } else if ($this->authRedirect === 'z-report') {
            $this->zReport();
        }
    }

    public function saveEdit() {
        $updatedQuantity = $this->updatedQuantity > 0 ? $this->updatedQuantity : 1;
        $updatedPrice = $this->updatedPrice >= 0 ? $this->updatedPrice : 0;
        $this->products[$this->selected]['quantity'] = $updatedQuantity;
        $this->products[$this->selected]['price'] = $updatedPrice;
        $this->reset('updatedQuantity', 'updatedPrice', 'selected');
        $this->screen = 'main';
    }

    public function discard() {
        if ($this->isRefund) $this->inversePriceAndQuantity();
        if ($this->isReprint) {
            $this->reset('products', 'invoiceNumber');
            $this->mount();
        }
        $this->resetExcept('products', 'adminPassword', 'invoiceNumber');
    }

    public function paymentType($type) {
        $this->paymentType = $type;
        $this->screen = $type;
        $this->invoiceNumber = $this->invoiceNumber ?? $this->generateInvoiceNumber();
    }

    public function saveInvoice() {
        if (! $this->isReprint) {
            // // creating invoice
            // $invoice = POSInvoice::create([
            //     'invoice_number' => $this->invoiceNumber,
            //     'type' => $this->isRefund ? 'refund' : 'sale',
            //     'method' => $this->paymentType === 'cash' ? 'cash' : strtolower($this->card['type']),
            //     'quantity' => $this->quantity ?: array_reduce($this->products, fn($a, $p) => $a + $p['quantity'], 0) * ($this->isRefund ? -1 : 1),
            //     'total' => $this->total,
            //     'discount' => $this->discount,
            //     'final' => $this->final,
            //     'cash' => $this->cash,
            //     'change' => $this->change,
            //     'name' => $this->name,
            //     'phone' => $this->phone,
            //     'card' => $this->paymentType === 'card' ? strtolower($this->card['number']) : null,
            // ]);
            // // creating invoice products
            // foreach($this->products as $product) {
            //     $invoice->products()->create([
            //         'product_id' => $product['id'],
            //         'price' => $product['price'],
            //         'quantity' => $product['quantity'],
            //         'total' => $product['price'] * $product['quantity']
            //     ]);
            // }
        }
        // reseting everything
        // $this->reset('products');
        // $this->discard();
        // $this->mount();
        return redirect()->route('admin.local.pos.point-of-sale')->with('refresh', true);
    }

    public function xReport() {
        $this->isReport = true;
        $this->screen = 'x-report';
        $this->generateSaleStats();
        $this->generateRefundStats();
    }

    public function zReport() {
        $this->isReport = true;
        $this->screen = 'z-report';
        $this->generateSaleStats();
        $this->generateRefundStats();
    }

    private function generateSaleStats() {
        $this->saleStats = POSInvoice::sale()->today()
            ->select(DB::raw('method, sum(final) as total'))
            ->groupBy('method')
            ->get();
        $this->salesCash = $this->saleStats->where('method', 'cash')->sum('total');
        $this->salesCard = $this->saleStats->where('method', '!=', 'cash')->sum('total');
        $this->salesTotal = $this->saleStats->sum('total');
    }

    private function generateRefundStats() {
        $this->refundStats = POSInvoice::refund()->today()
            ->select(DB::raw('method, sum(abs(final)) as total'))
            ->groupBy('method')
            ->get();
        $this->refundCash = $this->refundStats->where('method', 'cash')->sum('total');
        $this->refundCard = $this->refundStats->where('method', '!=', 'cash')->sum('total');
        $this->refundTotal = $this->refundStats->sum('total');
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
    }

    private function generateInvoiceNumber(){
        $invoiceNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $exists = POSInvoice::where('invoice_number', $invoiceNumber)->exists();
        return $exists ? $this->generateInvoiceNumber() : $invoiceNumber;
    }

    public function rePrint() {
        $this->reset('products');
        $this->invoiceNumber = null;
        $this->screen = 'reprint';
    }

    public function getInvoiceData() {
        $invoice = POSInvoice::with('products.product')->firstWhere('invoice_number', $this->invoiceNumber);
        if (! $invoice) return;
        $this->quantity = abs($invoice->quantity);
        $invoice->products->each(function($invoiceProduct) {
            $this->addProduct($invoiceProduct->product->toArray() + ['quantity' => $invoiceProduct->quantity]);
        });
        $this->discount = $invoice->discount;
        $this->isRefund = $invoice->type === 'refund';
        if ($this->isRefund) $this->inversePriceAndQuantity();
        $this->paymentType = $invoice->method === 'cash' ? 'cash' : 'card';
        $this->cash = $invoice->cash;
        $this->name = $invoice->name;
        $this->phone = $invoice->phone;
        $this->card = [
            'type' => $invoice->method,
            'number' => $invoice->card
        ];
        $this->isReprint = true;
        $this->screen = $this->paymentType;
    }

    public function render()
    {
        return view('livewire.local.pos.show');
    }
}
