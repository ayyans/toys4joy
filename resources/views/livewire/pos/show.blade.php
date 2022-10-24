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
</style>
@endpush
<div class="pos-view-container p-5">
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
    <hr class="bg-white h-2 opacity-50">
    <div class="d-flex justify-content-between">
        <h5 class="text-dark px-2 fw-bolder">TOTAL</h5>
        <h5 class="text-dark px-2 fw-bolder">{{ number_format($this->total, 2) }}</h5>
    </div>
    <div class="action-buttons d-flex justify-content-between mt-3">
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm" wire:click="editProduct">EDIT</button>
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm mx-2" wire:click="deleteProduct">VOID</button>
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm" wire:click="sale">SALE</button>
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
        <input type="number" class="border-0 py-3 text-center fw-bolder rounded-lg shadow-sm" wire:model.lazy="updatedQuantity">
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
    @elseif ($screen === 'cash')
    <div class="checkout-container p-4 shadow-sm text-dark">
        <table>
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Cash:</h2>
                </td>
                <td>
                    <input type="number" class="border-0 fs-15 text-center fw-bolder rounded-lg shadow-sm btn-gold mb-3 w-70" wire:model="cash">
                </td>
            </tr>
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Total:</h2>
                </td>
                <td>
                    <h2 class="fw-bolder">{{ $total }}</h2>
                </td>
            </tr>
            <tr>
                <td>
                    <h2 class="fw-bolder w-250">Change:</h2>
                </td>
                <td>
                    <h2 class="fw-bolder">{{ $cash > 0 ? $this->change : 0 }}</h2>
                </td>
            </tr>
        </table>
    </div>
    <div class="action-buttons d-flex justify-content-between mt-4">
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm" wire:click="printReceipt('cash')">Print</button>
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
                    <h2 class="fw-bolder">{{ $total }}</h2>
                </td>
            </tr>
        </table>
    </div>
    <div class="action-buttons d-flex justify-content-between mt-4">
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm" wire:click="printReceipt('card')">Print</button>
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm ml-2" wire:click="discard">Cancel</button>
    </div>
    @endif
</div>
@push('otherscript')
<script>
    $(document).on('click', '.pos-view-table tbody .tr-view', function() {
        const id = $(this).data('id');
        Livewire.emit('selectProduct', id);
        $('.pos-view-table tbody .tr-view').removeClass('bg-row-hover');
        $(this).addClass('bg-row-hover');
    });
</script>
@endpush