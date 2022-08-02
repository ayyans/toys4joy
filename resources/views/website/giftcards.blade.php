@extends('website.layouts.master')
@section('content')
@php

 $orderid = rand('123456798' , '987654321');
@endphp
<div class="egift-card-guest-page egift-card-member-page">
<main  id="pay-as-guest" class="p-2 p-md-5">
<div class="container-fluid">
    <div class="row">
        <div class="text-center green-text title"><h2>Buy E-Gift Cards to the ones you loved.</h2></div>
    	{{-- <div class="col-4">
            <div class="img-box">
                <img src="{{asset('website/img/toy-gift-box.png')}}"/>
            </div>
        </div> --}}
        
        <div class="col-12 text-center">
            <div class="row align-items-center gy-4">
                <div class="col-xl-4">
                    <div class="img-box">
                        <img src="{{asset('website/img/toy-gift-box.png')}}" style="max-width: 200px"/>
                    </div>
                </div>
                <div class="col-xl-4">
                    <form method="get" id="giftcardsformforslection" class="qr-price-select">
                        <div class="row">
                            @foreach(DB::table('giftcards')->where('status' , 2)->get() as $r) 
                            <div class="col-md-6">
                                <div class="green r-btn">
                                    <input onclick="formsubmit()" @if(isset($_GET['card'])) @if($_GET['card'] == $r->id) checked @endif @endif type="radio" id="card{{  $r->id }}" name="card" value="{{  $r->id }}">
                                    <label for="card{{  $r->id }}" class="green-text">{{ $r->price }} QR</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="col-xl-4">
                    <div class="pay-as-member">
                        <div class="text-center">
                            <div class="gift-cards member">
                                <a onclick="paymentsubmit()">Pay by Debit/Credit Card</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function formsubmit()
            {
                $('#giftcardsformforslection').submit();
            }
            
        </script>
        @if(isset($_GET["card"]))
        <script type="text/javascript">
            function paymentsubmit()
            {
                var orderid = '{{ $orderid }}';
                var cardid = '{{ $_GET["card"] }}';
                var app_url = '{{ url("addgiftcard") }}';
                $.ajax({
                    type: "GET",
                    url: app_url+'/'+cardid+'/'+orderid,
                    success: function(resp) {
                        $('#paymentform').submit();
                    }
                });
            }
        </script>
        @endif
        {{-- <div class="col-4 text-center">
            <div class="pay-as-member">
                <div class="text-center">
                    <div class="member">
                        <a onclick="paymentsubmit()">Pay by Debit/Credit Card</a>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
</main>
</div>
@if(isset($_GET['card']))

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
 $giftcard = DB::table('giftcards')->where('status' , 2)->where('id' , $_GET['card'])->get()->first();
 $sadad_checksum_array['ORDER_ID'] = $orderid; 
 $sadad_checksum_array['WEBSITE'] = 'https://toys4joy.com/';  
 $sadad_checksum_array['VERSION'] = '1.1';
 $sadad_checksum_array['TXN_AMOUNT'] = $giftcard->price; 
 $sadad_checksum_array['CUST_ID'] = $email; 
 $sadad_checksum_array['EMAIL'] = $email; 
 $sadad_checksum_array['MOBILE_NO'] = '999999999';  
 $sadad_checksum_array['SADAD_WEBCHECKOUT_PAGE_LANGUAGE'] = 'ENG';  
 $sadad_checksum_array['CALLBACK_URL'] = 'https://toys4joy.com/giftcardconfermorder'; 
 $sadad_checksum_array['txnDate'] = $txnDate; 
 

  
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
@endif
@stop