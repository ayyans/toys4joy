@push('otherstyle')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<div class="row form-group">
    <div class="col-lg-3">
        <label>Channel</label>
    </div>
    <div class="col-lg-9">
        @php
            $selected = old('channel', $thirdPartyOrder->channel ?? null);
            $channels = ['talabat', 'snoonu', 'rafeeq', 'social media'];
        @endphp
        <select class="form-control" name="channel" required>
            @foreach ($channels as $channel)
                <option value="{{ $channel }}" {{ $selected == $channel ? 'selected' : '' }}>{{ Str::headline($channel) }}</option>
            @endforeach
        </select>
        @error('channel')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="row form-group">
    <div class="col-lg-3">
        <label>Order Number</label>
    </div>
    <div class="col-lg-9">
        <input type="text" class="form-control" name="order_number" value="{{ old('order_number', $thirdPartyOrder->order_number ?? null) }}" required />
        @error('order_number')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="row form-group">
    <div class="col-lg-3">
        <label>SKU</label>
    </div>
    <div class="col-lg-9">
        @php $selectedSKU = old('sku', $thirdPartyOrder->sku ?? null) @endphp

        <select class="select2 form-control w-100" name="sku">
            @if ( $selectedSKU )
            @php $product = \App\Models\Product::where('sku', $selectedSKU)->first() @endphp
            <option value="{{ $selectedSKU }}" selected>{{ $product?->title ?? $selectedSKU }}</option>
            @endif
        </select>
        @error('sku')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="row form-group">
    <div class="col-lg-3">
        <label>Quantity</label>
    </div>
    <div class="col-lg-9">
        <input type="number" min="1" class="form-control" name="quantity" value="{{ old('quantity', $thirdPartyOrder->quantity ?? 0) }}" required />
        @error('quantity')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

@push('otherscript')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(".select2").select2({
  ajax: {
    url: "{{ route('admin.select2.product.search') }}",
    dataType: 'json',
    delay: 500,
    method: 'POST',
    cache: true,
    data: function (params) {
      return {
        search: params.term, // search term
        page: params.page || 1
      };
    }
  },
  placeholder: 'Search Product SKU',
  minimumInputLength: 1,
  templateResult: formatResult,
  templateSelection: formatResult
});

function formatResult (product) {
  if (product.loading) {
    return product.text;
  }
  return `${product.id} (${product.text})`;
}
</script>
@endpush