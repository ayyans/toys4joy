@extends('website.layouts.master')
@section('content')
<main id="pay-as-member" class="pay-as-member-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 member-col left">
                @foreach($items as $item)
                <div class="d-flex cart-products">
                    <div class="cart-image">
                        <img src="{{ asset('products/'.$item->associatedModel['featured_img']) }}" />
                    </div>
                    <div class="product-detail">
                        <h2 class="title">{{$item->name}}</h2>
                        <h4 class="price">QAR {{$item->price}}</h4>
                        <div class="qty">Quantity : {{$item->quantity}}</div>
                        <div class="d-flex rmv-or-edit">
                            <div class="remove icon">
                                <a href="javascript:void(0)" onclick="removecart( {{ $item->id }}, true )">
                                    <img src="{{asset('website/img/delete.png')}}" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-6 member-col right text-center">
                @php $coupon = cart()->getConditionsByType('coupon')->first() @endphp
                <div style="margin-top: 0px;" class="discount-block">
                    <div class="mb-3">
                        <label>{{__('trans.Discount Code')}}</label>
                        @if ($coupon && $coupon->getName() == 'Discount Coupon')
                        <input style="background-color: #ddd" readonly
                            value="Congratulations! You have redeemed {{ substr($coupon->getValue(), 1) }} discount coupon"
                            type="text">
                        <a href="{{ route('website.removeDiscountCoupon', ['id' => $coupon->getAttributes()['id'], 'name' => $coupon->getName()]) }}"
                            class="btn btn-primary discountBtn">{{__('trans.Remove')}}</a>
                        @else
                        <input type="text" id="discount_coupon" @if ($coupon) disabled @endif>
                        <button class="btn btn-primary discountBtn" @if ($coupon) disabled @endif>{{__('trans.Enter')}}</button>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>{{__('trans.Gift-Card Code')}}</label>
                        <input type="text" id="giftcard_coupon">
                        <button class="btn btn-primary giftBtn">{{__('trans.Enter')}}</button>
                    </div>
                    @php $giftCards = cart()->getConditionsByType('giftcard') @endphp
                    @foreach ($giftCards as $giftCard)
                    <div class="alert alert-success d-flex justify-content-between px-2 py-1 text-start" role="alert">
                        <span>You have redeemed {{ abs($giftCard->getValue()) }} QAR</span>
                        <a href="{{ route('website.removegiftcard', ['id' => $giftCard->getAttributes()['id'], 'name' => $giftCard->getName()]) }}"
                            class="alert-link">{{__('trans.Remove')}}</a>
                    </div>
                    @endforeach
                    {{-- @endif --}}
                </div>

                <div class="code-block">
                    <div class="mb-3">
                        <label>{{__('trans.Corporate Code')}}</label>
                        @if ($coupon && $coupon->getName() == 'Corporate Coupon')
                        <input style="background-color: #ddd" readonly
                            value="Congratulations! You have redeemed {{ substr($coupon->getValue(), 1) }} corporate coupon"
                            type="text">
                        <a href="{{ route('website.removeCorporateCoupon', ['id' => $coupon->getAttributes()['id'], 'name' => $coupon->getName()]) }}"
                            class="btn btn-primary corporateBtn">{{__('trans.Remove')}}</a>
                        @else
                        <input type="text" id="corporate_code" @if ($coupon) disabled @endif>
                        <button class="btn btn-primary corporateBtn" @if ($coupon) disabled @endif>{{__('trans.Enter')}}</button>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>{{__('trans.Verify the OTP Code')}}</label>
                        <input type="text" id="verifyotp">
                        <button class="btn btn-primary">{{__('trans.Submit')}}</button>
                    </div>
                </div>

                <div class="final-price">
                    Your Final Price : {{ cart()->getTotal() }} QAR
                </div>

                @if( cart()->getTotal() === 0 )
                <div class="yellowbg-img cash-on-delivery">
                    <img src="{{asset('website/img/cash-on-delievery.png')}}" />
                    <a id="cashondelivery" href="javascript:;">Complete Your<br>Order</a>
                </div>
                @else
                <div class="yellowbg-img cash-on-delivery">
                    <div class="member">
                        <a href="javascript:;" class="pay" data-type="cc">Pay</a>
                    </div>
                    <img src="{{asset('website/img/cash-on-delievery.png')}}" />
                    <a href="javascript:;" class="pay" data-type="cod">Cash or Credit<br>on Delivery</a>
                </div>
                @endif
                <form action="{{ route('website.place-order') }}" method="post" id="place-order">
                    <input type="hidden" name="order_type" id="order_type" value="cod">
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
@push('otherscript')
<script>
    $(function(){
        // discount coupon code
        $("button.discountBtn").click(function() {
            const url = "{{ route('website.discount_coupon') }}";
            const _token = $('meta[name="csrf-token"]').attr('content');
            const discount = $("#discount_coupon").val();

            $("#cover-spin").show();
            fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json;charset=UTF-8'
                },
                body: JSON.stringify({ _token, discount })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    toastr.success(data.message);
                    location.reload();
                } else {
                    toastr.error(data.message);
                    $("#cover-spin").hide();
                }
            })
            .catch(err => console.log(err));
        });
        // gift card counpon
        $("button.giftBtn").click(function() {
            const url = "{{ route('website.giftcard_coupon') }}";
            const _token = $('meta[name="csrf-token"]').attr('content');
            const giftCard = $("#giftcard_coupon").val();

            $("#cover-spin").show();
            fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json;charset=UTF-8'
                },
                body: JSON.stringify({ _token, giftCard })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    toastr.success(data.message);
                    window.location.reload();
                } else {
                    toastr.error(data.message);
                    $("#cover-spin").hide();
                }
            })
            .catch(err => console.log(err));
        });
        // corporate coupon code
        $("button.corporateBtn").click(function() {
            const url = "{{ route('website.corporate_coupon') }}";
            const _token = $('meta[name="csrf-token"]').attr('content');
            const corporate = $("#corporate_code").val();

            $("#cover-spin").show();
            fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json;charset=UTF-8'
                },
                body: JSON.stringify({ _token, corporate })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    toastr.success(data.message);
                    window.location.reload();
                } else {
                    toastr.error(data.message);
                    $("#cover-spin").hide();
                }
            })
            .catch(err => console.log(err));
        });
        // pay
        $(".pay").click(function() {
            const type = $(this).data('type');
            $('#order_type').val(type);
            $('#place-order').submit();
        });
    });
</script>
@endpush
