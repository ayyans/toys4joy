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
    Route::post('/confermotp','LoginController@confermotp')->name('confermotp');
    Route::get('/verification','LoginController@verificationotp')->name('otp');
    Route::get('/forgot-password','LoginController@forgot_password')->name('forgot_password');
    Route::post('/forgot-password','LoginController@send_forgot_password')->name('send_forgot_password');
    Route::get('/reset-password/email/{email}/token/{token}','LoginController@reset_password')->name('reset_password');
    Route::post('/reset-password','LoginController@set_reset_password')->name('set_reset_password');
});

Route::name('website.')->namespace('App\Http\Controllers\Website')->group(function(){
    Route::get('/','WebsiteController@index')->name('home');
    Route::get('brand/{id}','WebsiteController@brandshow');
    
    Route::get('/showcart','WebsiteController@showcart');
    Route::get('/cartpagecontent','WebsiteController@cartPageContent');
    Route::get('/why-us','WebsiteController@whyus')->name('whyus');
    Route::get('/company-policy','WebsiteController@policy')->name('policy');
    Route::post('submitformlookingfor','WebsiteController@submitformlookingfor')->name('submitformlookingfor');
    Route::get('/rewards-policy','WebsiteController@rewardspolicy');
    Route::get('/return-policy','WebsiteController@returnpolicy');
    Route::get('/delivery-policy','WebsiteController@deliverypolicy');
    Route::get('/privacy-policy','WebsiteController@privacypolicy');
    Route::get('generateinvoice/{id}','OrderController@generatepdf');
    Route::get('/terms-and-conditions','WebsiteController@termsandconditions')->name('termsandconditions');
    Route::get('/contact-us','WebsiteController@contact')->name('contact');
    Route::get('/newarrivals','WebsiteController@newarrivals')->name('newarrivals');
    Route::get('/brands','WebsiteController@brands')->name('brands');
    Route::get('/bestoffers','WebsiteController@bestoffers')->name('bestoffers');
    Route::get('/bestsellers','WebsiteController@bestsellers')->name('bestsellers');
    Route::get('/removefromwishlists/{id}','WebsiteController@removefromwishlists');
    Route::get('/confermordercod/{id}','WebsiteController@confermordercod')->name('confermordercod');
    Route::get('category/{id}','WebsiteController@listproducts')->name('cat_products');
    Route::get('category/{main}/{id}','WebsiteController@listproductssubcategpry')->name('subcat_products');
    Route::get('product/{id}','WebsiteController@productDetails')->name('productDetails');
    Route::post('category-list-with','WebsiteController@listcategorylist')->name('listcategorylist');
    Route::get('/pay-as-guest','OrderController@payasguest')->name('payasguest');
    Route::post('/stripe','WebsiteController@StripePayment')->name('StripePayment');
    Route::post('/guest-details','OrderController@saveCustDetails')->name('saveCustDetails');
    Route::post('/orderconferm','WebsiteController@guestthank')->name('guestthank');
    Route::get('/guestthankorder/{id}','WebsiteController@guestthankorder');
    Route::get('/registration-thanks','WebsiteController@registrationThank')->name('registrationThank');
    Route::get('/share-wishlist/{cust_id}','WebsiteController@sharewishlist')->name('sharewishlist');
    Route::post('/savegreetings','WishlistController@savegreetings');
    Route::post('/payasguestordergenerate','OrderController@payasguestordergenerate')->name('payasguestordergenerate');
    Route::post('/orderconfermasguest','OrderController@orderconfermasguest')->name('orderconfermasguest');
    Route::get('/products/filter','WebsiteController@products')->name('products-filter');
    Route::post('/search','WebsiteController@search')->name('search');
});


Route::name('website.')->namespace('App\Http\Controllers\Website')->group(function(){
    Route::post('/addtocart','WebsiteController@addTocart')->name('addTocart');
    Route::post('/header-cart','WebsiteController@headerCart')->name('headerCart');
    Route::get('/cart','WebsiteController@cartpage')->name('cartpage');
    Route::post('/remove-cart','WebsiteController@removedcartProd')->name('removedcartProd');
    Route::post('/update-cart','WebsiteController@updateQTY')->name('updateQTY');
    Route::post('/discount-coupon','WebsiteController@discount_coupon')->name('discount_coupon');
    Route::post('/giftcard-coupon','UserController@giftcard_coupon')->name('giftcard_coupon');
    Route::get('/placeorderwishlist/{id}/{orderid}','WishlistController@placeorderwishlist');
    Route::post('/wishlistorderconferm','WishlistController@wishlistorderconferm');
});
Route::name('website.')->namespace('App\Http\Controllers\Website')->middleware(['auth'])->group(function(){
    Route::get('/ordeconferm','WebsiteController@ordeconferm')->name('ordeconferm');
    Route::get('/checkout','WebsiteController@payasmember')->name('payasmember');
    Route::get('/my-account','WebsiteController@myaccount')->name('myaccount');
    Route::get('/add-card','WebsiteController@addCardInfo')->name('addCardInfo');
    Route::get('/add-address-info','WebsiteController@addAddressInfo')->name('addAddressInfo');
    Route::get('/mygiftcard','UserController@mygiftcard')->name('mygiftcard');
    Route::post('/add-wishlist','WebsiteController@addWishlist')->name('addWishlist');  
    Route::get('/my-wishlist/{cust_id}','WebsiteController@mywishlist')->name('mywishlist');    
    Route::get('/remove-wishlist/{id}','WebsiteController@removeWishlist')->name('removeWishlist');

    Route::post('/orderplacepayasmember','OrderController@orderplacepayasmember')->name('orderplacepayasmember');
    

    Route::post('/submituserprofile','UserController@submituserprofile')->name('submituserprofile');
    Route::get('/addgiftcard/{id}/{orderid}','UserController@addgiftcard');
    Route::post('/giftcardconfermorder','UserController@giftcardconfermorder')->name('giftcardconfermorder');

    Route::post('/customer-address-process','UserController@addAddressProcess')->name('addAddressProcess');
    Route::post('/corporate-coupon','WebsiteController@corporate_coupon')->name('corporate_coupon');
    Route::post('/add-card-info-process','WebsiteController@Usercardinfo')->name('Usercardinfo');
    Route::post('/place-order-process','WebsiteController@placeorder')->name('placeorder');
    Route::get('/order-history','UserController@orderhistory')->name('orderhistory');
    Route::get('/orderdetail/{id}','UserController@orderdetail');
    Route::get('/my-points','WebsiteController@yourpoints')->name('yourpoints');
    Route::get('/gift-cards','WebsiteController@giftcard')->name('giftcard');
    Route::get('/my-profile','UserController@myprofile')->name('myprofile');
    Route::get('/change-password','UserController@changepassword')->name('changepassword');
    Route::POST('/updateusersecurity','UserController@updateusersecurity')->name('updateusersecurity');
    Route::get('/changemobilenumber','UserController@changemobilenumber')->name('changemobilenumber');
    Route::post('/updatemobilenumber','UserController@updatemobilenumber');
    Route::get('/mysiblings','UserController@mysiblings')->name('mysiblings');
    Route::post('/siblingsupdate','UserController@siblingsupdate');
    Route::view('/return-request','website.user.return-request-form')->name('return-request-form');
    Route::post('/return-request','UserController@returnRequest')->name('return-request');
});

require __DIR__.'/admin.php';
