@extends('website.layouts.master')
@section('content')
@php cart()->clearCartConditions() @endphp
<?php 

 $sadad_checksum_array = array(); 
 $sadad__checksum_data = array(); 
 $txnDate = date('Y-m-d H:i:s'); 

if(Auth::check())
{
    $email = Auth::user()->email;
}else{
    $email = 'ahsinjavaid890@gmail.com';
}
 $secretKey = 'ewHgg8NgyY5zo59M'; 
 $merchantID = '7288803'; 
 $sadad_checksum_array['merchant_id'] = $merchantID;  
 $orderid = rand('123456798' , '987654321');
 $sadad_checksum_array['ORDER_ID'] = $orderid; 
 $sadad_checksum_array['WEBSITE'] = url('');  
 $sadad_checksum_array['TXN_AMOUNT'] = '50.00'; 
 $sadad_checksum_array['CUST_ID'] = $email; 
 $sadad_checksum_array['EMAIL'] = $email; 
 $sadad_checksum_array['MOBILE_NO'] = '999999999';  
 $sadad_checksum_array['SADAD_WEBCHECKOUT_PAGE_LANGUAGE'] = 'ENG';  
 $sadad_checksum_array['CALLBACK_URL'] = url('orderconfermasguest'); 
 $sadad_checksum_array['txnDate'] = $txnDate; 
           

foreach ($items as $item) {

    // if($product->discount)
    //   {
    //       $price = $product->discount;
    //   }else{
    //       $price = $product->unit_price;
    //   }

    
    $json_decoded = json_decode($item);
    $allproducts[] = array('order_id' => $orderid, 'itemname' => $item->name, 'amount' => $item->price, 'quantity' => $item->quantity);
}
$sadad_checksum_array['productdetail'] = $allproducts;


  
        $sadad__checksum_data['postData'] = $sadad_checksum_array;  
$sadad__checksum_data['secretKey'] = $secretKey; 

$sAry1 = array(); 

                $sadad_checksum_array1 = array(); 
                foreach($sadad_checksum_array as $pK => $pV){ 
                    if($pK=='checksumhash') continue; 
                    if(is_array($pV)){ 
                        $prodSize = sizeof($pV); 
                        for($i=0;$i<$prodSize;$i++){ 
                            foreach($pV[$i] as $innK => 
$innV){ 
        $sAry1[] = "<input type='hidden' name='productdetail[$i][". $innK ."]' value='" . trim($innV) 
. "'/>"; 
    $sadad_checksum_array1['productdetail'][$i][$innK] = 
trim($innV); 
        } 
    } 
                    } else { 
                        $sAry1[] = "<input type='hidden' name='". $pK ."' id='". $pK ."' value='" . trim($pV) . "'/>"; 
$sadad_checksum_array1[$pK] = 
trim($pV); 
        } 
    } 
$sadad__checksum_data['postData'] = $sadad_checksum_array1;  
$sadad__checksum_data['secretKey'] = $secretKey;  $checksum 
= 
getChecksumFromString(json_encode($sadad__checksum_data), $secretKey . 
$merchantID); 
 $sAry1[] = "<input type='hidden'  name='checksumhash' 
value='" . $checksum . "'/>"; 

$action_url = 'https://sadadqa.com/webpurchase';   
        echo '<form action="' . $action_url . '" method="post" id="paymentform" name="paymentform" data-link="' . $action_url .'">' 
        . implode('', $sAry1) . '
        </form>';
?>
<style type="text/css">
    .iti{
        width: 100%;
    }
</style>
<link rel="stylesheet" href="{{ url('website/phone/css/intlTelInput.css') }}">
<main class="pay-as-guest-page" id="pay-as-guest">
<div class="container-fluid">
    <div class="row">
    	<div class="col-6">
            @php $total_price = \Cart::getTotal() @endphp
            @foreach($items as $item)

            {{-- @php
              if($product->discount)
              {
                  $price = $product->discount;
              }else{
                  $price = $product->unit_price;
              }
            @endphp --}}
            <?php //$total_price+=$price*$product->cartQty; ?>
            <input type="hidden" id="prod_id" value="{{$item->id}}" name="prodid[]" />
            <input type="hidden" id="cart_qty" value="{{$item->quantity}}" name="cartQty[]" />
            <input type="hidden" id="cart_amount" value="{{$item->price}}" name="cart_amount[]" />
            <div class="d-flex cart-products">
                <div class="cart-image"><img src="{{asset('products/'.$item->associatedModel['featured_img'])}}"/></div>
                <div class="product-detail">
                    <h2 class="title">{{$item->name}}</h2>
                    <h4 class="price">QAR {{$item->price}}</h4>
                    <div class="qty">Quantity : {{$item->quantity}}</div>
                    <div class="d-flex rmv-or-edit">
                        <div class="remove icon"><a href="javascript:void(0)" onclick="removecart({{$item->id}})"><img src="{{asset('website/img/delete.png')}}"/></a></div>
                        <!-- <div class="edit icon"><a href="#"><img src="{{asset('website/img/edit.png')}}"/></a></div> -->
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
        <div class="col-6 text-center">
            <form action="#" method="POST" id="guestcheckoutFrm">
                @csrf
                <input type="hidden" name="prod_id" value=""/>
                <input type="hidden" name="prod_qty" value=""/>
            <div style="margin-top: 0px;" class="discount-block">
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
            <div class="pay-as-guest row">
                <div class="text-center col-6">
                    <div class="guest">
                        <a href="javascript:void(0)" id="payasgueast">Pay as Guest (<span>{{ $total_price }}</span>)</a>
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

    var txt = $('.iti__selected-dial-code').text();
    var phone = $('#phone').val();
    $('#mobilenumber').val(txt+phone);
    e.preventDefault();
    var form = $("form#guestcheckoutFrm")[0];
    var form2 = new FormData(form);
    form2.append('mode','2');
    form2.append('order_id','{{ $orderid }}');
    $("#cover-spin").show();
    $.ajax({
        url:"{{route('website.payasguestordergenerate')}}",
        type:"POST",
        data:form2,
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){
            var js_data = JSON.parse(JSON.stringify(res));
            $("#cover-spin").hide();
            if(js_data.status==200){
                 $('#paymentform').submit();
            }
        }
    })

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
    form2.append('order_id','{{ $orderid }}');
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
            if(js_data.status){
                var url = "{{ url('guestthankorder') }}";
                window.location.href=url+'/'+js_data.order_number;
            }
        }
    })
}
})  
});
</script>
@endpush