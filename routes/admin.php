<?php


Route::name('admin.')->namespace('App\Http\Controllers\Admin\Auth')->prefix('admin')->group(function(){
    Route::get('/login','LoginController@login')->name('login');
    Route::post('/login-process','LoginController@login_process')->name('login_process');
    Route::post('/logout','LoginController@logout')->name('logout');

});

Route::name('admin.')->namespace('App\Http\Controllers\Admin')->prefix('admin')->middleware(['auth:admin'])->group(function(){
    Route::get('/home','AdminController@dashboard')->name('dashboard');

    // customer route
    Route::get('/customers','AdminController@customer')->name('customer');
    Route::get('/customers-activate/{id}','AdminController@activateCustomer')->name('activateCustomer');
    Route::get('/customers-deactivate/{id}','AdminController@deactivateCustomer')->name('deactivateCustomer');
    Route::get('/customers-delete/{id}','AdminController@deleteCust')->name('deleteCust');



    Route::get('/categories','AdminController@categories')->name('categories');
    Route::get('/add-categories','AdminController@addcategories')->name('addcategories');
    Route::get('/edit-categories/{id}','AdminController@update_categories')->name('update_categories');

     Route::post('/edit-categories-process','AdminController@edit_category_process')->name('edit_category_process');
    // category add process

    Route::post('/add-categories-process','AdminController@cateProcess')->name('cateProcess');

    // activate category
    Route::get('/activate-categories/{id}','AdminController@activateCategories')->name('activateCategories');
    Route::get('/deactivate-categories/{id}','AdminController@deactivateCategories')->name('deactivateCategories');
    Route::get('/delete-categories/{id}','AdminController@deleteCat')->name('deleteCat');


    // sub-category

    Route::get('/sub-categories','AdminController@subcategories')->name('subcategories');
    Route::get('/add-sub-categories','AdminController@addSubCat')->name('addSubCat');

    Route::post('/add-subcategories-process','AdminController@SubcateProcess')->name('SubcateProcess');


    // activate sub category

    Route::get('/activate-subcategories/{id}','AdminController@activateSubCategories')->name('activateSubCategories');
    Route::get('/deactivate-subcategories/{id}','AdminController@deactivateSubCategories')->name('deactivateSubCategories');
    Route::get('/delete-subcategories/{id}','AdminController@deleteSubCat')->name('deleteSubCat');

    // brands

    Route::get('/brands','AdminController@brands')->name('brands');
    Route::post('/add-brands','AdminController@BrandProcess')->name('BrandProcess');

    // activate brands

    Route::get('/activate-brands/{id}','AdminController@activateBrand')->name('activateBrand');
    Route::get('/deactivate-brands/{id}','AdminController@deactivateBrand')->name('deactivateBrand');
    Route::get('/delete-brands/{id}','AdminController@deleteBrands')->name('deleteBrands');

    // attribute
    Route::get('/attribute','AdminController@atribute')->name('atribute');
    Route::post('/add-attribute','AdminController@addattr')->name('addattr');

    // activate attribute

    Route::get('/activate-attribute/{id}','AdminController@activateAttr')->name('activateAttr');
    Route::get('/deactivate-attribute/{id}','AdminController@deactivatAttr')->name('deactivatAttr');
    Route::get('/delete-attribute/{id}','AdminController@deleteAttr')->name('deleteAttr');

    // attribute value 
    Route::post('/add-attribute-value','AdminController@addattrVal')->name('addattrVal');

    // activate attribute values

    Route::get('/activate-attribute-value/{id}','AdminController@activateAttrVal')->name('activateAttrVal');
    Route::get('/deactivate-attribute-value/{id}','AdminController@deactivatAttrVal')->name('deactivatAttrVal');
    Route::get('/delete-attribute-value/{id}','AdminController@deleteAttrVal')->name('deleteAttrVal');

    // products
    Route::get('/products','AdminController@products')->name('products');
    Route::get('/add-products','AdminController@addproducts')->name('addproducts');

    Route::post('/prodattribut','AdminController@prodAttrVal')->name('prodAttrVal');

    // add products process
    Route::post('/add-products-process','AdminController@addProductProcess')->name('addProductProcess');

    // activate product

    Route::get('/activate-product/{id}','AdminController@activateProd')->name('activateProd');
    Route::get('/deactivate-product/{id}','AdminController@deactivateprod')->name('deactivateprod');
    Route::get('/delete-product/{id}','AdminController@deleteprod')->name('deleteprod');
    Route::get('/edit-product/{id}','AdminController@editproducts')->name('editproducts');
    Route::post('/edit-product-process','AdminController@editProcess')->name('editProcess');

    // guest orders
    Route::get('/guest-orders','AdminController@guestOrders')->name('guestOrders');
    Route::get('/guest-orders-confirmed/{id}','AdminController@confirmGuestOrders')->name('confirmGuestOrders');
    Route::get('/guest-orders-shipped/{id}','AdminController@shippedGuestOrders')->name('shippedGuestOrders');
    Route::get('/guest-orders-cancelled/{id}','AdminController@cancelledGuestOrders')->name('cancelledGuestOrders');
    Route::get('/guest-orders-delivered/{id}','AdminController@deliveredGuestOrders')->name('deliveredGuestOrders');
    Route::get('/guest-orders-details/{id}','AdminController@guestOrdersDetails')->name('guestOrdersDetails');
    Route::post('/guest-orders-status','AdminController@orderStatus')->name('orderStatus');

//    coupons management route

    Route::get('/coupons','AdminController@coupon')->name('coupon');
    Route::post('/add-coupons-process','AdminController@addcouponProcess')->name('addcouponProcess');
    Route::get('/coupons-activate/{id}','AdminController@activateCoupon')->name('activateCoupon');
    Route::get('/coupons-deactivate/{id}','AdminController@deactivateCoupon')->name('deactivateCoupon');
    Route::get('/coupons-delete/{id}','AdminController@deleteCoupon')->name('deleteCoupon');

    // customer orders

    Route::get('/orders','AdminController@custOrders')->name('custOrders');
    Route::get('/customer-orders-confirmed/{id}','AdminController@confirmCustOrders')->name('confirmCustOrders');
    Route::get('/customer-orders-shipped/{id}','AdminController@shippedCustOrders')->name('shippedCustOrders');
    Route::get('/customer-orders-cancelled/{id}','AdminController@cancelledCustOrders')->name('cancelledCustOrders');
    Route::get('/customer-orders-delivered/{id}','AdminController@deliveredCustOrders')->name('deliveredCustOrders');
    Route::get('/customer-orders-details/{id}','AdminController@custOrdersDetails')->name('custOrdersDetails');
    Route::post('/customer-orders-status','AdminController@CustomerorderStatus')->name('CustomerorderStatus');




});


