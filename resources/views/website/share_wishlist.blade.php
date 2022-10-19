@extends('website.layouts.master')
@section('content')
@php
$orderid = rand('123456798' , '987654321');
@endphp

@if($wshlists->count())
@if($wshlists->where('share_status' , 0)->count() > 0)
<?php 

 $sadad_checksum_array = array(); 
 $sadad__checksum_data = array(); 
 $txnDate = date('Y-m-d H:i:s'); 
 $email = $wshlists->first()->email;
 $secretKey = 'ewHgg8NgyY5zo59M'; 
 $merchantID = '7288803';
 
 $sadad_checksum_array['merchant_id'] = $merchantID;  
 $sadad_checksum_array['ORDER_ID'] = $orderid; 
 $sadad_checksum_array['WEBSITE'] = url('');  
 $sadad_checksum_array['TXN_AMOUNT'] = '50.00'; 
 $sadad_checksum_array['CUST_ID'] = $email; 
 $sadad_checksum_array['EMAIL'] = $email; 
 $sadad_checksum_array['MOBILE_NO'] = '999999999';  
 $sadad_checksum_array['SADAD_WEBCHECKOUT_PAGE_LANGUAGE'] = 'ENG';  
 $sadad_checksum_array['CALLBACK_URL'] = url('wishlistorderconferm'); 
 $sadad_checksum_array['txnDate'] = $txnDate; 
foreach ($wshlists as $product) {
  if($product->share_status == 0)
  {

     if($product->discount)
      {
          $price = $product->discount;
      }else{
          $price = $product->unit_price;
      }


    $json_decoded = json_decode($product);
    $allproducts[] = array('order_id' => $orderid, 'itemname' => $product->title, 'amount' =>$price, 'quantity' =>1);
  }
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
/*#quantity{
    height: 40px;
    width: 40px;
}*/
.wishlist-qty{
    height: 40px;
    width: 40px;
}
.lable-area {
    padding: 10px;
    /*border: 1px solid skyblue;*/
}   
.star-lable{
    color: red;
    font-size: 20px;
}
.input-area{
    border-color: skyblue;
    padding: 9px 20px;
    margin-left: -5px;
}
.message-area{
  margin-left: 11px;
    padding-left: 24px;
}
.input-areas{
    border-color: skyblue;
    padding: 9px 75px;
    margin-left: -5px;
}
@media only screen and (max-width: 576px) {
    .textarea {
    width: 82%;
    margin-left: 80px;
}
}
@media screen and (max-width: 480px) {
    .textarea {
    width: 82%;
    margin-left: 80px;
}
}
@media only screen and (max-width: 600px) {
  .textarea {
    width: 82%;
    margin-left: 80px;
}
}
@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  .textarea {
    width: 82%;
    margin-left: 80px;
}
.wishlist-qty{
    height: 20px;
    width: 20px;
}
}
.textarea{
    width: 82%;
    border-color: skyblue;
    padding-left: 0px;
    margin-left: 16px;
}
#my-account {
    /*padding: 20px 100px;*/
}
</style>
<main style="display: none;" id="my-account" class="my-basket my-wishlist-page">
    <div class="container">
        <form method="POST">
        <div class="row content-block">
            <div class="col-md-6 col-xl-6 col-sm-12 mt-3">
                <label class="star-lable">*</label>
                <label class="lable-area">{{__('trans.Payer Name')}}</label>
                <input class="input-areas code-block" type="text" id="name">
            </div>
            <div class="col-md-6 col-lg-6 mt-3">
                <label class="star-lable">*</label>
                <label class="lable-area">{{__('trans.Mobile Number')}}</label>
                <input class=" input-area code-block" type="number" id="mobilenumber">
            </div>
            <div class="col-md-1 col-lg-1 mt-3">
                
                <label class="lable-area message-area">{{__('trans.Your Message')}}</label>
            </div>
            <div class="col-md-11 col-lg-11 mt-3">
                <textarea class="input-area code-block" id="message" rows="5" style="width: 100%;"></textarea>
            </div>
            <div style="margin-top: 50px;" class="d-flex ftr-btn-area">
                <div class="vertical-shake continue-shopping"></div>
                <div class="d-flex pay-as">
                    <div onclick="submitpayementform()" class="guest"><a href="javascript:void(0)">{{__('trans.Pay With Card')}}</a></div>
                </div>
            </div>
           
        </div>
        </form>
    </div>
</main>
<main id="products-ranking" class="my-basket my-wishlist-page">
<div class="container-fluid">
    <div class="row">
    	<div class="col-12">
            <div class="d-flex main-title">
                <div class="title">{{ $wshlists->first()->name }} {{__('trans.Wish List')}}</div>
                <div class="icon">
                    <button class="btn btn-primary" type="button"><img src="{{asset('website/img/wishlist-heart.png')}}" class="wishlist"></button>
                </div>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th class="first"></th>
                  <th>{{__('trans.Name')}}</th>
                  <th>{{__('trans.Images')}}</th>
                  <th>{{__('trans.Prices')}}</th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $total_price = 0; ?>
                @foreach($wshlists as $wishlist)

                @if($wishlist->share_status == 0)
                @php
                if($wishlist->discount)
                  {
                      $price = $wishlist->discount;
                  }else{
                      $price = $wishlist->unit_price;
                  }
                  $total_price+=$price;
                @endphp

                @else


                @php
                if($wishlist->discount)
                  {
                      $price = $wishlist->discount;
                  }else{
                      $price = $wishlist->unit_price;
                  }
                @endphp


                @endif

                <tr>
                    <td class="qty">
                      <input style="" onclick="removefromwishlist({{$wishlist->wish_id}})" type="checkbox" @if($wishlist->share_status == 0) checked @endif value="1" id="quantity" class="wishlist-qty" name="quantity">
                    </td>
                    <td class="title">
                      <div class="d-flex product-rank">
                          <div class="detail"><a href="{{ url('product') }}/{{ $wishlist->url }}" style="text-decoration:none"><p>{{$wishlist->title}}</p></a></div>
                      </div>
                    </td>
                    <td><div class="img-box"><a href="{{ url('product') }}/{{ $wishlist->url }}"><img src="{{asset('products/'.$wishlist->featured_img)}}"/></a></div></td>
                    <td class="price"><span>{{$price}} QAR</span></td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <td colspan="2">{{__('trans.Total Price')}}</td>
                    <td colspan="4">{{$total_price}} QAR</td>
                </tr>
              </tfoot>    
            </table>
            <div class="d-flex ftr-btn-area">
                <div class="vertical-shake continue-shopping"></div>
                <div class="d-flex pay-as">
                    <div onclick="placeorderwishlist()" class="guest"><a href="javascript:void(0)">{{__('trans.Place Order')}} (QAR{{$total_price}})</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@else
<main id="products-ranking" class="my-basket my-wishlist-page">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex main-title">
                <div class="title">{{ $wshlists->first()->name }} {{__('trans.Wish List')}}</div>
                <div class="icon">
                    <button class="btn btn-primary" type="button"><img src="{{asset('website/img/wishlist-heart.png')}}" class="wishlist"></button>
                </div>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th class="first"></th>
                  <th>{{__('trans.Name')}}</th>
                  <th>{{__('trans.Images')}}</th>
                  <th>{{__('trans.Prices')}}</th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $total_price = 0; ?>
                @foreach($wshlists as $wishlist)
                @php
                if($wishlist->discount)
                  {
                      $price = $wishlist->discount;
                  }else{
                      $price = $wishlist->unit_price;
                  }
                @endphp
                @if($wishlist->share_status == 0)

                    @php
                      $total_price+=$price;
                    @endphp

                @endif
                <tr>
                    <td class="qty">
                      <input style="height: 40px;width: 40px;" onclick="removefromwishlist({{$wishlist->wish_id}})" type="checkbox" @if($wishlist->share_status == 0) checked @endif value="1" id="quantity" name="quantity">
                    </td>
                    <td class="title">
                      <div class="d-flex product-rank">
                          <div class="detail"><a href="{{ url('product') }}/{{ $wishlist->url }}" style="text-decoration:none"><p>{{$wishlist->title}}</p></a></div>
                      </div>
                    </td>
                    <td><div class="img-box"><a href="{{ url('product') }}/{{ $wishlist->url }}"><img src="{{asset('products/'.$wishlist->featured_img)}}"/></a></div></td>
                    <td class="price"><span>{{$price}} QAR</span></td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <td colspan="2">{{__('trans.Total Price')}}</td>
                    <td colspan="4">{{$total_price}} QAR</td>
                </tr>
              </tfoot>    
            </table>
            <div class="d-flex ftr-btn-area">
                <div class="vertical-shake continue-shopping"></div>
                <div class="d-flex pay-as">
                    <div onclick="placeorderzerowishlist()" class="guest"><a href="javascript:void(0)">{{__('trans.Place Order')}} (QAR{{$total_price}})</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<script type="text/javascript">
    function placeorderzerowishlist()
    {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Please Select Atleast one Product',
            showConfirmButton: false,
            timer: 3500
          })
    }
</script>
@endif





<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
@stop

@push('otherscript')
<script>

    function submitpayementform()
    {
        var form_data = new FormData();
        form_data.append('name', $('#name').val());
        form_data.append('phonenumber', $('#mobilenumber').val());
        form_data.append('message',$('#message').val());
        form_data.append('orderid','{{ $orderid }}');
        $.ajax({
            type: "POST",
            url: '{{ url("savegreetings") }}',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res) {
                $('#paymentform').submit();
            }
        });
        
    }


  $("input.quantity").change(function(){
    var id = $(this).attr('data');
    var qty = $(this).val();
    $("button.addtocartBtn"+id).attr('data',qty);
  })
  function removefromwishlist(id)
  {   
    var url = '{{ url("removefromwishlists") }}/'+id
    window.location.href=url;
  }
  function placeorderwishlist()
  {
    $("#cover-spin").show();
    $.ajax({
        url:"{{ url('placeorderwishlist') }}/"+'{{ $cust_id }}/'+'{{ $orderid }}',
        type:"GET",
        success:function(res)
        {
             $("#cover-spin").hide();
              var js_data = JSON.parse(JSON.stringify(res));
              if(js_data.status==200){
                $('#products-ranking').hide();
                $('#my-account').show();         
              }else if(js_data.status==300){
                  toastr.options.timeOut = 10000;
                  toastr.error('Please Select Atleast one Product');
              }else if(js_data.status==400){
                  toastr.options.timeOut = 10000;
                  toastr.error('{{ $wshlists->first()->name }} does not added any address for shipping');
              }else{
                  return false;
            }
        }
    })
  }
</script>
@endpush


@else

<main id="products-ranking" class="my-basket my-wishlist-page">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3>This Link is Empty or you enter a Wrong Link!</h3>
        </div>
    </div>
</div>
</main>
@endif
