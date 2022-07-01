<?php

namespace App\Http\Controllers\Website;

use App\Events\OrderPlaced;
use App\Helpers\Cmf;
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

class OrderController extends Controller
{
    public function payasguestordergenerate(Request $request)
    {
        $custDetails = new GuestOrder;
        $custDetails->order_id = $request->order_id;
        $custDetails->prod_id=$request->prod_id;
        $custDetails->qty=$request->prod_qty;
        $custDetails->cust_name=$request->custname;
        $custDetails->cust_email=$request->email;
        $custDetails->cust_mobile=$request->mobilenumber;;
        $custDetails->mode=$request->mode; 
        $custDetails->save();
        $lastID = $custDetails->id;
        if($custDetails==true){
            $getproduct = Product::where('id','=',$request->prod_id)->first();
            $qty_dec = $getproduct['qty']-$request->prod_qty;
            $update_qty = Product::where('id','=',$request->prod_id)->update([
                'qty'=>$qty_dec
            ]);
            return response()->json(["status"=>"200","msg"=>$lastID]);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }       
    }
    public function orderconfermasguest(Request $request)
    {
        $allparms =  $request->all();
        if($allparms['STATUS'] == 'TXN_SUCCESS')
        {
            $data = GuestOrder::where('order_id' , $allparms['ORDERID'])->get()->first();
            $change = GuestOrder::find($data->id);
            $change->mode = 1;
            $change->save();

            $product = Product::find($data->prod_id);

            $order_details = [
                'email' => $data->cust_email,
                'order_number' => $data->order_id,
                'total' => $product->unit_price * $data->qty,
                'quantity' => [$data->qty],
                'amount' => [$product->unit_price * $data->qty],
                'address' => 'N/A',
                'products' => [$product->title],
            ];
            event(new OrderPlaced($order_details));
            return view('website.guestthanks');
        }else{
            return redirect()->route('website.home')->with('error','Order IS Placed But Payement is Failed');
        }
    }
}