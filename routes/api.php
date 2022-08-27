<?php
use App\Http\Resources\SearchProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/get_product', function () {
return DB::table('products')->select('products.*', 'sub_categories.id as subcat_id')
->leftJoin('sub_categories', 'products.sub_cat', '=', 'sub_categories.id')
->when(request('barcode'), function ($query, $withbarcode) {
    $query->where('barcode',request('barcode'));
})
->when(request('sku'), function ($query, $with_sku) {
    $query->Where('sku', '=', request('sku'));
})
->get();
});
Route::get('products/search/{search?}', function($search = null) {
    $products = Product::with('brand', 'category', 'subCategory')
        ->when($search, function($query, $search) {
            $query->where('title', 'LIKE', "%$search%")
            ->orWhere('barcode', 'LIKE', "%$search%")
            ->orWhere('sku', $search);
        })->get();
    return $products;
});
