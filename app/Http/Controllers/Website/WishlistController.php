<?php

namespace App\Http\Controllers\Website;

use App\Helpers\Cmf;
use App\Events\OrderPlaced;
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
use App\Models\greetingmessages;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Stripe;
use Session;
use Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
	public function placeorderwishlist($id, $orderid)
	{
		$wishlist = Wishlist::with(['customer', 'product'])->where(['cust_id' => $id, 'share_status' => 0])->get();
		$address = CustomerAddress::where('cust_id', $id)->first();

		if (!$address) {
			return response()->json([
				'status' => 400,
				'msg' => 2
			]);
		}

		$total_price = 0;
		foreach ($wishlist as $wish) {
			$total_price += $wish->product->discount ?: $wish->product->unit_price;
		}

		DB::beginTransaction();

		$order = Order::create([
				'user_id' => $id,
				'order_number' => $orderid,
				'address_id' => $address->id,
				'is_wishlist' => true,
				'order_type' => 'cc',
				'subtotal' => $total_price,
				'discount' => 0,
				'total_amount' => $total_price,
				'payment_status' => 'unpaid',
				'order_status' => 'placed',
				'transaction_number' => null,
				'additional_details->is_new' => true
		]);

		foreach ($wishlist as $wish) 
		{
			OrderItem::create([
					'order_id' => $order->id,
					'product_id' => $wish->product->id,
					'price' => $wish->product->unit_price,
					'quantity' => 1,
					'discount' => $wish->product->unit_price - $wish->product->discount,
					'total_amount' => $wish->product->unit_price
			]);
		}

		DB::commit();

		event(new OrderPlaced($order));
		Cmf::sendordersms($order->order_number);

		return response()->json([
			'status' => 200,
			'msg' => 1
		]);
		// $data = Wishlist::leftJoin('products','products.id','=','wishlists.prod_id')
		//                 ->leftJoin('users','users.id','=','wishlists.cust_id')
		//                 ->select('products.*','users.name','users.email','users.mobile','wishlists.id as wish_id','wishlists.share_status','wishlists.prod_id','wishlists.share_status')
		//                 ->where('wishlists.cust_id','=',$id)
		//                 ->orderBy('wishlists.id','desc')
		//                 ->get();

		//     $total_price = 0;
		//     $cust_Add = CustomerAddress::where('cust_id','=',$id)->first();
		//     if($cust_Add)
		//     {
		//     	$place_order = "";
		//     	$cust_add_id = $cust_Add['id'];
		// 	foreach ($data as $r) 
		// 	{
		// 		if($r->share_status == 0)
		// 		{
		// 			$total_price+=$r->unit_price;
		// 			$place_order = new Order;
		// 			$place_order->orderid=$orderid;
		// 			$place_order->orderstatus='payementpending';
		//             $place_order->cust_id=$id;
		//             $place_order->cust_add_id=$cust_add_id;
		//             $place_order->prod_id=$r->prod_id;
		//             $place_order->qty = 1;
		//             $place_order->amount = $total_price;
		//             $place_order->mode = '1';
		//             $place_order->ordertype = 'wishlist';
		//             $place_order->newstatus = '1';
		//             $place_order->save();
		// 		}
		// 	}
		// 	if($place_order){
		//             return response()->json(["status"=>"200","msg"=>"1"]);
		//         	exit();
		//         }else{
		//             return response()->json(["status"=>"300","msg"=>"2"]);
		//         	exit();
		//         }

		//     }else{
		//     	return response()->json(["status"=>"400","msg"=>"2"]);
		//         exit();
		//     }

	}
	public function wishlistorderconferm(Request $request)
	{
		$data =  $request->all();

		$status = $data['STATUS'];

		// check for successful transaction
		if ($status != 'TXN_SUCCESS') {
				return redirect()->route('website.home')->with('error','Order Not Placed');
		}

		$order_number = $data['ORDERID'];
		$transaction_number = $data['transaction_number'];

		$order = Order::where('order_number', $order_number)->first();
		$order->update([
				'payment_status' => 'paid',
				'transaction_number' => $transaction_number
		]);

		return view('website.guestthanks', compact('order_number'));

		// $allparms =  $request->all();
		// if ($allparms['STATUS'] == 'TXN_SUCCESS') {
		// 	$orderid = $allparms['ORDERID'];
		// 	Order::where('orderid', $orderid)->update(['orderstatus' => 'payementdone']);
		// 	Order::where('orderid', $orderid)->update(['mode' => '2']);
		// 	Order::where('orderid', $orderid)->update(['payment_id' => $allparms['transaction_number']]);
		// 	$orders = Order::with('product', 'address')->where('orderid', $orderid)->get();
		// 	$cust_Add = $orders->first()->address;
		// 	// mail data
		// 	$email = $orders->first()->customer->email;
		// 	$order_number = $orders->first()->order_id;
		// 	$total = 0;
		// 	$quantity = [];
		// 	$amount = [];
		// 	$address = "Unit No: $cust_Add->unit_no, Building No: $cust_Add->building_no, Zone: $cust_Add->zone, Street: $cust_Add->street";
		// 	$products = [];

		// 	foreach ($orders as $order) {
		// 		$total += $order->amount;
		// 		array_push($quantity, $order->qty);
		// 		array_push($amount, $order->amount);
		// 		array_push($products, $order->product->title);
		// 	}

		// 	// mail data
		// 	$order_details = [
		// 		'email' => $email,
		// 		'order_number' => $order_number,
		// 		'total' => $total,
		// 		'quantity' => $quantity,
		// 		'amount' => $amount,
		// 		'address' => 'N/A',
		// 		'products' => $products,
		// 	];
		// 	event(new OrderPlaced($order_details));
		// 	Cmf::sendordersms($orderid);

		// 	return view('website.guestthanks', compact('orderid'));
		// } else {
		// 	$orderid = $allparms['ORDERID'];
		// 	Order::where('orderid', $orderid)->delete();
		// 	return redirect()->route('website.home')->with('error', 'Order Not Placed!');
		// }
	}
	public function savegreetings(Request $request)
	{
		// $greet = new greetingmessages();
		// $greet->message = $request->message;
		// $greet->phonenumber = $request->phonenumber;
		// $greet->name = $request->name;
		// $greet->orderid = $request->orderid;
		// $greet->save();

		$order = Order::where('order_number', $request->orderid)->first();
		$order->update([
			'additional_details->name' => $request->name,
			'additional_details->mobile' => $request->phonenumber,
			'additional_details->message' => $request->message
		]);
	}
}
