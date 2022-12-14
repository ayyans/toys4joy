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
use PDF;
class OrderController extends Controller
{
    public function orderplacepayasmember(Request $request)
    {
        $ipaddres = Cmf::ipaddress();
        $cart = DB::table('carts')->where('cust_id' , $ipaddres)->get();
        $cust_id = Auth::user()->id;
        $cust_Add = CustomerAddress::where('cust_id','=',$cust_id)->first();
        $cust_add_id = $cust_Add['id'];
        foreach ($cart as $r) {
            $place_order = new Order;
            $place_order->orderid=$request->order_id;
            $place_order->orderstatus='payementpending';
            $place_order->cust_id=$cust_id;
            $place_order->cust_add_id=$cust_add_id;
            $place_order->prod_id=$r->prod_id;
            $place_order->qty = $r->qty;
            $place_order->amount = $r->amount;
            $place_order->mode = '2';
            $place_order->giftcode = $r->giftcode;
            $place_order->ordertype = 'simpleorder';
            $place_order->newstatus = 1;
            $place_order->save();
        }
        return response()->json(["status"=>"200","msg"=>'test']);
    }
    public function payasguestordergenerate(Request $request)
    {
        $ipaddres = Cmf::ipaddress();
        $cart = DB::table('carts')->where('cust_id' , $ipaddres)->get();
        foreach ($cart as $r) {
            $custDetails = new GuestOrder;
            $custDetails->order_id = $request->order_id;
            $custDetails->orderstatus = 'payementpending';
            $custDetails->prod_id=$r->prod_id;
            $custDetails->qty=$r->qty;
            $custDetails->cust_name=$request->custname;
            $custDetails->cust_email=$request->email;
            $custDetails->cust_mobile=$request->mobilenumber;;
            $custDetails->mode=$request->mode; 
            $custDetails->newstatus=1; 
            $custDetails->save();
        }
        DB::table('carts')->where('cust_id' , $ipaddres)->delete();
        return response()->json(["status"=>"200","msg"=>'test']);    
    }
    public function orderconfermasguest(Request $request)
    {
        $allparms =  $request->all();
        if($allparms['STATUS'] == 'TXN_SUCCESS')
        {
            $data = GuestOrder::with('product')->where('order_id' , $allparms['ORDERID'])->get();
            
            // mail data
            $email = $data->first()->cust_email;
            $order_number = $data->first()->order_id;
            $total = 0;
            $quantity = [];
            $amount = [];
            $products = [];

            foreach ($data as $r) {
                $change = GuestOrder::find($r->id);
                $change->payment_id = $allparms['transaction_number'];
                $change->mode = 1;
                $change->orderstatus = 'sadadpayement';
                $change->save();
                
                // mail data
                $total += $r->product->unit_price * $r->qty;
                array_push($quantity, $r->qty);
                array_push($amount, $r->product->unit_price * $r->qty);
                array_push($products, $r->product->title);
            }

            // mail data
            $order_details = [
                'email' => $email,
                'order_number' => $order_number,
                'total' => $total,
                'quantity' => $quantity,
                'amount' => $amount,
                'address' => 'N/A',
                'products' => $products,
            ];
            event(new OrderPlaced($order_details));
            Cmf::sendordersms($order_number);
            $orderid = $order_number;
            return view('website.guestthanks',compact('orderid'));
        }else{
            return redirect()->route('website.home')->with('error','Order IS Placed But Payement is Failed');
        }
    }
    public function saveCustDetails(Request $request){




        $ipaddres = Cmf::ipaddress();
        $cart = DB::table('carts')->where('cust_id' , $ipaddres)->get();
        foreach ($cart as $r) {
            $custDetails = new GuestOrder;
            $custDetails->order_id = $request->order_id;
            $custDetails->orderstatus = 'cod';
            $custDetails->prod_id=$r->prod_id;
            $custDetails->qty=$r->qty;
            $custDetails->cust_name=$request->custname;
            $custDetails->cust_email=$request->email;
            $custDetails->cust_mobile=$request->mobilenumber;;
            $custDetails->mode=$request->mode; 
            $custDetails->newstatus=1; 
            $custDetails->save();



            $getproduct = Product::where('id','=',$r->prod_id)->first();
            $qty_dec = $getproduct['qty']-$request->prod_qty;
            $update_qty = Product::where('id','=',$r->prod_id)->update([
                'qty'=>$qty_dec
            ]);
        }
        DB::table('carts')->where('cust_id' , $ipaddres)->delete();
        // if($getproduct->discount)
        // {
        //     $price = $getproduct->discount;
        // }else{
        //     $price = $getproduct->unit_price;
        // }

        $data = GuestOrder::with('product')->where('order_id' , $request->order_id)->get();

        // mail data
        $email = $data->first()->cust_email;
        $order_number = $data->first()->order_id;
        $total = 0;
        $quantity = [];
        $amount = [];
        $products = [];

        foreach ($data as $r) {
            $total += $r->product->unit_price * $r->qty;
            array_push($quantity, $r->qty);
            array_push($amount, $r->product->unit_price * $r->qty);
            array_push($products, $r->product->title);
        }

        $order_details = [
            'email' => $email,
            'order_number' => $order_number,
            'total' => $total,
            'quantity' => $quantity,
            'amount' => $amount,
            'address' => 'N/A',
            'products' => $products,
        ];
        event(new OrderPlaced($order_details));
        Cmf::sendordersms($order_number);

        return response()->json(["status"=>"200","msg"=>'conferm',"orderid"=>$request->order_id]);
    }
    public function generateinvoicegiftcard($id)
    {
        $data = [
            'cardid' => $id,
        ];
        $pdf = PDF::loadView('invoice.giftcard', $data);
        return $pdf->download('Gift Card Invoice - '.$id.'.pdf');
    }
    public function generatepdf($id)
    {
        $checkorder = order::where('orderid' , $id)->get()->count();
        if($checkorder > 0)
        {
            $data = [
                'ordernumber' => $id,
            ];
            $pdf = PDF::loadView('invoice.indexonline', $data);
            return $pdf->download('Order Invoice - '.$id.'.pdf');
        }
        else
        {
            $data = [
                'ordernumber' => $id,
            ];
            $pdf = PDF::loadView('invoice.invoicecod', $data);
            return $pdf->download('Order Invoice - '.$id.'.pdf');
        }        
    }
     // pay as guest checkout 

    public function payasguest(Request $request){
        $cust_id = Cmf::ipaddress();
        $products = Cart::leftJoin('products','products.id','=','carts.prod_id')
                    ->leftJoin('brands','brands.id','=','products.brand_id')                    
                    ->select('products.*','brand_name','logo','carts.id as crtid','carts.qty as cartQty')
                    ->where('carts.cust_id','=',$cust_id)
                    ->get();
        if($products->count()>0)
        {
            return view('website.payasguest',compact('products'));
        }else{
            return redirect()->route('website.home')->with('error','Cart Is Empty!');
        }        
    }
}