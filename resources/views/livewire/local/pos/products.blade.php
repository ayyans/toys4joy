@push('otherstyle')
<style>
    .pos-product-container {
        cursor: pointer;
    }
    .pos-product {
        background-color: var(--primary-background);
    }
    .pos-product:hover {
        background-color: var(--secondary-background);
    }
    /* Utility classes */
    .h-60 {
        height: 60px;
    }

    .h-500 {
        max-height: 500px;
    }

    .overflow-y-scroll {
        overflow-y: scroll;
    }
</style>
@endpush
<div>
    <div class="row row-cols-1 align-items-stretch">
        <div class="pos-product-container p-1" wire:key="local.pos.product.search">
            <div class="form-group">
                <label for="search">Search</label>
                <input type="text" class="form-control" id="search" wire:model.debounce.500="search">
            </div>
        </div>
    </div>
    <div class="row row-cols-2 align-items-stretch h-500 overflow-y-scroll">
        @foreach ($this->products as $product)
        <div class="pos-product-container p-1" wire:key="{{ $product->id }}">
            <div class="pos-product px-2 py-4 rounded-lg" wire:click="$emit('addProduct', {{ $product }})">
                <h5 class="d-flex align-items-center justify-content-center text-center text-light fw-bolder w-100 h-60">{{ Str::words($product->name, 5) }}</h5>
            </div>
        </div>
        @endforeach
    </div>
</div>
