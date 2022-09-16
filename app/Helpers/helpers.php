<?php

// sadad functions

use App\Models\Product;
use App\Models\Wishlist;
use Twilio\Rest\Client;

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

// general functions

if (!function_exists('cart')) {
  function cart()
  {
    $session = auth()->check() ? auth()->id() : session()->getId();
    return app('cart')->session($session);
  }
}

// send message

if ( !function_exists('sendMessage') ) {
  function sendMessage($number, $body) {
    $client = new Client(config('twilio.sid'), config('twilio.token'));
    $message = $client->messages->create($number, [
      'from' => config('twilio.number'),
      'body' => $body
    ]);
    return !in_array($message->status, ['failed', 'undelivered']);
  }
}

// send otp

if ( !function_exists('sendOTPCode') ) {
  function sendOTPCode($user) {
    $otp = rand(123456, 654321);
    $updated = $user->forceFill([ 'otp' => $otp ])->save();
    $sent = sendMessage($user->mobile, "Your one time pin is ${otp}. Use this pin for verification on Toys4Joy.");
    return $updated && $sent;
  }
}

// remove out of stock items from cart

if ( !function_exists('removeOutOfStockFromCart') ) {
  function removeOutOfStockFromCart() {
    // loading products at once for single query
    $productIds = cart()->getContent()->keys();
    $products = Product::find($productIds);
    // looping through all cart items
    cart()->getContent()->each(function($item) use ($products) {
      // finding product
      $product = $products->find($item->id);
      // if products exists then proceed
      // else remove product from cart
      if ($product) {
        // if out of stock product
        if ($product->qty == 0) {
          // removing out of stock product
          cart()->remove($item->id);
        } elseif ($product->qty < $item->quantity) {
          // update product quantity to what we have left
          cart()->update($item->id, [
            'quantity' => [
              'relative' => false,
              'value' => $product->qty
            ]
          ]);
        }
      } else {
        // removing unavailable product
        cart()->remove($item->id);
      }
    });
  }
}

// remove out of stock items from wishlist

if ( !function_exists('removeOutOfStockFromWishlist') ) {
  function removeOutOfStockFromWishlist($user_id) {
    // load wishlist with products
    $wishlist = Wishlist::with('product')->where('cust_id', $user_id)->get();
    // if wishlist exists
    if ($wishlist) {
      // looping through wishlist
      $wishlist->each(function($wish) {
        // wishlist product
        $product = $wish->product;
        // if product exists then proceed
        // else remove from wishlist
        if ($product) {
          if ($product->qty == 0) {
            // removing out of stock wishlist
            $wish->delete();
          }
        } else {
          // removing unavailable wishlist
          $wish->delete();
        }
      });
    }
  }
}

// reduce by percentage

if ( !function_exists('reduceByPercentage') ) {
  function reduceByPercentage($value, $percentage) {
    $discount = $value * ($percentage / 100);
    return $value - $discount;
  }
}

// generate unique order number

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

// generate sadad checkout form

if (!function_exists('generateSadadForm')) {
  function generateSadadForm($items, $callback)
  {
    $callback = "https://www.toys4joy.com/";
    $total_price = cart()->getTotal();

    $sadad_checksum_array = [];
    $sadad__checksum_data = [];
    $email = auth()->user()->email ?? 'toysforjoyorders@gmail.com';

    $secretKey = 'ewHgg8NgyY5zo59M';
    $merchantID = '7288803';
    $order_number = generateOrderNumber();
    $sadad_checksum_array['merchant_id'] = $merchantID;
    $sadad_checksum_array['ORDER_ID'] = $order_number;
    $sadad_checksum_array['WEBSITE'] = url('/');
    $sadad_checksum_array['VERSION'] = '1.1';
    $sadad_checksum_array['TXN_AMOUNT'] = $total_price;
    $sadad_checksum_array['CUST_ID'] = $email;
    $sadad_checksum_array['EMAIL'] = $email;
    $sadad_checksum_array['MOBILE_NO'] = '999999999';
    $sadad_checksum_array['SADAD_WEBCHECKOUT_PAGE_LANGUAGE'] = 'ENG';
    $sadad_checksum_array['CALLBACK_URL'] = $callback;
    $sadad_checksum_array['txnDate'] = now();

    foreach ($items as $item) {
        $allproducts[] = [
          'order_id' => $order_number,
          'itemname' => $item->name,
          'quantity' => $item->quantity,
          'amount' =>$item->price
        ];
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

    $form = '<form action="https://sadadqa.com/webpurchase" method="post" id="paymentform" name="paymentform" data-link="https://sadadqa.com/webpurchase">' . implode('', $sAry1) . '</form>';

    return $form;
  }
}