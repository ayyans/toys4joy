<?php

// sadad functions

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
