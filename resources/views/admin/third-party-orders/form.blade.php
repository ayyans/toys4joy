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
        <input type="text" class="form-control" name="sku" value="{{ old('sku', $thirdPartyOrder->sku ?? null) }}" required />
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