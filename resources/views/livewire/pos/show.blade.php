@push('otherstyle')
<style>
    :root {
        --golden-primary: #f5c556;
        --golden-secondary: #fed966;
    }
    .pos-view-container {
        background-color: var(--golden-primary);
        border-radius: 60px;
    }
    .pos-view-container .action-buttons .btn {
        font-size: 1.2em;
    }
    .pos-view-table {
        border-collapse: separate;
        border-spacing: 0 5px;
    }
    .pos-view-table thead tr {
        background-color: var(--golden-secondary);
    }
    .pos-view-table tbody tr {
        background-color: #fff4bc;
    }

    .pos-view-table tbody tr:hover {
        background-color: #ffdabc;
        cursor: pointer;
    }

    #quantity-edit {
        background-color: var(--golden-secondary);
        font-size: 2em;
    }

    [type=number]:focus-visible {
        outline: none;
    }

    [type=number]::-webkit-inner-spin-button,
    [type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .checkout-container {
        background-color: var(--golden-secondary);
        
        border-radius: 30px;
    }
    /* utility classes */
    .h-2 {
        height: 2px;
    }
    .opacity-50 {
        opacity: 0.5;
    }
    .fw-bolder {
        font-weight: bolder;
    }
    .btn-gold {
        background-color: var(--golden-secondary);
        border: 3px solid transparent;
    }
    .btn-gold:hover {
        border-color: var(--golden-primary);
    }
    .bg-row-hover {
        background-color: #ffdabc !important;
    }
    .fs-15 {
        font-size: 1.5em;
    }
    .w-70 {
        width: 70px;
    }
    .w-250 {
        width: 250px;
    }
    .h-600 {
        height: 600px;
    }
</style>
@endpush
<div class="pos-view-container p-5 h-600 d-flex flex-column justify-content-between">
    @if ($screen === 'main')
    <table class="pos-view-table w-100">
        <thead>
            <tr class="shadow-sm">
                <th class="p-2 text-dark rounded-left">Product</th>
                <th class="p-2 text-dark">Code</th>
                <th class="p-2 text-dark">Quantity</th>
                <th class="p-2 text-dark rounded-right">Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="tr-view shadow-sm {{ $product['code'] == $selected ? 'bg-row-hover' : '' }}" data-id="{{ $product['code'] }}" wire:key="{{ $product['code'] }}">
                    <td class="px-2 py-1 text-dark rounded-left">{{ $product['name'] }}</td>
                    <td class="px-2 py-1 text-dark">{{ $product['code'] }}</td>
                    <td class="px-2 py-1 text-dark">{{ $product['quantity'] }}</td>
                    <td class="px-2 py-1 text-dark rounded-right">{{ number_format($product['price'], 2) }}</td>
                </tr>
            @empty
                <tr class="shadow-sm">
                    <td class="px-2 py-1 text-dark rounded text-center opacity-50" colspan="4">No Products</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div>
        <hr class="bg-white h-2 opacity-50">
        <div class="d-flex justify-content-between">
            <h5 class="text-dark px-2 fw-bolder">TOTAL</h5>
            <h5 class="text-dark px-2 fw-bolder">{{ number_format($this->total, 2) }}</h5>
        </div>
        <div class="action-buttons d-flex justify-content-between mt-3">
            <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm w-100" wire:click="editProduct">EDIT</button>
            <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm w-100 ml-2" wire:click="deleteProduct">VOID</button>
        </div>
        <div class="action-buttons d-flex justify-content-between mt-3">
            <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm w-100" wire:click="sale">SALE</button>
            <button class="btn btn-danger flex-grow-1 text-white fw-bolder shadow-sm w-100 ml-2" wire:click="auth('refund')">REFUND</button>
        </div>
    </div>
    @elseif ($screen === 'edit')
    <table class="pos-view-table w-100">
        <thead>
            <tr class="shadow-sm">
                <th class="p-2 text-dark rounded-left">Product</th>
                <th class="p-2 text-dark">Code</th>
                <th class="p-2 text-dark">Quantity</th>
                <th class="p-2 text-dark rounded-right">Price</th>
            </tr>
        </thead>
        <tbody>
            <tr class="shadow-sm">
                <td class="px-2 py-1 text-dark rounded-left">{{ $products[$selected]['name'] }}</td>
                <td class="px-2 py-1 text-dark">{{ $products[$selected]['code'] }}</td>
                <td class="px-2 py-1 text-dark">{{ $products[$selected]['quantity'] }}</td>
                <td class="px-2 py-1 text-dark rounded-right">{{ number_format($products[$selected]['price'], 2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="text-center mt-4">
        <input type="number" class="border-0 py-3 text-center fw-bolder rounded-lg shadow-sm btn-gold" wire:model.lazy="updatedQuantity">
    </div>
    <div class="action-buttons d-flex justify-content-between mt-4">
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm" wire:click="saveEdit">OK</button>
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm ml-2" wire:click="discard">Cancel</button>
    </div>
    @elseif ($screen === 'type')
    <div class="action-buttons fs-15 d-flex justify-content-between mt-4">
        <button class="btn btn-gold py-3 flex-grow-1 text-dark fw-bolder shadow-sm" wire:click="paymentType('cash')">Cash</button>
        <button class="btn btn-gold py-3 flex-grow-1 text-dark fw-bolder shadow-sm ml-2" wire:click="paymentType('card')">Card</button>
    </div>
    <div class="action-buttons text-center mt-5">
        <button class="btn btn-gold text-dark fw-bolder shadow-sm w-50" wire:click="discard">Cancel</button>
    </div>
    @elseif ($screen === 'auth')
    <div class="action-buttons fs-15 d-flex flex-column align-items-center mt-4">
        <input type="text" class="border-0 fs-15 text-center fw-bolder rounded-lg shadow-sm btn-gold mb-3" placeholder="PASSWORD" wire:model.lazy="password">
        @if ($isPasswordError)
        <p class="text-danger">You have entered a wrong password</p>
        @endif
    </div>
    <div class="action-buttons d-flex justify-content-between mt-4">
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm" wire:click="proceed">Proceed</button>
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm ml-2" wire:click="discard">Cancel</button>
    </div>
    @elseif ($screen === 'cash')
    <div class="checkout-container p-4 shadow-sm text-dark">
        <table>
            @if ($isRefund === false)
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Cash:</h2>
                </td>
                <td>
                    <input type="number" class="border-0 fs-15 text-center fw-bolder rounded-lg shadow-sm btn-gold mb-3 w-70" wire:model="cash">
                </td>
            </tr>
            @endif
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Total:</h2>
                </td>
                <td>
                    <h2 class="fw-bolder">{{ $this->total }}</h2>
                </td>
            </tr>
            @if ($isRefund === false)
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Change:</h2>
                </td>
                <td>
                    <h2 class="fw-bolder">{{ $cash > 0 ? $this->change : 0 }}</h2>
                </td>
            </tr>
            @endif
        </table>
    </div>
    <div class="action-buttons d-flex justify-content-between mt-4">
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm print">Print</button>
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm ml-2" wire:click="discard">Cancel</button>
    </div>
    @elseif ($screen === 'card')
    <div class="checkout-container p-4 shadow-sm text-dark">
        <table>
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Name:</h2>
                </td>
                <td>
                    <input type="text" class="border-0 fs-15 text-center fw-bolder rounded-lg shadow-sm btn-gold mb-3" wire:model="card.name">
                </td>
            </tr>
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Card Type:</h2>
                </td>
                <td>
                    <input type="text" class="border-0 fs-15 text-center fw-bolder rounded-lg shadow-sm btn-gold mb-3" wire:model="card.type">
                </td>
            </tr>
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Card No:</h2>
                </td>
                <td>
                    <input type="text" class="border-0 fs-15 text-center fw-bolder rounded-lg shadow-sm btn-gold mb-3" wire:model="card.number">
                </td>
            </tr>
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Total:</h2>
                </td>
                <td>
                    <h2 class="fw-bolder">{{ $this->total }}</h2>
                </td>
            </tr>
        </table>
    </div>
    <div class="action-buttons d-flex justify-content-between mt-4">
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm print">Print</button>
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm ml-2" wire:click="discard">Cancel</button>
    </div>
    @endif
    {{-- =================================== --}}
    {{-- ============= RECEIPT ============= --}}
    {{-- =================================== --}}
<div id="divToPrint" class="d-none-">
    <style>
        #invoice-POS {
            /* box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); */
            padding: 2mm;
            /* margin: 0 auto; */
            /* width: 80mm; */
            background: #FFF;
            color: #000;
            font-family: Arial, Helvetica, sans-serif;
        }
        #invoice-POS ::selection {
            background: #f31544;
            color: #FFF;
        }
        #invoice-POS ::moz-selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS h1 {
            font-size: 1.7em;
        }

        #invoice-POS h2 {
            font-size: 1.1em;
            font-weight: bold;
        }

        #invoice-POS h3 {
            font-size: 1.4em;
            font-weight: 300;
            line-height: 2em;
        }

        #invoice-POS p {
            font-size: .9em;
            line-height: 1.2em;
        }

        #invoice-POS #bot {
            min-height: 50px;
        }

        #invoice-POS .title {
            float: right;
        }

        #invoice-POS .title p {
            text-align: right;
        }

        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }

        #invoice-POS .tabletitle {
            font-size: .7em;
        }

        #invoice-POS .service {
            border-top: 1px solid #EEE;
        }

        #invoice-POS .item {
            width: 24mm;
        }

        #invoice-POS .headtext {
            font-size: 1em;
        }

        #invoice-POS .midtext {
            font-size: .8em;
        }

        #invoice-POS .itemtext {
            font-size: .7em;
        }

        #invoice-POS .fw-bold {
            font-weight: bold;
        }

        #invoice-POS .mb-0 {
            margin-bottom: none;
        }

        #invoice-POS .mb-1 {
            margin-bottom: 5px;
        }

        #invoice-POS .my-0 {
            margin-top: none;
            margin-bottom: none;
        }

        #invoice-POS .py-1 {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        #invoice-POS .mt-2 {
            margin-top: 10px;
        }

        #invoice-POS .text-center {
            text-align: center
        }
    </style>
    <div id="invoice-POS">
        <center id="top">
            <p class="headtext fw-bold mb-1">Toys4Joy</p>
            <p class="itemtext mb-1">Building 25, Zone 39, Street 343<br>
            4th Floor, Office No. 31, P.O BOX 13920<br>
            Phone No: +974 6000 5970</p>
        </center>
        <!--End InvoiceTop-->
        <div id="mid">
            <table>
                <tr>
                    <td>
                        <p class="itemtext mb-1">Date</p>
                    </td>
                    <td class="title">
                        <p class="itemtext mb-1">{{ now()->format('d/m/y') }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="itemtext mb-1">Time</p>
                    </td>
                    <td class="title">
                        <p class="itemtext mb-1">{{ now()->format('H:i') }}</p>
                    </td>
                </tr>
            </table>
            <div class="text-center">
                <p class="fw-bold midtext mb-1">{{ $this->isRefund ? 'REFUND' : '' }} INVOICE</p>
            </div>
        </div>
        <!--End Invoice Mid-->

        <div id="bot">

            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="Code">
                            <h2>Code</h2>
                        </td>
                        <td class="item">
                            <h2>Name</h2>
                        </td>
                        <td class="Qty text-center">
                            <h2>Qty</h2>
                        </td>
                        <td class="Price text-center">
                            <h2>Price</h2>
                        </td>
                        <td class="Total text-center">
                            <h2>Total</h2>
                        </td>
                    </tr>

                    @foreach ($products as $product)
                    <tr class="service">
                        <td class="tableitem">
                            <p class="itemtext mb-0 py-1">{{ $product['code'] }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext mb-0 py-1">{{ $product['name'] }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext mb-0 py-1 text-center">{{ $product['quantity'] }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext mb-0 py-1 text-center">{{ $product['price'] }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext mb-0 py-1 text-center">{{ $product['price'] * $product['quantity'] }}</p>
                        </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                    </tr>

                    <tr class="tabletitle">
                        <td class="Rate">
                            <h2>Total Quantity</h2>
                        </td>
                        <td class="payment">
                            <h2>{{ $this->quantity }}</h2>
                        </td>
                    </tr>

                    <tr class="tabletitle">
                        <td class="Rate">
                            <h2>Total</h2>
                        </td>
                        <td class="payment">
                            <h2>{{ $this->total }}</h2>
                        </td>
                    </tr>
                </table>

                <hr class="my-1">
                <div class="text-center">
                    <p class="fw-bold midtext mb-0">PAYMENT</p>
                </div>
                <hr class="my-1">

                @if ($paymentType === 'cash')
                <table>
                    <tr class="midtext">
                        <td>
                            <h2 class="my-0">Cash</h2>
                        </td>
                        @if ($isRefund === false)
                        <td>
                            <h2 class="my-0">{{ $cash }}</h2>
                        </td>
                        @endif
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                    </tr>
                    <tr class="midtext">
                        <td>
                            <h2 class="my-0">Total</h2>
                        </td>
                        <td>
                            <h2 class="my-0">{{ $this->total }}</h2>
                        </td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                    </tr>
                    <tr class="midtext">
                        <td>
                            <h2 class="my-0">Change</h2>
                        </td>
                        @if ($isRefund === false)
                        <td>
                            <h2 class="my-0">{{ $this->change }}</h2>
                        </td>
                        @endif
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                    </tr>
                </table>
                @elseif ($paymentType === 'card')
                <table>
                    <tr class="midtext">
                        <td>
                            <h2 class="my-0">Name</h2>
                        </td>
                        <td>
                            <h2 class="my-0">{{ $card['name'] }}</h2>
                        </td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                    </tr>
                    <tr class="midtext">
                        <td>
                            <h2 class="my-0">Card Type</h2>
                        </td>
                        <td>
                            <h2 class="my-0">{{ strtoupper($card['type']) }}</h2>
                        </td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                    </tr>
                    <tr class="midtext">
                        <td>
                            <h2 class="my-0">Card No</h2>
                        </td>
                        <td>
                            <h2 class="my-0">{{ $card['number'] }}</h2>
                        </td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                        <td>ㅤ</td>
                    </tr>
                </table>
                @endif

                <hr class="my-1">
            </div>
            <!--End Table-->

            <center class="mt-2">
                <p class="itemtext mb-1 fw-bold">All products purchased from Toys 4 Joy can be returned or exchanged within 7 days from the date of the purchase along with the original receipt</p>
            </center>

        </div>
        <!--End InvoiceBot-->
    </div>
<!--End Invoice-->
</div>
{{-- =================================== --}}
{{-- ============= RECEIPT ============= --}}
{{-- =================================== --}}
</div>
@push('otherscript')
<script>
    $(document).on('click', '.pos-view-table tbody .tr-view', function() {
        const id = $(this).data('id');
        Livewire.emit('selectProduct', id);
        $('.pos-view-table tbody .tr-view').removeClass('bg-row-hover');
        $(this).addClass('bg-row-hover');
    });
    // print cash
    $(document).on('click', '.print', function() {
        var divToPrint = document.getElementById('divToPrint');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
        newWin.document.close();
        setTimeout(function() {
            newWin.close();
        }, 1000);
    });
</script>
@endpush