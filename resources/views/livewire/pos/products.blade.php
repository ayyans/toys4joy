@push('otherstyle')
<style>
    .pos-product-outer {
        overflow-y: scroll;
        overflow-x: hidden;
    }
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
    .h-500 {
        height: 500px;
    }
</style>
@endpush
<div class="pos-product-outer row row-cols-2 align-items-stretch h-500">
    @foreach ($products as $product)
    <div class="pos-product-container p-1" wire:key="{{ $product->id }}">
        <div class="pos-product col px-2 py-4 rounded-lg" wire:click="$emit('addProduct', {{ $product->id }})">
            <h5 class="d-flex align-items-center text-center text-dark fw-bolder w-100 h-60">{{ $product->title, 4 }}</h5>
        </div>
    </div>
    @endforeach
</div>
