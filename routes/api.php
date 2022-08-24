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
    //return new SearchProductResource(Product::findOrFail($barcode));
    //return Product::where('barcode',request('barcode'))->get();
return DB::table('products')->select('products.*', 'sub_categories.id as subcat_id')->leftJoin('sub_categories', 'products.sub_cat', '=', 'sub_categories.id')->where('barcode',request('barcode'))->get();
});
