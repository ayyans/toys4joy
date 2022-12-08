<?php


Route::name('admin.')->namespace('App\Http\Controllers\Admin\Auth')->prefix('admin')->group(function(){
    Route::get('/login','LoginController@login')->name('login');
    Route::post('/login-process','LoginController@login_process')->name('login_process');
    Route::post('/logout','LoginController@logout')->name('logout');

});

Route::name('admin.')->namespace('App\Http\Controllers\Admin')->prefix('admin')->group(function() {
    Route::get('/getProducts','AdminController@getProducts')->name('getProducts');
    Route::post('/addgiftcardsubmit','AdminController@addgiftcardsubmit')->name('addgiftcardsubmit');
    Route::post('/ajax/add-order-remarks', 'AdminController@addOrderRemarks')->name('addOrderRemarks');
    Route::post('/ajax/get-new-orders-count', 'AdminController@getNewOrdersCount')->name('get-new-orders-count');
});

Route::name('admin.')->namespace('App\Http\Controllers\Admin')->prefix('admin')->middleware('admin')->group(function(){
    Route::get('/home','AdminController@dashboard')->name('dashboard');
    Route::get('/bulkupload','AdminController@bulkupload')->name('bulkupload');
    Route::post('/bulkupdateprocess','AdminController@bulkupdateprocess')->name('bulkupdateprocess');
    
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

    Route::get('/getsubcategories/{id}','AdminController@getsubcategories')->name('getsubcategories');

    // activate sub category

    Route::get('/activate-subcategories/{id}','AdminController@activateSubCategories')->name('activateSubCategories');
    Route::get('/deactivate-subcategories/{id}','AdminController@deactivateSubCategories')->name('deactivateSubCategories');
    Route::get('/delete-subcategories/{id}','AdminController@deleteSubCat')->name('deleteSubCat');

    // brands

    Route::get('/brands','AdminController@brands')->name('brands');
    Route::post('/add-brands','AdminController@BrandProcess')->name('BrandProcess');
    Route::post('/updatebrand','AdminController@updatebrand')->name('updatebrand');

    // activate brands

    Route::get('/activate-brands/{id}','AdminController@activateBrand')->name('activateBrand');
    Route::get('/deactivate-brands/{id}','AdminController@deactivateBrand')->name('deactivateBrand');
    Route::get('/delete-brands/{id}','AdminController@deleteBrands')->name('deleteBrands');

    // attribute
    // Route::get('/attribute','AdminController@atribute')->name('atribute');
    // Route::post('/add-attribute','AdminController@addattr')->name('addattr');

    // activate attribute

    // Route::get('/activate-attribute/{id}','AdminController@activateAttr')->name('activateAttr');
    // Route::get('/deactivate-attribute/{id}','AdminController@deactivatAttr')->name('deactivatAttr');
    // Route::get('/delete-attribute/{id}','AdminController@deleteAttr')->name('deleteAttr');

    // attribute value 
    // Route::post('/add-attribute-value','AdminController@addattrVal')->name('addattrVal');

    // activate attribute values

    // Route::get('/activate-attribute-value/{id}','AdminController@activateAttrVal')->name('activateAttrVal');
    // Route::get('/deactivate-attribute-value/{id}','AdminController@deactivatAttrVal')->name('deactivatAttrVal');
    // Route::get('/delete-attribute-value/{id}','AdminController@deleteAttrVal')->name('deleteAttrVal');

    // products
    Route::get('/products','AdminController@products')->name('products');
    Route::get('/add-products','AdminController@addproducts')->name('addproducts');
    Route::get('/bulk-upload-products','AdminController@bulkUploadProducts')->name('bulk-upload-products');
    Route::post('/bulk-upload-products','AdminController@storeBulkUploadProducts')->name('store-bulk-upload-products');
    Route::post('/change-product-featured-type/{product}/{type}', 'AdminController@changeProductFeaturedType')->name('changeProductFeaturedType');
    Route::post('/change-product-status/{product}', 'AdminController@changeProductStatus')->name('changeProductStatus');

    Route::get('local/point-of-sale','AdminController@localPointOfSale')->name('local.pos.point-of-sale');

    Route::get('/point-of-sale','AdminController@pointOfSale')->name('pos.point-of-sale');
    Route::get('/point-of-sale/sales-report','AdminController@POSSalesReport')->name('pos.sales-report');
    Route::get('/point-of-sale/refund-report','AdminController@POSRefundReport')->name('pos.refund-report');
    Route::get('/point-of-sale/items-sold-report','AdminController@POSItemsSoldReport')->name('pos.items-sold-report');

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
    // Route::get('/guest-orders-confirmed/{id}','AdminController@confirmGuestOrders')->name('confirmGuestOrders');
    // Route::get('/guest-orders-shipped/{id}','AdminController@shippedGuestOrders')->name('shippedGuestOrders');
    // Route::get('/guest-orders-cancelled/{id}','AdminController@cancelledGuestOrders')->name('cancelledGuestOrders');
    // Route::get('/guest-orders-delivered/{id}','AdminController@deliveredGuestOrders')->name('deliveredGuestOrders');
    Route::get('/guest-orders-details/{id}','AdminController@guestOrdersDetails')->name('guestOrdersDetails');
    // Route::post('/guest-orders-status','AdminController@orderStatus')->name('orderStatus');

//    coupons management route

    Route::get('/coupons','AdminController@coupon')->name('coupon');
    Route::post('/add-coupons-process','AdminController@addcouponProcess')->name('addcouponProcess');
    Route::get('/coupons-activate/{id}','AdminController@activateCoupon')->name('activateCoupon');
    Route::get('/coupons-deactivate/{id}','AdminController@deactivateCoupon')->name('deactivateCoupon');
    Route::get('/coupons-delete/{id}','AdminController@deleteCoupon')->name('deleteCoupon');

    // customer orders

    Route::get('/orders','AdminController@custOrders')->name('custOrders');
    Route::get('/wishlistorders','AdminController@wishlistorders')->name('wishlistorders');
    // Route::get('/customer-orders-confirmed/{id}','AdminController@confirmCustOrders')->name('confirmCustOrders');
    // Route::get('/customer-orders-shipped/{id}','AdminController@shippedCustOrders')->name('shippedCustOrders');
    // Route::get('/customer-orders-cancelled/{id}','AdminController@cancelledCustOrders')->name('cancelledCustOrders');
    // Route::get('/customer-orders-delivered/{id}','AdminController@deliveredCustOrders')->name('deliveredCustOrders');
    Route::get('/customer-orders-details/{id}','AdminController@custOrdersDetails')->name('custOrdersDetails');
    // Route::post('/customer-orders-status','AdminController@CustomerorderStatus')->name('CustomerorderStatus');

    // Change order status

    Route::get('/abandoned-orders','AdminController@abandonedOrders')->name('abandonedOrders');
    Route::any('/changeOrderStatus', 'AdminController@changeOrderStatus')->name('changeOrderStatus');
    Route::get('/return/{order}', 'AdminController@returnItems')->name('returnItems');
    Route::get('/return/{order}/item/{item}', 'AdminController@returnItemProceed')->name('returnItemProceed');

    // customer orders

    Route::get('/return-requests', 'AdminController@returnRequests')->name('return-requests.index');
    Route::get('/return-requests/{returnRequest}/{status}', 'AdminController@returnRequestStatus')->name('return-requests.status');


    Route::get('/productrequest', 'AdminController@productrequest')->name('productrequest');


    Route::get('/giftcards','AdminController@giftcards')->name('giftcards');
    Route::get('/giftcards-activate/{giftcard}','AdminController@activategiftcards')->name('activategiftcard');
    Route::get('/giftcards-deactivate/{giftcard}','AdminController@deactivategiftcards')->name('deactivategiftcard');
    Route::get('/giftcards-delete/{giftcard}','AdminController@deletegiftcards')->name('deletegiftcard');

    
    Route::get('/homepagebanners','AdminController@homepagebanners')->name('homepagebanners');
    Route::post('/homepagebannerssubmit','AdminController@homepagebannerssubmit')->name('homepagebannerssubmit');
    Route::get('/banner-activate/{id}','AdminController@activatebanner')->name('activatebanner');
    Route::get('/banner-deactivate/{id}','AdminController@deactivatebanner')->name('deactivatebanner');
    Route::get('/banner-delete/{id}','AdminController@deletebanner')->name('deletebanner');
    Route::post('/homepagebannersedit','AdminController@homepagebannersedit')->name('homepagebannersedit');



    Route::get('/smssettings','SettingsController@smssettings')->name('smssettings');
    Route::get('/delete-sms/{id}','SettingsController@deletesms')->name('deletesms');
    Route::post('/smsnumberprocess','SettingsController@smsnumberprocess')->name('smsnumberprocess');

    
    // Reports
    Route::get('sales-report', 'AdminController@salesReport')->name('report.sales');
    Route::get('inventory-report', 'AdminController@inventoryReport')->name('report.inventory');
    Route::get('customers-report', 'AdminController@customersReport')->name('report.customers');
    Route::get('guests-report', 'AdminController@guestsReport')->name('report.guests');
    Route::get('generated-giftcards-report', 'AdminController@generatedGiftCardsReport')->name('report.generatedGiftCards');
    Route::get('used-giftcards-report', 'AdminController@usedGiftCardsReport')->name('report.usedGiftCards');
    Route::get('returned-orders-report', 'AdminController@returnedOrdersReport')->name('report.returnedOrders');
    Route::get('returned-order-items-report', 'AdminController@returnOrderItemsReport')->name('report.returnedOrderItems');
    Route::get('abandoned-orders-report', 'AdminController@abandonedOrdersReport')->name('report.abandonedOrdersReport');

    // Points
    Route::get('points', 'AdminController@points')->name('points');

    // Settings
    Route::get('settings', 'SettingsController@index')->name('settings.index');
    Route::post('settings', 'SettingsController@store')->name('settings.store');
});


