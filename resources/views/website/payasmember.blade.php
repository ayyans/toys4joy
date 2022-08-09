@extends('website.layouts.master')
@section('content')

{{-- check if attached gift card or coupon expired --}}
{{-- if expired please detach --}}

<main id="pay-as-member" class="pay-as-member-page">
<div class="container-fluid">
    <div class="row">
       
        <div class="col-6 member-col left">
        <form action="{{ url('place-order-process') }}" method="POST" id="checkoutFrm">
            <?php //$total_price = 0; ?>
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
            <?php //$total_price+=$item->price*$item->cartQty; ?>
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
            </form>
        </div>


<div class="col-6 member-col right text-center">
    @php $coupon = cart()->getConditionsByType('coupon')->first() @endphp
    <div style="margin-top: 0px;" class="discount-block">
        <div class="mb-3">
            <label>Discount Code</label>
            @if ($coupon && $coupon->getName() == 'Discount Coupon')
                <input style="background-color: #ddd" readonly value="Congratulations! You have redeemed {{ abs($coupon->getValue()) }}% discount coupon" type="text">
                <a href="{{ route('website.removeDiscountCoupon', ['id' => $coupon->getAttributes()['id'], 'name' => $coupon->getName()]) }}" class="btn btn-primary discountBtn">Remove</a>
            @else
                <input type="text" id="discount_coupon" @if ($coupon) disabled @endif>
                <button class="btn btn-primary discountBtn" @if ($coupon) disabled @endif>Enter</button>
            @endif
        </div>
        {{-- @php $giftCardCondition = \Cart::getCondition('Gift Card') @endphp
        @if($giftCardCondition)
            @php
                $usergiftcard = DB::Table('usergiftcards')->where('code' , $products->first()->giftcode)->get()->first();
                $giftcard = DB::table('giftcards')->where('id' , $usergiftcard->gift_card_id)->get()->first();
                $total_price = $total_price-$giftcard->price;
            @endphp
            <div class="mb-3">
                <label>Gift-Card Redeemed</label>
                <input style="background-color: #ddd" readonly value="Congratulations! You have redeemed ({{ abs($giftCardCondition->getValue()) }})" type="text" id="giftcard_coupon">
                <a href="{{ url('removegiftcard') }}" class="btn btn-primary giftBtn">Remove</a>
            </div>
        @else --}}
        <div class="mb-3">
            <label>Gift-Card Code</label>
            <input type="text" id="giftcard_coupon">
            <button class="btn btn-primary giftBtn">Enter</button>
        </div>
        @php $giftCards = cart()->getConditionsByType('giftcard') @endphp
        @foreach ($giftCards as $giftCard)
        <div class="alert alert-success d-flex justify-content-between px-2 py-1 text-start" role="alert">
            <span>You have redeemed {{ abs($giftCard->getValue()) }} QAR</span>
            <a href="{{ route('website.removegiftcard', ['id' => $giftCard->getAttributes()['id'], 'name' => $giftCard->getName()]) }}" class="alert-link">remove</a>
        </div>
        @endforeach
        {{-- @endif --}}
    </div>
    <div class="code-block">
        <div class="mb-3">
            <label>Corporate Code</label>
            @if ($coupon && $coupon->getName() == 'Corporate Coupon')
                <input style="background-color: #ddd" readonly value="Congratulations! You have redeemed {{ abs($coupon->getValue()) }}% corporate coupon" type="text">
                <a href="{{ route('website.removeCorporateCoupon', ['id' => $coupon->getAttributes()['id'], 'name' => $coupon->getName()]) }}" class="btn btn-primary corporateBtn">Remove</a>
            @else
                <input type="text" id="corporate_code" @if ($coupon) disabled @endif>
                <button class="btn btn-primary corporateBtn" @if ($coupon) disabled @endif>Enter</button>
            @endif
        </div>
        <div class="mb-3">
            <label>Verify the OTP Code</label>
            <input type="text" id="verifyotp">
            <button class="btn btn-primary">Submit</button>
        </div>
    </div>
    <input type="hidden" id="total_amt" value="{{$total_price}}" />
    <input type="hidden" id="prev_amt" value="{{$total_price}}"/>
            <div class="final-price">Your Final Price : <span id="total_offer_amt">{{$total_price}}</span> QAR</div>
            @if($total_price == 0)
            <div class="yellowbg-img cash-on-delivery">
                <img src="{{asset('website/img/cash-on-delievery.png')}}"/>
                <a id="cashondelivery" href="javascript:void(0)">Complete Your<br>Order</a>
            </div>

            @else
            <div class="yellowbg-img cash-on-delivery">
                <div class="member">
                    <a onclick="submitpayementform()" href="javascript:void(0)" id="cashOnD" class="pay-btn">Pay</a>
                </div>
                <img src="{{asset('website/img/cash-on-delievery.png')}}"/>
                    <a id="cashondelivery" href="javascript:void(0)">Cash or Credit<br>on Delivery</a>
            </div>
            @endif
        </div>
    </div>
</div>

</main>
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
 $sadad_checksum_array['VERSION'] = '1.1';
 $sadad_checksum_array['TXN_AMOUNT'] = $total_price; 
 $sadad_checksum_array['CUST_ID'] = $email; 
 $sadad_checksum_array['EMAIL'] = $email; 
 $sadad_checksum_array['MOBILE_NO'] = '999999999';  
 $sadad_checksum_array['SADAD_WEBCHECKOUT_PAGE_LANGUAGE'] = 'ENG';  
 $sadad_checksum_array['CALLBACK_URL'] = url('orderconferm');
 $sadad_checksum_array['txnDate'] = $txnDate; 

foreach ($items as $item) {

    // if($product->discount)
    //   {
    //       $price = $product->discount;
    //   }else{
    //       $price = $product->unit_price;
    //   }

    
    $json_decoded = json_decode($item);
    $allproducts[] = array('order_id' => $orderid, 'itemname' => $item->name, 'amount' =>$item->price, 'quantity' => $item->quantity);
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
<script type="text/javascript">
    function submitpayementform()
    {
        var form = new FormData();
        form.append('order_id','{{ $orderid }}');

        $("#cover-spin").show();
        $.ajax({
            url:"{{route('website.orderplacepayasmember')}}",
            type:"POST",
            data:form,
            cache:false,
            contentType:false,
            processData:false,
            success:function(res){
                var js_data = JSON.parse(JSON.stringify(res));
                $("#cover-spin").hide();
                if(js_data.status){
                    $('#paymentform').submit();
                }
            }
        })




        
    }
</script>

@stop


@push('otherscript')
<script>
    $(function(){
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
            // e.preventDefault();
            // var total_amt3 = $("#prev_amt").val();
            // $("#total_offer_amt").text(total_amt3);
            // $("#total_amt").val(total_amt3);  
            // var discount_coupon = $("#discount_coupon").val();
            // if(discount_coupon==''){
            //     return false;
            // }else{
            //     $("#cover-spin").show();
            //     var form = new FormData();
            //     form.append('discount_coupon',discount_coupon);
            //     $.ajax({
            //         url:"{{route('website.discount_coupon')}}",
            //         type:"POST",
            //         data:form,
            //         cache:false,
            //         contentType:false,
            //         processData:false,
            //         success:function(res){
            //             $("#cover-spin").hide();
            //             var js_data = JSON.parse(JSON.stringify(res));
            //             if(js_data.status==200){
            //                 var total_amt = $("#total_amt").val();
            //                 var total_amt2 = parseInt(total_amt);
            //                 var discount_offer = total_amt2*parseInt(js_data.msg.offer)/100;
            //                 var total_amt_with_dis = total_amt2-parseInt(discount_offer);
            //                 $("#total_offer_amt").text(total_amt_with_dis);
            //                 $("#total_amt").val(total_amt_with_dis);

            //             }else{
            //                 var total_amt = $("#prev_amt").val();
            //                $("#total_offer_amt").text(total_amt);
            //                $("#total_amt").val(total_amt);     
            //             }

            //         }
            //     })
            // }
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
                    location.reload();
                } else {
                    toastr.error(data.message);
                    $("#cover-spin").hide();
                }
                
            })
            .catch(err => console.log(err));
            // e.preventDefault();
            // var total_amt3 = $("#prev_amt").val();
            // $("#total_offer_amt").text(total_amt3);
            // $("#total_amt").val(total_amt3);  
            // var discount_coupon = $("#giftcard_coupon").val();
            // if(discount_coupon==''){
            //     return false;
            // }else{
            //     $("#cover-spin").show();
            //     var form = new FormData();
            //     form.append('discount_coupon',discount_coupon);
            //     $.ajax({
            //         url:"{{route('website.giftcard_coupon')}}",
            //         type:"POST",
            //         data:form,
            //         cache:false,
            //         contentType:false,
            //         processData:false,
            //         success:function(res){
            //             $("#cover-spin").hide();
            //             var js_data = JSON.parse(JSON.stringify(res));
            //             if(js_data.status==200){

            //                 location.reload();
                            
            //             }else{

            //                 toastr.options.timeOut = 10000;
            //                 toastr.error(res.msg);
                              
            //             }

            //         }
            //     })
            // }
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
                    location.reload();
                } else {
                    toastr.error(data.message);
                    $("#cover-spin").hide();
                }
                
            })
            .catch(err => console.log(err));

            // e.preventDefault();
            // var total_amt3 = $("#prev_amt").val();
            // $("#total_offer_amt").text(total_amt3);
            // $("#total_amt").val(total_amt3);  
            // var discount_coupon = $("#corporate_code").val();
            // if(discount_coupon==''){
            //     return false;
            // }else{
            //     $("#cover-spin").show();
            //     var form = new FormData();
            //     form.append('discount_coupon',discount_coupon);
            //     $.ajax({
            //         url:"{{route('website.corporate_coupon')}}",
            //         type:"POST",
            //         data:form,
            //         cache:false,
            //         contentType:false,
            //         processData:false,
            //         success:function(res){
            //             $("#cover-spin").hide();
            //             var js_data = JSON.parse(JSON.stringify(res));
            //             if(js_data.status==200){
            //                 var total_amt = $("#total_amt").val();
            //                 var total_amt2 = parseInt(total_amt);
            //                 var discount_offer = total_amt2*parseInt(js_data.msg.offer)/100;
            //                 var total_amt_with_dis = total_amt2-parseInt(discount_offer);
            //                 $("#total_offer_amt").text(total_amt_with_dis);
            //                 $("#total_amt").val(total_amt_with_dis);

            //             }else{
            //                 var total_amt = $("#prev_amt").val();
            //                $("#total_offer_amt").text(total_amt);
            //                $("#total_amt").val(total_amt);     
            //             }

            //         }
            //     })
            // }
            })
    });
</script>
<script>
    $("#cashondelivery").click(function(e){
        e.preventDefault();
        var total_amt = $("#total_amt").val();
        var form = $("form#checkoutFrm")[0];
        var form2 = new FormData(form);
        form2.append('amount',total_amt);
        form2.append('mode','1')
        $("#cover-spin").show();
        $.ajax({
            url:"{{route('website.placeorder')}}",
            type:"POST",
            data:form2,
            cache:false,
            contentType:false,
            processData:false,
            success:function(res){
                $("#cover-spin").hide();
                var js_data = JSON.parse(JSON.stringify(res));
                if(js_data.status){
                    var url = "{{ url('confermordercod') }}";
                    window.location.href=url+'/'+js_data.order_number;
                }
            }
        })

    })
</script>

@endpush