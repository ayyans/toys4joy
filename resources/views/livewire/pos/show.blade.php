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
</style>
@endpush
<div class="pos-view-container p-5">
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
                <tr class="shadow-sm {{ $product['id'] == $selected ? 'bg-row-hover' : '' }}" data-id="{{ $product['id'] }}" wire:key="{{ $product['id'] }}">
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
        <button class="btn btn-gold flex-grow-1 text-dark fw-bolder shadow-sm">SALE</button>
    </div>
</div>
@push('otherscript')
<script>
    $(document).on('click', '.pos-view-table tbody tr', function() {
        const id = $(this).data('id');
        Livewire.emit('selectProduct', id);
        $('.pos-view-table tbody tr').removeClass('bg-row-hover');
        $(this).addClass('bg-row-hover');
    });
</script>
@endpush