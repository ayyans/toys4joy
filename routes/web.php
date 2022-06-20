<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::name('website.')->namespace('App\Http\Controllers\Website\Auth')->group(function(){
    Route::get('/login','LoginController@login')->name('login');
    Route::post('/login-process','LoginController@login_process')->name('login_process');
    Route::get('/register','RegisterController@register')->name('register');
    Route::post('/register-process','RegisterController@registerProcess')->name('registerProcess');
    Route::post('/logout','LoginController@logout')->name('logout');
});

Route::name('website.')->namespace('App\Http\Controllers\Website')->group(function(){
    Route::get('/','WebsiteController@index')->name('home');
    Route::get('category/{id}','WebsiteController@listproducts')->name('cat_products');
    Route::get('category/{main}/{id}','WebsiteController@listproductssubcategpry');
    Route::get('product-details/{catid}/{prodid}','WebsiteController@productDetails')->name('productDetails');
    Route::post('category-list-with','WebsiteController@listcategorylist')->name('listcategorylist');
    Route::post('/pay-as-guest','WebsiteController@payasguest')->name('payasguest');
    Route::post('/stripe','WebsiteController@StripePayment')->name('StripePayment');
    Route::post('/guest-details','WebsiteController@saveCustDetails')->name('saveCustDetails');
    Route::get('/guest-thanks','WebsiteController@guestthank')->name('guestthank');

    Route::get('/registration-thanks','WebsiteController@registrationThank')->name('registrationThank');


    Route::get('/share-wishlist/{cust_id}','WebsiteController@sharewishlist')->name('sharewishlist');  
 
   
});

Route::name('website.')->namespace('App\Http\Controllers\Website')->middleware(['auth:cust'])->group(function(){
    Route::get('/my-account','WebsiteController@myaccount')->name('myaccount');
    Route::post('/addtocart','WebsiteController@addTocart')->name('addTocart');
    Route::post('/header-cart','WebsiteController@headerCart')->name('headerCart');
    Route::get('/cart','WebsiteController@cartpage')->name('cartpage');
    Route::post('/remove-cart','WebsiteController@removedcartProd')->name('removedcartProd');
    Route::post('/update-cart','WebsiteController@updateQTY')->name('updateQTY');
    Route::get('/checkout','WebsiteController@payasmember')->name('payasmember');
    Route::get('/add-card','WebsiteController@addCardInfo')->name('addCardInfo');
    Route::get('/add-address-info','WebsiteController@addAddressInfo')->name('addAddressInfo');
    Route::post('/add-wishlist','WebsiteController@addWishlist')->name('addWishlist');  
    Route::get('/my-wishlist/{cust_id}','WebsiteController@mywishlist')->name('mywishlist');    
    Route::get('/remove-wishlist/{id}','WebsiteController@removeWishlist')->name('removeWishlist');
    Route::post('/customer-address-process','WebsiteController@addAddressProcess')->name('addAddressProcess');
    Route::post('/discount-coupon','WebsiteController@discount_coupon')->name('discount_coupon');
    Route::post('/giftcard-coupon','WebsiteController@giftcard_coupon')->name('giftcard_coupon');
    Route::post('/corporate-coupon','WebsiteController@corporate_coupon')->name('corporate_coupon');
    Route::post('/add-card-info-process','WebsiteController@Usercardinfo')->name('Usercardinfo');
    Route::post('/place-order-process','WebsiteController@placeorder')->name('placeorder');
    Route::get('/order-history','WebsiteController@orderhistory')->name('orderhistory');
    Route::get('/my-points','WebsiteController@yourpoints')->name('yourpoints');
    Route::get('/gift-cards','WebsiteController@giftcard')->name('giftcard');
    Route::get('/my-profile','WebsiteController@myprofile')->name('myprofile');
    Route::get('/change-password','WebsiteController@changepassword')->name('changepassword');
});

require __DIR__.'/admin.php';
