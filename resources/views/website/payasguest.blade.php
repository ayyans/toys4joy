@extends('website.layouts.master')
@push('otherstyle')
<link rel="stylesheet" href="{{ url('website/phone/css/intlTelInput.css') }}">
<style>
    .iti {
        width: 100%;
    }
</style>
@endpush
@section('content')
<main class="pay-as-guest-page" id="pay-as-guest">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                @foreach($items as $item)
                <div class="d-flex cart-products">
                    <div class="cart-image"><img src="{{asset('products/'.$item->associatedModel['featured_img'])}}" />
                    </div>
                    <div class="product-detail">
                        <h2 class="title">{{$item->name}}</h2>
                        <h4 class="price">QAR {{$item->price}}</h4>
                        <div class="qty">{{__('trans.Quantity')}} : {{$item->quantity}}</div>
                        <div class="d-flex rmv-or-edit">
                            <div class="remove icon">
                                <a href="javascript:void(0)" onclick="removecart( {{$item->id}} , true )">
                                    <img src="{{asset('website/img/delete.png')}}" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-6 text-center">
                <form action="{{ route('website.place-order') }}" method="post" id="place-order">
                    <input type="hidden" name="order_type" id="order_type" value="cod">
                    <div style="margin-top: 0px;" class="discount-block">
                        <div class="mb-3">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" name="custname" id="custname" required>
                        </div>
                        <div class="mb-3">
                            <label>Mobile Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" id="phone" required>
                        </div>
                        <div class="mb-3">
                            <label>{{__('trans.Email Address')}} (optional)</label>
                            <input type="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label>{{__('trans.Unit Number')}} (optional)</label>
                            <input type="number" name="unit_no">
                        </div>
                        <div class="mb-3">
                            <label>{{__('trans.Building Number')}} (optional)</label>
                            <input type="number" name="building_no">
                        </div>
                        <div class="mb-3">
                            <label>{{__('trans.Zone')}} (optional)</label>
                            <input type="number" name="zone">
                        </div>
                        <div class="mb-3">
                            <label>{{__('trans.Street')}} (optional)</label>
                            <input type="number" name="street">
                        </div>
                        <p>{{__('trans.Note: One of our team member will contact you shortly to get your location & necessary information.')}}</p>
                    </div>
                </form>

                <div class="code-block">
                    <div class="mb-3">
                        <label>{{__('trans.Gift-Card Code')}}</label>
                        <div class="d-flex">
                            <input type="text" id="giftcard_coupon">
                            <button class="btn btn-primary giftBtn ms-2">{{__('trans.Enter')}}</button>
                        </div>
                    </div>
                    @php $giftCards = cart()->getConditionsByType('giftcard') @endphp
                    @foreach ($giftCards as $giftCard)
                    <div class="alert alert-success d-flex justify-content-between px-2 py-1 text-start" role="alert">
                        <span>You have redeemed {{ abs($giftCard->getValue()) }} QAR</span>
                        <a href="{{ route('website.removegiftcard', ['id' => $giftCard->getAttributes()['id'], 'name' => $giftCard->getName()]) }}"
                            class="alert-link">{{__('trans.Remove')}}</a>
                    </div>
                    @endforeach
                </div>

                <div class="pay-as-guest row">
                    <div class="text-center col-6">
                        <div class="guest">
                            <a href="javascript:;" class="pay" data-type="cc">
                                Fast Pay ({{ cart()->getTotal()}})
                            </a>
                        </div>
                        <p>You need to create an account with us to be able to Enter Discount or Corporate Code.</p>
                    </div>
                    <div class="col-6">
                        <div class="yellowbg-img cash-on-delivery">
                            <a href="javascript:;" class="pay" data-type="cod">Cash or Credit<br>on Delivery</a>
                            <img src="{{asset('website/img/cash-on-delievery.png')}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
@push('otherscript')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ url('website/phone/js/intlTelInput.js') }}"></script>
<script>
    const phone = document.querySelector("#phone");
    const iti = intlTelInput(phone, {
      autoHideDialCode: true,
      formatOnDisplay: true,
      hiddenInput: "mobile",
      placeholderNumberType: "MOBILE",
      preferredCountries: ['qa'],
      separateDialCode: true,
      utilsScript: "{{ url('website/phone/js/utils.js') }}",
    });
    // required fields
    const requiredFields = query => {
        return query.every(q => {
            const el = $(q);
            if (! el.val()) {
                toastr.error("Field is required");
                el[0].scrollIntoView(false);
                el.focus();
                return false;
            }
            return true;
        });
    }
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
                location.reload();
            } else {
                toastr.error(data.message);
                $("#cover-spin").hide();
            }
        })
        .catch(err => console.log(err));
    });
    // send otp code
    const sendOTPCode = async phone => {
        const url = "{{ route('website.send-otp-code') }}";
        const response = await fetch(url, {
            method: 'post',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ phone })
        })

        return response.ok;
    }
    // pay
    $(".pay").click(function() {
        if(! requiredFields(['#custname', '#phone']) ) return;

        const type = $(this).data('type');
        const phone = iti.getNumber();
        $('input[name=mobile]').val( phone );

        sendOTPCode(phone).then(ok => {
            if (! ok) {
                toastr.error('There is an error in sending OTP code!');
                return;
            }

            Swal.fire({
                title: 'Verification',
                html: `Please enter the OTP send on <b>${phone}</b> to complete the order.`,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                backdrop: true,
                showCancelButton: true,
                confirmButtonText: 'Verify',
                showLoaderOnConfirm: true,
                preConfirm: (otp) => {
                    const url = "{{ route('website.verify-otp-code') }}";
                    return fetch(url, {
                        method: 'post',
                        headers: {'Content-type': 'application/json'},
                        body: JSON.stringify({ phone, otp })
                    })
                    .then(response => {
                        if (! response.ok){
                            if (response.status === 401)
                                throw new Error("You have entered wrong OTP code");

                            throw new Error(response.statusText);
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(error)
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Order placed successfully',
                        timer: 2000,
                        timerProgressBar: true
                    }).then((result) => {
                        $('#order_type').val(type);
                        $('#place-order').submit();
                    })
                }
            })
        });
    });
</script>
@endpush
