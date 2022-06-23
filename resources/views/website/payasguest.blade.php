@extends('website.layouts.master')
@section('content')
<style type="text/css">
    .iti{
        width: 100%;
    }
</style>
<link rel="stylesheet" href="{{ url('website/phone/css/intlTelInput.css') }}">
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
                	<input id="phone" class="guestcheckinp" name="phone" type="tel">
                    <input type="hidden" name="mobilenumber" id="mobilenumber">
                </div>
                <div class="mb-3">
                	<label>Email<span style="color:#ff0000">*</span></label>
                	<input type="email" name="email" class="guestcheckinp" required>
                </div>

                
            </div>
            </form>
        </div>
        <div class="col-6 text-center">
        
           
            <div class="pay-as-guest row">
                <div class="text-center col-6">
                    <div class="guest">
                        <a href="javascript:void(0)" id="payasgueast">Pay as Guest (<span id="total_amount"></span>)</a>
                    </div>
                    <p>You need to create an account with us to be able to Enter Discount, Corporate Code, or Gift Card.</p>
                </div>
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
<script src="{{ url('website/phone/js/intlTelInput.js') }}"></script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      autoHideDialCode: false,
      formatOnDisplay: true,
      hiddenInput: "full_phone",
      placeholderNumberType: "MOBILE",
      preferredCountries: ['qa'],
      separateDialCode: true,
      utilsScript: "{{ url('website/phone/js/utils.js') }}?1638200991544",
    });
  </script>
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
    alert('ok');
}
})  
});
</script>

<script type="text/javascript">
$(function() {
$("#cashonD").click(function(e){
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
    var txt = $('.iti__selected-dial-code').text();
    var phone = $('#phone').val();
    $('#mobilenumber').val(txt+phone);
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
                window.location.href="{{route('website.guestthankorder')}}";
            }
        }
    })
}
})  
});
</script>
@endpush