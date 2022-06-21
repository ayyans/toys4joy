@extends('website.layouts.master')
@section('content')

<main id="pay-as-guest">
<div class="container-fluid">
    <div class="row">
    	<div class="col-6">
            <div class="d-flex cart-products">
                <div class="cart-image"><img src="{{asset('products/'.$products->featured_img)}}"/></div>
                <div class="product-detail">
                    <h2 class="title">{{$products->title}}</h2>
                    <h4 class="price">QAR {{$products->unit_price}}</h4>
                    <div class="qty">Quantity : {{$fnlqty}}</div>
                    <input type="hidden" value="{{$products->unit_price}}" id="initprice" />
                    <input type="hidden" value="{{$fnlqty}}" id="fnlqty" />
                    <div class="d-flex rmv-or-edit">
                        <div class="remove icon"><a href="#"><img src="{{asset('website/img/delete.png')}}"/></a></div>
                        <div class="edit icon"><a href="#"><img src="{{asset('website/img/edit.png')}}"/></a></div>
                    </div>
                </div>
            </div>
            <form action="#" method="POST" id="guestcheckoutFrm">
                @csrf
                <input type="hidden" name="prod_id" value="{{$products->id}}"/>
                <input type="hidden" name="prod_qty" value="{{$fnlqty}}"/>
            <div class="discount-block">
            	<div class="mb-3">
                	<label>Name <span style="color:#ff0000">*</span></label>
                	<input type="text" name="custname" id="custname" class="guestcheckinp" required>
                </div>
                <div class="mb-3">
                	<label>Mobile Number <span style="color:#ff0000">*</span></label>
                	<div class="d-flex phone-dropdown">
                        <div class="col-2">
                            <select name="cntrycode" class="guestcheckinp" required>
                                <option>+123</option>
                                <option>+456</option>
                                <option>+789</option>
                                <option>+112</option>
                            </select>
                        </div>
                        <div class="col-10"><input type="tel" name="mobile" class="guestcheckinp" required></div>
                    </div>
                </div>
                <div class="mb-3">
                	<label>Email<span style="color:#ff0000">*</span></label>
                	<input type="email" name="email" class="guestcheckinp" required>
                </div>

                
            </div>
            </form>
        </div>
        <div class="col-6 text-center">
            <form role="form" action="{{ route('website.StripePayment') }}" method="POST" class="require-validation"
                                                     data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                    id="payment-form">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="amount" id="payment_amount" />
            <div class="select-credit-card">
                <h4>Select Your Credit Card</h4>
                <div class="payment-opt">
                    <div class="form-check form-check-inline visa">
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                      <label class="form-check-label" for="inlineRadio1"><img for="inlineRadio1" src="{{asset('website/img/visa.png')}}"/></label>
                    </div>
                    <div class="form-check form-check-inline master-card">
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                      <label class="form-check-label" for="inlineRadio2"><img for="inlineRadio2" src="{{asset('website/img/master-card.png')}}"/></label>
                    </div>
                    <div class="form-check form-check-inline american-express">
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                      <label class="form-check-label" for="inlineRadio3"><img for="inlineRadio3" src="{{asset('website/img/american-express.png')}}"/></label>
                    </div>
                    <div class="form-check form-check-inline discover">
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="option4">
                      <label class="form-check-label" for="inlineRadio4"><img for="inlineRadio4" src="{{asset('website/img/discover.png')}}"/></label>
                    </div>
                </div>
            <div class="row card-info">
                <div class="col-8">
                    <div class="mb-3">
                	<label>Cardholder's Name <span style="color:#ff0000">*</span></label>
                	<input type="text" name="" class="carddetails">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                	<label>Card Number <span style="color:#ff0000">*</span></label>
                	<input type="text" class="carddetails card-number" maxlength="16">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                	<label>Expiry Month <span style="color:#ff0000">*</span></label>
                	<input type="text" class="carddetails card-expiry-month" placeholder="MM" maxlength="2">
                    </div>
                </div>
                <div class="col-4">
                <div class="mb-3">
                	<label>Expiry year <span style="color:#ff0000">*</span></label>
                	<input type="text" class="carddetails card-expiry-year" placeholder="YYYY" maxlength="4">
                    </div>
                </div>
                <div class="col-4">
                    <label>Security code <span style="color:#ff0000">*</span></label>
                    <div class="d-flex security-field">               
                        <input type="text" class="carddetails card-cvc" maxlength="3">
                        <img src="{{asset('website/img/cvv.png')}}"/>
                    </div>
                </div>
            </div>
            </div>
           
            <div class="pay-as-guest row">
                <div class="text-center col-6">
                    <div class="guest">
                        <a href="javascript:void(0)" id="payasgueast">Pay as Guest (<span id="total_amount"></span>)</a>
                    </div>
                    <p>You need to create an account with us to be able to Enter Discount, Corporate Code, or Gift Card.</p>
                </div>
                </form>
                <div class="col-6">
                    <div class="yellowbg-img cash-on-delivery">
                        <a href="javascript:void(0)" id="cashonD">Cash or Credit<br>on Delivery</a>
                        <img src="{{asset('website/img/cash-on-delievery.png')}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

@stop


@push('otherscript')
<script>
    $(function(){
        var price = $("#initprice").val();
        var fnlQty= $("#fnlqty").val();
        var total_amount = parseInt(price)*parseInt(fnlQty);
        $("#payment_amount").val(total_amount);
        $("#total_amount").text('QAR' +total_amount);
    })
</script>


<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {

    $("#payasgueast").click(function(e){

e.preventDefault();
  
var isValid = true;
$("input.guestcheckinp").each(function(){
    if ($.trim($(this).val()) == '') {
            isValid = false;
            $(this).css({
                "border": "1px solid red",
                "background": "#FFCECE",
                
            });
        }
        else {
            $(this).css({
                "border": "",
                "background": ""
            });
        }

});

$("textarea.guestcheckinp").each(function(){
    if ($.trim($(this).val()) == '') {
            isValid = false;
            $(this).css({
                "border": "1px solid red",
                "background": "#FFCECE",
                
            });
        }
        else {
            $(this).css({
                "border": "",
                "background": ""
            });
        }

});


if(isValid!=true){
    e.preventDefault();
    return false;
}else{
    var form = $("form#guestcheckoutFrm")[0];
    var form2 = new FormData(form);
    form2.append('mode','1');
    $.ajax({
        url:"{{route('website.saveCustDetails')}}",
        type:"POST",
        data:form2,
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){
            var js_data = JSON.parse(JSON.stringify(res));
            if(js_data.status==200){
                stripePayment(js_data.msg);
            }
        }
    })
}
})


    function stripePayment(orderid){      
       
        var isValid = true;
        $('#payment-form').append("<input type='hidden' name='orderid' value='" + orderid + "'/>");
        $("input.carddetails").each(function(){
            if ($.trim($(this).val()) == '') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        })


        if(isValid!=true){
           
            return false;
        }else{
    var form = $("#payment-form");
   
    if (!form.data('cc-on-file')) {
    
      Stripe.setPublishableKey(form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  
}
}
  
  function stripeResponseHandler(status, response) {
    var form = $("#payment-form");
   
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            form.find('input[type=text]').empty();
            form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            //console.log(token);
            form.submit();
        }
    }
  
});

</script>


<script>
    $(function(){
        $("#cashonD").click(function(e){
            e.preventDefault();
            var form = $("form#guestcheckoutFrm")[0];
            var form2 = new FormData(form);
            form2.append('mode','2');
            $("#cover-spin").show();
            $.ajax({
                url:"{{route('website.saveCustDetails')}}",
                type:"POST",
                data:form2,
                cache:false,
                contentType:false,
                processData:false,
                success:function(res){
                    var js_data = JSON.parse(JSON.stringify(res));
                    $("#cover-spin").hide();
                    if(js_data.status==200){
                        window.location.href="{{route('website.guestthank')}}";
                    }
                }
            })
        })
    })
</script>



@endpush