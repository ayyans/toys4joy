<?php

// sadad functions

use App\Models\Order;
use Illuminate\Support\Str;

if (!function_exists('getChecksumFromString')) {
  function getChecksumFromString($str, $key)
  {
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    $checksum = encrypt_e($hashString, $key);
    return $checksum;
  }
}

if (!function_exists('generateSalt_e')) {
  function generateSalt_e($length)
  {
    $random = "";
    srand((float) microtime() * 1000000);
    $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
    $data .= "0FGH45OP89";
    for ($i = 0; $i < $length; $i++) {
      $random .= substr($data, (rand() % (strlen($data))), 1);
    }
    return $random;
  }
}

if (!function_exists('encrypt_e')) {
  function encrypt_e($input, $ky)
  {
    $ky = html_entity_decode($ky);
    $iv = "@@@@&&&&####$$$$";
    $data = openssl_encrypt($input, "AES-128-CBC", $ky, 0, $iv);
    return $data;
  }
}

if (!function_exists('generateOrderNumber')) {
  function generateOrderNumber()
  {
    if (session()->missing('order_number')) {
      $orderNumber = rand('123456798' , '987654321');
      session(['order_number' => $orderNumber]);
    }
    return session('order_number');
  }
}

if (!function_exists('generateSadadForm')) {
  function generateSadadForm($items, $callback)
  {
    $total_price = \Cart::getTotal();

    $sadad_checksum_array = [];
    $sadad__checksum_data = [];
    $txnDate = now();
    $email = auth()->user()->email ?? 'toysforjoyorders@gmail.com';

    $secretKey = 'ewHgg8NgyY5zo59M';
    $merchantID = '7288803';
    $order_number = generateOrderNumber();
    $sadad_checksum_array['merchant_id'] = $merchantID;
    $sadad_checksum_array['ORDER_ID'] = $order_number;
    $sadad_checksum_array['WEBSITE'] = url('');
    $sadad_checksum_array['VERSION'] = '1.1';
    $sadad_checksum_array['TXN_AMOUNT'] = $total_price;
    $sadad_checksum_array['CUST_ID'] = $email;
    $sadad_checksum_array['EMAIL'] = $email;
    $sadad_checksum_array['MOBILE_NO'] = '999999999';
    $sadad_checksum_array['SADAD_WEBCHECKOUT_PAGE_LANGUAGE'] = 'ENG';
    $sadad_checksum_array['CALLBACK_URL'] = $callback;
    $sadad_checksum_array['txnDate'] = $txnDate;

    foreach ($items as $item) {
        $allproducts[] = array('order_id' => $order_number, 'itemname' => $item->name, 'amount' =>$item->price, 'quantity' => $item->quantity);
    }

    $sadad_checksum_array['productdetail'] = $allproducts;
    $sadad__checksum_data['postData'] = $sadad_checksum_array;
    $sadad__checksum_data['secretKey'] = $secretKey;

    $sAry1 = [];
    $sadad_checksum_array1 = array();

    foreach($sadad_checksum_array as $pK => $pV) {
      if($pK=='checksumhash') continue;
      if(is_array($pV)) {
          $prodSize = sizeof($pV);
          for($i=0;$i<$prodSize;$i++) {
              foreach($pV[$i] as $innK => $innV) {
                  $sAry1[] = "<input type='hidden' name='productdetail[$i][". $innK ."]' value='" . trim($innV) . "'/>";
                  $sadad_checksum_array1['productdetail'][$i][$innK] = trim($innV);
              }
          }
      } else {
          $sAry1[] = "<input type='hidden' name='". $pK ."' id='". $pK ."' value='" . trim($pV) . "'/>";
          $sadad_checksum_array1[$pK] = trim($pV);
      }
    }

    $sadad__checksum_data['postData'] = $sadad_checksum_array1;
    $sadad__checksum_data['secretKey'] = $secretKey;  $checksum = getChecksumFromString(json_encode($sadad__checksum_data), $secretKey . $merchantID);
    $sAry1[] = "<input type='hidden'  name='checksumhash' value='" . $checksum . "'/>";

    $action_url = 'https://sadadqa.com/webpurchase';

    $form = '<form action="' . $action_url . '" method="post" id="paymentform" name="paymentform" data-link="' . $action_url .'">' . implode('', $sAry1) . '</form>';

    return $form;
  }
}

// general functions

if (!function_exists('cart')) {
  function cart()
  {
    $session = auth()->check() ? auth()->id() : session()->getId();
    return app('cart')->session($session);
  }
}
