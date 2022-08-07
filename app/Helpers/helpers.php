<?php

if (! function_exists('cart') ) {
  function cart() {
    $session = auth()->check() ? auth()->id() : session()->getId();
    return app('cart')->session($session);
  }
}