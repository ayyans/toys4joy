<?php

// sadad functions

use App\Models\Product;
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
  function removeOutOfStockFromWishlist() {
    // load wishlist with products
    auth()->user()->wishlist->load('product')->each(function($wish) {
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