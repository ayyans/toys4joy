<div class="row form-group">
    <div class="col-lg-3">
        <label>Channel</label>
    </div>
    <div class="col-lg-9">
        @php
            $selected = $thirdPartyOrder->channel ?? null;
            $channels = ['talabat', 'snoonu', 'rafeeq', 'social media'];
        @endphp
        <select class="form-control" name="channel" required>
            @foreach ($channels as $channel)
                <option value="{{ $channel }}" {{ $selected == $channel ? 'selected' : '' }}>{{ Str::headline($channel) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row form-group">
    <div class="col-lg-3">
        <label>Order Number</label>
    </div>
    <div class="col-lg-9">
        <input type="text" class="form-control" name="order_number" value="{{ $thirdPartyOrder->order_number ?? null }}" required />
    </div>
</div>
<div class="row form-group">
    <div class="col-lg-3">
        <label>SKU</label>
    </div>
    <div class="col-lg-9">
        <input type="text" class="form-control" name="sku" value="{{ $thirdPartyOrder->sku ?? null }}" required />
    </div>
</div>
<div class="row form-group">
    <div class="col-lg-3">
        <label>Quantity</label>
    </div>
    <div class="col-lg-9">
        <input type="number" min="1" class="form-control" name="quantity" value="{{ $thirdPartyOrder->quantity ?? 0 }}" required />
    </div>
</div>