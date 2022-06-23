<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\AttrValue;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProdAttr;
use App\Models\GuestOrder;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\CustomerAddress;
use App\Models\CardInfo;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Stripe;
use Session;
use Auth;
use DB;

class WishlistController extends Controller
{
	public function placeorderwishlist($id , $orderid)
	{
		$data = Wishlist::leftJoin('products','products.id','=','wishlists.prod_id')
                    ->leftJoin('users','users.id','=','wishlists.cust_id')
                    ->select('products.*','users.name','users.email','users.mobile','wishlists.id as wish_id','wishlists.share_status','wishlists.prod_id','wishlists.share_status')
                    ->where('wishlists.cust_id','=',$id)
                    ->orderBy('wishlists.id','desc')
                    ->get();

        $total_price = 0;
        $cust_Add = CustomerAddress::where('cust_id','=',$id)->first();
        if($cust_Add)
        {
        	$cust_add_id = $cust_Add['id'];
			foreach ($data as $r) 
			{
				$total_price+=$r->unit_price;
				$place_order = new Order;
				$place_order->orderid=$orderid;
				$place_order->orderstatus='payementpending';
	            $place_order->cust_id=$id;
	            $place_order->cust_add_id=$cust_add_id;
	            $place_order->prod_id=$r->prod_id;
	            $place_order->qty = 1;
	            $place_order->amount = $total_price;
	            $place_order->mode = '1';
	            $place_order->save();
			}
			return response()->json(["status"=>"200","msg"=>"1"]);
            exit();
        }else{
        	return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }
        
	}
	public function wishlistorderconferm()
	{
		$allparms =  $request->all();
		if($allparms['STATUS'] == 'TXN_SUCCESS')
        {
            $orderid = $allparms['ORDERID'];
            Order::where('orderid' , $orderid)->update(['orderstatus'=>'payementdone']);
            return view('website.guestthanks');
        }
	}
}