@extends('website.layouts.master')
@section('content')
<main id="products-ranking" class="my-basket my-wishlist-page">
<div class="container-fluid">
    <div class="row">
    	<div class="col-12">
            <div class="d-flex main-title">
                <div class="title">{{ $wshlists->first()->name }} Wish List</div>
                <div class="icon">
                    <button class="btn btn-primary" type="button"><img src="{{asset('website/img/wishlist-heart.png')}}" class="wishlist"></button>
                </div>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th class="first"></th>
                  <th>Name</th>
                  <th>Images</th>
                  <th>Prices</th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $total_price = 0; ?>
                @foreach($wshlists as $wishlist)

                @if($wishlist->share_status == 0)
                @php
                  $total_price+=$wishlist->unit_price;
                @endphp

                @endif
                <tr>
                    <td class="qty">
                      <input onclick="removefromwishlist({{$wishlist->wish_id}})" type="checkbox" @if($wishlist->share_status == 0) checked @endif value="1" id="quantity" name="quantity">
                    </td>
                    <td class="title">
                      <div class="d-flex product-rank">
                          <div class="detail"><a href="{{ url('product') }}/{{ $wishlist->url }}" style="text-decoration:none"><p>{{$wishlist->title}}</p></a></div>
                      </div>
                    </td>
                    <td><div class="img-box"><a href="{{ url('product') }}/{{ $wishlist->url }}"><img src="{{asset('products/'.$wishlist->featured_img)}}"/></a></div></td>
                    <td class="price"><span>{{$wishlist->unit_price}} QAR</span></td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <td colspan="2">Total Price</td>
                    <td colspan="4">{{$total_price}} QAR</td>
                </tr>
              </tfoot>    
            </table>
            <div class="d-flex ftr-btn-area">
                <div class="vertical-shake continue-shopping"></div>
                <div class="d-flex pay-as">
                    <div onclick="placeorderwishlist()" class="guest"><a href="javascript:void(0)">Place Order (QAR{{$total_price}})</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
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
 $email = $wshlists->first()->email;
 $secretKey = 'ewHgg8NgyY5zo59M'; 
 $merchantID = '7288803';
 $orderid = rand('123456798' , '987654321');
 $sadad_checksum_array['merchant_id'] = $merchantID;  
 $sadad_checksum_array['ORDER_ID'] = $orderid; 
 $sadad_checksum_array['WEBSITE'] = url('');  
 $sadad_checksum_array['TXN_AMOUNT'] = '50.00'; 
 $sadad_checksum_array['CUST_ID'] = $email; 
 $sadad_checksum_array['EMAIL'] = $email; 
 $sadad_checksum_array['MOBILE_NO'] = '999999999';  
 $sadad_checksum_array['SADAD_WEBCHECKOUT_PAGE_LANGUAGE'] = 'ENG';  
 $sadad_checksum_array['CALLBACK_URL'] = url('orderconferm'); 
 $sadad_checksum_array['txnDate'] = $txnDate; 
$allproducts[] = array();
foreach ($wshlists as $product) {
  if($product->share_status == 0)
  {
    $json_decoded = json_decode($product);
    $allproducts[] = array('order_id' => $orderid, 'itemname' => $product->title, 'amount' =>$product->unit_price, 'quantity' =>1);
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
@stop

@push('otherscript')
<script>
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
                $('#paymentform').submit();                  
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

