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
use App\Models\giftcards;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Stripe;
use Session;
use Auth;
use Illuminate\Support\Facades\DB;
use PDF;
class OrderController extends Controller
{
    public function orderplacepayasmember(Request $request)
    {
        // $ipaddres = Cmf::ipaddress();
        // $cart = DB::table('carts')->where('cust_id' , $ipaddres)->get();
        // $items = cart()->getContent();
        // $giftCardIds = [];
        // $giftCardCodes = [];
        // cart()->getConditionsByType('giftcard')->each(function($g) use ($giftCardIds, $giftCardCodes) {
        //     array_push($giftCardIds, $g->getAttributes()['id']);
        //     array_push($giftCardCodes, $g->getAttributes()['code']);
        // });
        // $giftCardCodes = implode(', ', $giftCardCodes);
        // $cust_id = Auth::user()->id;
        // $cust_Add = CustomerAddress::where('cust_id','=',$cust_id)->first();
        // $cust_add_id = $cust_Add['id'];
        // foreach ($items as $item) {
        //     $place_order = new Order;
        //     $place_order->orderid=$request->order_id;
        //     $place_order->orderstatus='payementpending';
        //     $place_order->cust_id=$cust_id;
        //     $place_order->cust_add_id=$cust_add_id;
        //     $place_order->prod_id=$item->id;
        //     $place_order->qty = $item->quantity;
        //     $place_order->amount = $item->price;
        //     $place_order->mode = '2';
        //     $place_order->giftcode = $giftCardCodes;
        //     $place_order->ordertype = 'simpleorder';
        //     $place_order->newstatus = 1;
        //     $place_order->save();
        // }
        // giftcards::whereIn('id', $giftCardIds)->update([ 'user_id' => auth()->id() ]);
        // return response()->json(["status"=>"200","msg"=>'test']);

        $items = cart()->getContent();
        $user = auth()->user()->load('address');

        DB::beginTransaction();

        // creating order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => $request->order_id,
            'address_id' => $user->address->id,
            'order_type' => 'cc',
            'subtotal' => cart()->getSubTotal(),
            'discount' => cart()->getSubTotal() - cart()->getTotal(),
            'total_amount' => cart()->getTotal(),
            'payment_status' => 'unpaid',
            'order_status' => 'placed',
            'transaction_number' => null,
        ]);
        // creating order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->associatedModel->unit_price,
                'quantity' => $item->quantity,
                'discount' => $item->associatedModel->unit_price - $item->price,
                'total_amount' => $item->getPriceSum()
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => true
        ]);
    }
    public function payasguestordergenerate(Request $request)
    {
        $items = cart()->getContent();

        DB::beginTransaction();

        // creating order
        $order = Order::create([
            'user_id' => null,
            'order_number' => $request->order_id,
            'address_id' => null,
            'order_type' => 'cc',
            'subtotal' => cart()->getSubTotal(),
            'discount' => 0,
            'total_amount' => cart()->getTotal(),
            'payment_status' => 'unpaid',
            'order_status' => 'placed',
            'transaction_number' => null,
        ]);
        // creating order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->associatedModel->unit_price,
                'quantity' => $item->quantity,
                'discount' => $item->associatedModel->unit_price - $item->price,
                'total_amount' => $item->getPriceSum()
            ]);
        }
        // saving guest details
        $order->update([
            'additional_details' => [
                'name' => $request->custname,
                'email' => $request->email,
                'mobile' =>  $request->mobilenumber
            ]
        ]);

        DB::commit();

        return response()->json([
            'status' => true
        ]);

        // $ipaddres = Cmf::ipaddress();
        // $cart = DB::table('carts')->where('cust_id' , $ipaddres)->get();
        // $items = cart()->getContent();
        // foreach ($items as $item) {
        //     $custDetails = new GuestOrder;
        //     $custDetails->order_id = $request->order_id;
        //     $custDetails->orderstatus = 'payementpending';
        //     $custDetails->prod_id=$item->id;
        //     $custDetails->qty=$item->quantity;
        //     $custDetails->cust_name=$request->custname;
        //     $custDetails->cust_email=$request->email;
        //     $custDetails->cust_mobile=$request->mobilenumber;
        //     $custDetails->mode=$request->mode;
        //     $custDetails->newstatus=1;
        //     $custDetails->save();
        // }
        // // DB::table('carts')->where('cust_id' , $ipaddres)->delete();
        // cart()->clear();
        // return response()->json(["status"=>"200","msg"=>'test']);    
    }
    public function orderconfermasguest(Request $request)
    {
        $data =  $request->all();

        $status = $data['STATUS'];

        // check for successful transaction
        if ($status != 'TXN_SUCCESS') {
            return redirect()->route('website.home')->with('error','Order placed but payement failed');
        }

        $order_number = $data['ORDERID'];
        $transaction_number = $data['transaction_number'];

        $order = Order::where('order_number', $order_number)->first();
        $order->update([
            'payment_status' => 'paid',
            'transaction_number' => $transaction_number
        ]);

        // clearing cart
        cart()->clear();
        cart()->clearCartConditions();

        return view('website.guestthanks', compact('order_number'));
        // $allparms =  $request->all();
        // if($allparms['STATUS'] == 'TXN_SUCCESS')
        // {
        //     $data = GuestOrder::with('product')->where('order_id' , $allparms['ORDERID'])->get();
            
        //     // mail data
        //     $email = $data->first()->cust_email;
        //     $order_number = $data->first()->order_id;
        //     $total = 0;
        //     $quantity = [];
        //     $amount = [];
        //     $products = [];

        //     foreach ($data as $r) {
        //         $change = GuestOrder::find($r->id);
        //         $change->payment_id = $allparms['transaction_number'];
        //         $change->mode = 1;
        //         $change->orderstatus = 'sadadpayement';
        //         $change->save();
                
        //         // mail data
        //         $total += $r->product->unit_price * $r->qty;
        //         array_push($quantity, $r->qty);
        //         array_push($amount, $r->product->unit_price * $r->qty);
        //         array_push($products, $r->product->title);
        //     }

        //     // mail data
        //     $order_details = [
        //         'email' => $email,
        //         'order_number' => $order_number,
        //         'total' => $total,
        //         'quantity' => $quantity,
        //         'amount' => $amount,
        //         'address' => 'N/A',
        //         'products' => $products,
        //     ];
        //     event(new OrderPlaced($order_details));
        //     Cmf::sendordersms($order_number);
        //     $orderid = $order_number;
        //     return view('website.guestthanks',compact('orderid'));
        // }else{
        //     return redirect()->route('website.home')->with('error','Order IS Placed But Payement is Failed');
        // }
    }
    public function saveCustDetails(Request $request){
        // $ipaddres = Cmf::ipaddress();
        // $cart = DB::table('carts')->where('cust_id' , $ipaddres)->get();
        $items = cart()->getContent();
        $order_number = $request->order_id;

        DB::beginTransaction();

        $order = Order::create([
            'user_id' => null,
            'order_number' => $order_number,
            'address_id' => null,
            'order_type' => 'cod',
            'subtotal' => cart()->getSubTotal(),
            'discount' => 0,
            'total_amount' => cart()->getTotal(),
            'payment_status' => 'unpaid',
            'order_status' => 'placed',
            'transaction_number' => null,
        ]);
        // creating order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->associatedModel->unit_price,
                'quantity' => $item->quantity,
                'discount' => $item->associatedModel->unit_price - $item->price,
                'total_amount' => $item->getPriceSum()
            ]);
        }
        // saving guest details
        $order->update([
            'additional_details' => [
                'name' => $request->custname,
                'email' => $request->email,
                'mobile' =>  $request->mobilenumber
            ]
        ]);

        DB::commit();

        // clearing cart
        cart()->clear();
        cart()->clearCartConditions();

        return response()->json([
            'status' => true,
            'order_number' =>$request->order_id
        ]);

        // foreach ($items as $item) {
        //     $custDetails = new GuestOrder;
        //     $custDetails->order_id = $request->order_id;
        //     $custDetails->orderstatus = 'cod';
        //     $custDetails->prod_id=$item->id;
        //     $custDetails->qty=$item->quantity;
        //     $custDetails->cust_name=$request->custname;
        //     $custDetails->cust_email=$request->email;
        //     $custDetails->cust_mobile=$request->mobilenumber;;
        //     $custDetails->mode=$request->mode; 
        //     $custDetails->newstatus=1; 
        //     $custDetails->save();



        //     $getproduct = Product::where('id','=',$item->id)->first();
        //     $qty_dec = $getproduct['qty']-$request->prod_qty;
        //     $update_qty = Product::where('id','=',$item->id)->update([
        //         'qty'=>$qty_dec
        //     ]);
        // }
        // DB::table('carts')->where('cust_id' , $ipaddres)->delete();
        // cart()->clear();
        // if($getproduct->discount)
        // {
        //     $price = $getproduct->discount;
        // }else{
        //     $price = $getproduct->unit_price;
        // }

        // $data = GuestOrder::with('product')->where('order_id' , $request->order_id)->get();

        // // mail data
        // $email = $data->first()->cust_email;
        // $order_number = $data->first()->order_id;
        // $total = 0;
        // $quantity = [];
        // $amount = [];
        // $products = [];

        // foreach ($data as $r) {
        //     $total += $r->product->unit_price * $r->qty;
        //     array_push($quantity, $r->qty);
        //     array_push($amount, $r->product->unit_price * $r->qty);
        //     array_push($products, $r->product->title);
        // }

        // $order_details = [
        //     'email' => $email,
        //     'order_number' => $order_number,
        //     'total' => $total,
        //     'quantity' => $quantity,
        //     'amount' => $amount,
        //     'address' => 'N/A',
        //     'products' => $products,
        // ];
        // event(new OrderPlaced($order_details));
        // Cmf::sendordersms($order_number);

        // return response()->json(["status"=>"200","msg"=>'conferm',"orderid"=>$request->order_id]);
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
        $checkorder = Order::where('id', $id)->count();
        if($checkorder > 0)
        {
            $data = [
                'order_number' => $id,
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
        // $cust_id = Cmf::ipaddress();
        // $products = Cart::leftJoin('products','products.id','=','carts.prod_id')
        //             ->leftJoin('brands','brands.id','=','products.brand_id')                    
        //             ->select('products.*','brand_name','logo','carts.id as crtid','carts.qty as cartQty')
        //             ->where('carts.cust_id','=',$cust_id)
        //             ->get();
        $items = cart()->getContent();
        if(! cart()->isEmpty())
        {
            return view('website.payasguest',compact('items'));
        }else{
            return redirect()->route('website.home')->with('error','Cart Is Empty!');
        }        
    }
}