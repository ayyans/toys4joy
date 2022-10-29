@push('otherstyle')
<style>
    .pos-product-container {
        cursor: pointer;
    }
    .pos-product {
        background-color: var(--golden-primary);
    }
    .pos-product:hover {
        background-color: var(--golden-secondary);
    }
    /* Utility classes */
    .h-60 {
        height: 60px;
    }
</style>
@endpush
<div class="row row-cols-2 align-items-stretch h-500">
    @foreach ($this->products as $product)
    <div class="pos-product-container p-1" wire:key="{{ $product->id }}">
        <div class="pos-product col px-2 py-4 rounded-lg" wire:click="$emit('addProduct', {{ $product }})">
            <h5 class="d-flex align-items-center justify-content-center text-center text-dark fw-bolder w-100 h-60">{{ $product->name }}</h5>
        </div>
    </div>
    @endforeach
</div>
