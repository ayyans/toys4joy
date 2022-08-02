@extends('website.layouts.master')
@section('content')

<main id="pay-as-member" class="pay-as-member-page">
<div class="container-fluid">
    <div class="row">
       
        <div class="col-6 member-col left">
        <form action="{{ url('place-order-process') }}" method="POST" id="checkoutFrm">
            <?php $total_price = 0; ?>
            @foreach($products as $product)

            @php
              if($product->discount)
              {
                  $price = $product->discount;
              }else{
                  $price = $product->unit_price;
              }
            @endphp
            <?php $total_price+=$price*$product->cartQty; ?>
            <input type="hidden" id="prod_id" value="{{$product->id}}" name="prodid[]" />
            <input type="hidden" id="cart_qty" value="{{$product->cartQty}}" name="cartQty[]" />
            <input type="hidden" id="cart_amount" value="{{$price}}" name="cart_amount[]" />
            <div class="d-flex cart-products">
                <div class="cart-image"><img src="{{asset('products/'.$product->featured_img)}}"/></div>
                <div class="product-detail">
                    <h2 class="title">{{$product->title}}</h2>
                    <h4 class="price">QAR {{$price}}</h4>
                    <div class="qty">Quantity : {{$product->cartQty}}</div>
                    <div class="d-flex rmv-or-edit">
                        <div class="remove icon"><a href="javascript:void(0)" onclick="removecart({{$product->crtid}})"><img src="{{asset('website/img/delete.png')}}"/></a></div>
                        <!-- <div class="edit icon"><a href="#"><img src="{{asset('website/img/edit.png')}}"/></a></div> -->
                    </div>
                </div>
            </div>
            @endforeach
            </form>
            
            
        </div>

<div class="col-6 member-col right text-center">
    <div style="margin-top: 0px;" class="discount-block">
        <div class="mb-3">
            <label>Discount Code</label>
            <input type="text" id="discount_coupon">
            <button class="btn btn-primary discountBtn">Enter</button>
        </div>
        <div class="mb-3">
            <label>Gift-Card Code</label>
            <input type="text" id="giftcard_coupon">
            <button class="btn btn-primary giftBtn">Enter</button>
        </div>
    </div>
    <div class="code-block">
        <div class="mb-3">
            <label>Corporate Code</label>
            <input type="text" id="corporate_code">
            <button class="btn btn-primary corporateBtn">Enter</button>
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
            <div class="yellowbg-img cash-on-delivery">
                <div class="member">
                    <a onclick="submitpayementform()" href="javascript:void(0)" id="cashOnD" class="pay-btn">Pay</a>
                </div>
                <img src="{{asset('website/img/cash-on-delievery.png')}}"/>
                    <a id="cashondelivery" href="javascript:void(0)">Cash or Credit<br>on Delivery</a>
            </div>
        </div>
    </div>
</div>

</main>
<?php 
function getChecksumFromString($str, $key) { 

 $salt = generateSalt_e(4); 
 $finalString = $str . "|" . $salt; 
 $hash = hash("sha256", $finalString); 
 $hashString = $hash . $salt; 
 $checksum = encrypt_e($hashString, $key); 
 return $checksum; 

} 

function generateSalt_e($length) { 

 $random = ""; 
 srand((double) microtime() * 1000000); 
 $data = "AbcDE123IJKLMN67QRSTUVWXYZ"; 
 $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz"; 
 $data .= "0FGH45OP89"; 
 for ($i = 0; $i < $length; $i++) { 
 $random .= substr($data, (rand() % (strlen($data))), 1);  } 
 return $random; 
} 

function encrypt_e($input, $ky) { 
 $ky = html_entity_decode($ky); 
 $iv = "@@@@&&&&####$$$$"; 
 $data = openssl_encrypt($input, "AES-128-CBC", $ky, 0, $iv);  return $data; 
} 

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
 $sadad_checksum_array['CALLBACK_URL'] = url('orderconferm'); 
 $sadad_checksum_array['txnDate'] = $txnDate; 

foreach ($products as $product) {

    if($product->discount)
      {
          $price = $product->discount;
      }else{
          $price = $product->unit_price;
      }

    
    $json_decoded = json_decode($product);
    $allproducts[] = array('order_id' => $orderid, 'itemname' => $product->title, 'amount' =>$price, 'quantity' => $product->cartQty);
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
                if(js_data.status==200){
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
        $("button.discountBtn").click(function(e){
            e.preventDefault();
            var total_amt3 = $("#prev_amt").val();
            $("#total_offer_amt").text(total_amt3);
            $("#total_amt").val(total_amt3);  
            var discount_coupon = $("#discount_coupon").val();
            if(discount_coupon==''){
                return false;
            }else{
                $("#cover-spin").show();
                var form = new FormData();
                form.append('discount_coupon',discount_coupon);
                $.ajax({
                    url:"{{route('website.discount_coupon')}}",
                    type:"POST",
                    data:form,
                    cache:false,
                    contentType:false,
                    processData:false,
                    success:function(res){
                        $("#cover-spin").hide();
                        var js_data = JSON.parse(JSON.stringify(res));
                        if(js_data.status==200){
                            var total_amt = $("#total_amt").val();
                            var total_amt2 = parseInt(total_amt);
                            var discount_offer = total_amt2*parseInt(js_data.msg.offer)/100;
                            var total_amt_with_dis = total_amt2-parseInt(discount_offer);
                            $("#total_offer_amt").text(total_amt_with_dis);
                            $("#total_amt").val(total_amt_with_dis);

                        }else{
                            var total_amt = $("#prev_amt").val();
                           $("#total_offer_amt").text(total_amt);
                           $("#total_amt").val(total_amt);     
                        }

                    }
                })
            }
        });

        // gift card counpon 


        $("button.giftBtn").click(function(e){
            e.preventDefault();
            var total_amt3 = $("#prev_amt").val();
            $("#total_offer_amt").text(total_amt3);
            $("#total_amt").val(total_amt3);  
            var discount_coupon = $("#giftcard_coupon").val();
            if(discount_coupon==''){
                return false;
            }else{
                $("#cover-spin").show();
                var form = new FormData();
                form.append('discount_coupon',discount_coupon);
                $.ajax({
                    url:"{{route('website.giftcard_coupon')}}",
                    type:"POST",
                    data:form,
                    cache:false,
                    contentType:false,
                    processData:false,
                    success:function(res){
                        $("#cover-spin").hide();
                        var js_data = JSON.parse(JSON.stringify(res));
                        if(js_data.status==200){
                            var total_amt = $("#total_amt").val();
                            var total_amt2 = parseInt(total_amt);
                            var discount_offer = total_amt2*parseInt(js_data.msg.offer)/100;
                            var total_amt_with_dis = total_amt2-parseInt(discount_offer);
                            $("#total_offer_amt").text(total_amt_with_dis);
                            $("#total_amt").val(total_amt_with_dis);

                        }else{
                            var total_amt = $("#prev_amt").val();
                           $("#total_offer_amt").text(total_amt);
                           $("#total_amt").val(total_amt);     
                        }

                    }
                })
            }
        })

        // corporate coupon code

        

        $("button.corporateBtn").click(function(e){
            e.preventDefault();
            var total_amt3 = $("#prev_amt").val();
            $("#total_offer_amt").text(total_amt3);
            $("#total_amt").val(total_amt3);  
            var discount_coupon = $("#corporate_code").val();
            if(discount_coupon==''){
                return false;
            }else{
                $("#cover-spin").show();
                var form = new FormData();
                form.append('discount_coupon',discount_coupon);
                $.ajax({
                    url:"{{route('website.corporate_coupon')}}",
                    type:"POST",
                    data:form,
                    cache:false,
                    contentType:false,
                    processData:false,
                    success:function(res){
                        $("#cover-spin").hide();
                        var js_data = JSON.parse(JSON.stringify(res));
                        if(js_data.status==200){
                            var total_amt = $("#total_amt").val();
                            var total_amt2 = parseInt(total_amt);
                            var discount_offer = total_amt2*parseInt(js_data.msg.offer)/100;
                            var total_amt_with_dis = total_amt2-parseInt(discount_offer);
                            $("#total_offer_amt").text(total_amt_with_dis);
                            $("#total_amt").val(total_amt_with_dis);

                        }else{
                            var total_amt = $("#prev_amt").val();
                           $("#total_offer_amt").text(total_amt);
                           $("#total_amt").val(total_amt);     
                        }

                    }
                })
            }
        })



    })
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
                if(js_data.status==200){
                    var url = "{{ url('confermordercod') }}";
                    window.location.href=url+'/'+js_data.orderid;
                }else if(js_data.status==300){
                    toastr.options.timeOut = 10000;
                    toastr.error('Please add Address');
                    window.location.href="{{route('website.addAddressInfo')}}"
                }else{
                    return false;
                }
            }
        })

    })
</script>

@endpush