<?php

namespace App\Http\Controllers\Website;

use App\Events\OrderPlaced;
use App\Helpers\Cmf;
use App\Http\Controllers\Controller;
use App\Http\Resources\SearchProductResource;
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
use App\Models\requiredproducts;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Stripe;
use Session;
use Auth;
use DB;

class WebsiteController extends Controller
{
    //

    public function __construct(){ 

        $categoriestest = $this->listCategory();
        View::share('categoriestest', $categoriestest);
    }
    public function index(){
        $categories = $this->listCategory();
        $products = Product::where('status','=','2')->orderBy('id','desc')->limit(4)->get();
        return view('website.home',compact('categories','products'));
    }
    public function submitformlookingfor(Request $request)
    {
        $product  = new requiredproducts();
        $product->name = $request->name;
        $product->email = $request->email;
        $product->phonenumber = $request->phonenumber; 
        $product->message = $request->message;
        $product->image = Cmf::sendimagetodirectory($request->image);
        $product->save();
        return back()->with('success','Request Submited Successfully');
    }
    public function whyus()
    {
        return view('website.pages.whyus');
    }
    public function policy()
    {
        return view('website.pages.policy');
    }

    public function rewardspolicy()
    {
        return view('website.pages.rewards-policy');
    }
    public function returnpolicy()
    {
        return view('website.pages.return-policy');
    }
    public function deliverypolicy()
    {
        return view('website.pages.delivery-policy');
    }
    public function privacypolicy()
    {
        return view('website.pages.privacy-policy');
    }
    public function termsandconditions()
    {
        return view('website.pages.termsandconditions');
    }


    public function contact()
    {
        return view('website.pages.contact');
    }
    public function newarrivals()
    {
        $categories = $this->listCategory();
        $products = Product::where('new_arrival','=',1)->where('status','=','2')->orderBy('id','desc')->paginate(12);
        return view('website.product-list',compact('categories','products'));
    }
    public function bestoffers()
    {
        $categories = $this->listCategory();
        $products = Product::where('best_offer','=',1)->where('status','=','2')->orderBy('id','desc')->paginate(12);
        return view('website.product-list',compact('categories','products'));
    }
    public function bestsellers()
    {
        $categories = $this->listCategory();
        $products = Product::where('best_seller','=',1)->where('status','=','2')->orderBy('id','desc')->paginate(12);
        return view('website.product-list',compact('categories','products'));
    }

    public function brands()
    {
        return view('website.pages.brands');
    }

    // listing category

    public function listCategory(){
        $categories = Category::where('status','=','2')->orderBy('id','desc')->get();
        return $categories;

    }

    // category wise product

    public function listproducts($url){
        $categories = $this->listCategory();
        $catid = Category::where('url' , $url)->get()->first();
        $products = Product::where('category_id','=',$catid->id)->where('status','=','2')->orderBy('id','desc')->paginate(12);
        return view('website.product-list',compact('categories','products','catid'));
    }

    public function listproductssubcategpry($main , $sub)
    {
        $categories = $this->listCategory();
        $catid = Category::where('url' , $main)->get()->first();
        $subcatid = SubCategory::where('url' , $sub)->get()->first();
        $products = Product::where('category_id','=',$catid->id)->where('sub_cat','=',$subcatid->id)->where('status','=','2')->orderBy('id','desc')->paginate(12);
        return view('website.product-list',compact('categories','products','catid'));
    }

    // product details

    public function productDetails($url){
        $categories = $this->listCategory();
        $products = Product::leftJoin('brands','brands.id','=','products.brand_id')                    
                    ->select('products.*','brand_name','logo')
                    ->where('products.url','=',$url)
                    ->first();
        $catid = $products->category_id;
        $gallery = ProductImage::where('prod_id','=',$products->id)->orderBy('id','desc')->get();          
        return view('website.product_details',compact('categories','catid','products','gallery'));
    }

// category list using ajax

    public function listcategorylist(){
        $category_list = $this->listCategory();
        if(count($category_list)>0){
            return response()->json(["status"=>"200","msg"=>$category_list]);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }
    }


    // my account

    public function myaccount(){
        return view('website.myaccount');
    }

    // pay as guest checkout 

    public function payasguest(Request $request){
        $prod_id = $request->prod_id;
        $fnlqty = $request->quantity;
        $products = Product::leftJoin('brands','brands.id','=','products.brand_id')                    
                    ->select('products.*','brand_name','logo')
                    ->where('products.id','=',$prod_id)
                    ->first();
        return view('website.payasguest',compact('products','prod_id','fnlqty'));
    }


    // online payment stripe


    public function StripePayment(Request $request){
        $orderid = $request->orderid;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
       $test =  Stripe\Charge::create ([
                "amount" => $request->amount*100,
                "currency" => "AED",
                "source" => $request->stripeToken,
                "description" => "This payment is tested purpose"
        ]);

        if($test==true){
            $update = GuestOrder::where('id','=',$orderid)->update([
                'payment_id'=>$test['id'],
                'status'=>'2'
            ]);
            Session::flash('success', 'Payment successful!');
            return redirect('/guest-thanks');
            exit(); 
        }else{
            Session::flash('error', 'Payment failed!!');
            return back();
            exit();
        }
       
          
       
    }


    // save customer address as guest

    public function saveCustDetails(Request $request){
        $order_number = mt_rand(100000000, 999999999);
        $custDetails = new GuestOrder;
        $custDetails->prod_id=$request->prod_id;
        $custDetails->order_id=$order_number;
        $custDetails->qty=$request->prod_qty;
        $custDetails->cust_name=$request->custname;
        $custDetails->cust_email=$request->email;
        $custDetails->cust_mobile=$request->mobilenumber;;
        $custDetails->city=$request->city;
        $custDetails->state=$request->state;
        $custDetails->apartment=$request->aprtment;
        $custDetails->faddress=$request->address;
        $custDetails->mode=$request->mode; 
        $custDetails->save();
        $lastID = $custDetails->id;
        if($custDetails==true){
            $getproduct = Product::where('id','=',$request->prod_id)->first();
            $qty_dec = $getproduct['qty']-$request->prod_qty;
            $update_qty = Product::where('id','=',$request->prod_id)->update([
                'qty'=>$qty_dec
            ]);

            $order_details = [
                'email' => $request->email,
                'order_number' => $order_number,
                'total' => $getproduct->unit_price * $request->prod_qty,
                'quantity' => [$request->prod_qty],
                'amount' => [$getproduct->unit_price * $request->prod_qty],
                'address' => 'N/A',
                'products' => [$getproduct->title],
            ];
            event(new OrderPlaced($order_details));

            return response()->json(["status"=>"200","msg"=>$lastID,"orderid"=>$order_number]);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }       

    }
    public function guestthankorder($id)
    {
        $orderid = $id;
        return view('website.guestthanks',compact('orderid'));
    }


    // guest thanks page

    public function guestthank(Request $request){
        $allparms =  $request->all();
        $ipaddres = Cmf::ipaddress();
        $cart = DB::table('carts')->where('cust_id' , $ipaddres)->get()->first();
        $customer = DB::table('users')->where('id' , $cart->customer_id)->get()->first();
        auth()->attempt(['email'=>$customer->email,'password'=>$customer->show_password]);
        if(Auth::check()){
            if($allparms['STATUS'] == 'TXN_SUCCESS')
            {
                $cust_id = Auth::user()->id;
                $cust_Add = CustomerAddress::where('cust_id','=',$cust_id)->first();
                $cust_card = CardInfo::where('cust_id','=',$cust_id)->first();
                $cust_add_id = $cust_Add['id'];
                $cartid = $allparms['ORDERID'];
                $cart = DB::table('carts')->where('cust_id' , $ipaddres)->get();
                foreach ($cart as $r) {
                    $place_order = new Order;
                    $place_order->orderid=$allparms['ORDERID'];
                    $place_order->orderstatus='sadadpayement';
                    $place_order->cust_id=$cust_id;
                    $place_order->cust_add_id=$cust_add_id;
                    $place_order->prod_id=$r->prod_id;
                    $place_order->qty = $r->qty;
                    $place_order->payment_id = $allparms['transaction_number'];
                    $place_order->amount = $allparms['TXNAMOUNT'];
                    $place_order->mode = '2';
                    $place_order->save();
                }
                if($place_order==true){
                    $products = $cart->pluck('prod_id')->map(fn($i) => Product::find($i))->pluck('title');
                    $quantity = $cart->pluck('qty');
                    $amount = $cart->pluck('amount');
                    $address = "Unit No: $cust_Add->unit_no, Building No: $cust_Add->building_no, Zone: $cust_Add->zone, Street: $cust_Add->street";
                    $order_details = [
                        'order_number' => $allparms['ORDERID'],
                        'total' => $allparms['TXNAMOUNT'],
                        'quantity' => $quantity,
                        'amount' => $amount,
                        'address' => $address,
                        'products' => $products,
                    ];
                    event(new OrderPlaced($order_details));
                    $update_cart = Cart::where('cust_id','=',$ipaddres)->delete();
                    $orderid = $allparms['ORDERID'];
                    return view('website.guestthanks',compact('orderid'));
                }else{
                   return redirect()->route('website.payasmember')->with('error','Order Not Placed!');
                }
            }else{
                return redirect()->route('website.payasmember')->with('error','Payement Failed!');
            }
        }else{
            return redirect()->route('website.login')->with('error','Please Login!');
        }

        
        
    }


    // add to cart

    
    
    public function addTocart(Request $request){
        $cust = Cmf::ipaddress();
        $prod_id = $request->prod_id;
        $qty = $request->quantity;
        $existcart = Cart::where('cust_id','=',$cust)->where('prod_id','=',$prod_id)->count();        
        if($existcart>0){
            $existqty = Cart::where('cust_id','=',$cust)->where('prod_id','=',$prod_id)->first();
            $updateqty = $existqty['qty']+$qty;
            $qtyupdate = Cart::where('cust_id','=',$cust)->where('prod_id','=',$prod_id)->update(['qty'=>$updateqty]);
            if($qtyupdate==true){
                return response()->json(["status"=>"200","msg"=>"1"]);
            }else{
                return response()->json(["status"=>"400","msg"=>"2"]); 
            }
        }else
        {
            $getproduct = Product::where('id','=',$prod_id)->first();
            if($qty<=$getproduct['qty']){
                $addTo = new Cart;
                $addTo->cust_id=$cust;
                $addTo->prod_id=$prod_id;
                $addTo->qty = $qty;
                $addTo->amount=$request->amt;
                $addTo->save();
                if($addTo==true){
                    return response()->json(["status"=>"200","msg"=>"1"]);
                }else{
                    return response()->json(["status"=>"400","msg"=>"2"]); 
                }
        }
        else{
            return response()->json(["status"=>"400","msg"=>"3"]);
        }
    }

    }
    // view cart 
    public function showcart()
    {
        $cust_id = Cmf::ipaddress();
        $data = Cart::leftJoin('products','products.id','=','carts.prod_id')
                
        ->select('carts.id as crtid','carts.qty as cartQty','products.*')
        ->where('carts.cust_id','=',$cust_id)       
        ->orderBy('carts.id','desc')
        ->get();

        if($data->count() > 0)
        {
            echo '<div class="cart-main-title"><h5 id="offcanvasRightLabel">My Bag</h5></div>       
            <div id="cartdetailsheader">';
            $total_price = 0;
            foreach ($data as $r) {
            $total_price += $r->cartQty*$r->unit_price;
            echo '<div class="d-flex added-products"> 
                <div class="pro-image">
                <img src="'.asset("products").'/'.$r->featured_img.'">
                </div><div class="product-detail"> 
                <h2 class="title">'.$r->title.'</h2> 
                <h4 class="price">QAR '.$r->unit_price.'</h4> 
                <div class="d-flex rmv-or-edit"> 
                <div class="qty">
                <input type="number" value="'.$r->cartQty.'" id="quantity" name="quantity" min="1" max="2" onchange="updateQty('.$r->crtid.',this.value)">
                </div>
                <div class="remove icon">
                <a href="javascript:void(0)" onclick="removecart('.$r->crtid.')">
                <img src="'.asset('website/img/delete.png').'">
                </a>
                </div>
                </div>
                </div>
                </div>';
            }

            echo '</div>
             <hr>
            <div class="d-flex total-n-shipping">
                <div class="d-flex subtotal">
                    <h4>Subtotal:</h4>
                    <h5 class="price" id="subtotal_price">QAR '.$total_price.'</h5>
                </div>
            </div>
            <div class="d-flex btn-area">
                <div class="checkout btn"><a href="'.route('website.payasmember').'">Checkout</a></div>
                <div class="view-cart btn"><a href="'.route('website.cartpage').'">View Cart</a></div>
            </div>';

        }else{
            echo '<div class="cart-main-title"><h5 id="offcanvasRightLabel">My Bag</h5></div>       
            <div id="cartdetailsheader">
                <p>No products in cart</p>
            </div>
            ';
        }

        

        
    }
    public function headerCart(Request $request){
        $cust_id = $request->cust_id;
        $data = Cart::leftJoin('products','products.id','=','carts.prod_id')
                
        ->select('carts.id as crtid','carts.qty as cartQty','products.*')
        ->where('carts.cust_id','=',$cust_id)       
        ->orderBy('carts.id','desc')
        ->get();
        if(count($data)!=0){
            return response()->json(["status"=>"200","msg"=>$data]);
        }else{
            return response()->json(["status"=>"400","msg"=>"1"]);
        } 
    }

    // cart page

    public function cartpage(){
        $cust_id = Cmf::ipaddress();
        $carts = Cart::leftJoin('products','products.id','=','carts.prod_id')                
        ->select('carts.id as crtid','carts.qty as cartQty','products.*')
        ->where('carts.cust_id','=',$cust_id)       
        ->orderBy('carts.id','desc')
        ->get();

        return view('website.cartpage',compact('carts'));
    }

    // remove product from cart

    public function removedcartProd(Request $request){
        $removed = Cart::where('id','=',$request->cartid)->delete();
        if($removed==true){
            return response()->json(["status"=>"200","msg"=>"1"]);
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]); 
        }

    }

    // update cart

    public function updateQTY(Request $request){
        $updateQty = Cart::where('id','=',$request->cartid)->update([
            'qty'=>$request->qty
        ]);
        if($updateQty == true){
            return response()->json(["status"=>"200","msg"=>"1"]);
        }else{
            return response()->json(["status"=>"200","msg"=>"1"]);
        }
    }


    // pay as member

    public function payasmember(Request $request){
        $cust_id = Cmf::ipaddress();
        $data = array('customer_id' => Auth::user()->id);
        DB::table('carts')->where('cust_id' , $cust_id)->update($data);
        $products = Cart::leftJoin('products','products.id','=','carts.prod_id')
                    ->leftJoin('brands','brands.id','=','products.brand_id')                    
                    ->select('products.*','brand_name','logo','carts.id as crtid','carts.qty as cartQty')
                    ->where('carts.cust_id','=',$cust_id)
                    ->get();

        if($products->count()>0)
        {
            $checkaddres = CustomerAddress::where('cust_id' , Auth::user()->id)->count();
            if($checkaddres > 0)
            {
                return view('website.payasmember',compact('products'));
            }else{
                
                return redirect()->route('website.addAddressInfo')->with('error','Add Address First');
            }
        }else{
            return redirect()->route('website.home')->with('error','Cart Is Empty!');
        }
        
    }


    // add card info

    public function addCardInfo(){
        return view('website.add_card_info');
    }

    public function addAddressInfo(){
        return view('website.add_address');
    }


    public function registrationThank(){
        return view('website.registration_thank');
    }

    // add address process

    public function addAddressProcess(Request $request){
        $cust_id = Auth::user()->id;
        $cust_address = new CustomerAddress;
        $cust_address->cust_id=$cust_id;
        $cust_address->unit_no=$request->unit_no;
        $cust_address->building_no=$request->buid_no;
        $cust_address->zone=$request->zone;
        $cust_address->street=$request->street;
        $cust_address->save();
        if($cust_address==true){
            return response()->json('1');
            exit();
        }else{
            return response()->json('2');
            exit();
        }
    }


    // add product in wishlist

    public function addWishlist(Request $request){
        $cust_id = Auth::user()->id;
        $prod_id = $request->prod_id;
        $getwishlist = Wishlist::where('cust_id','=',$cust_id)->where('prod_id','=',$prod_id)->count();
        if($getwishlist > 0){
            return response()->json(["status"=>"400","msg"=>"3"]);
            exit();
        }else{
            $addwishlist = new Wishlist;
            $addwishlist->cust_id=$cust_id;
            $addwishlist->prod_id=$prod_id;
            $addwishlist->share_status=0;
            $addwishlist->save();
            if($addwishlist==true){
                return response()->json(["status"=>"200","msg"=>"1"]);
                exit();
            }else{
                return response()->json(["status"=>"400","msg"=>"2"]);
                exit();
            }
        }

    }

    public function removefromwishlists($id)
    {
        $addwishlist = Wishlist::find($id);
        if($addwishlist->share_status == 0)
        {
            $addwishlist->share_status=1;
        }else{
            $addwishlist->share_status=0;
        }
        
        $addwishlist->save();
        return back()->with('success','product removed from wishlist');
    }


    // wishlist list

    public function mywishlist(Request $request){
        $cust_id = decrypt($request->cust_id);
        $wshlists = Wishlist::leftJoin('products','products.id','=','wishlists.prod_id')
                    ->select('products.*','wishlists.id as wish_id')
                    ->where('wishlists.cust_id','=',$cust_id)
                    ->orderBy('wishlists.id','desc')
                    ->get();
        // print_r($wshlists);exit;
        return view('website.mywishlist',compact('wshlists'));
    }

    // remove wishlist 

    public function removeWishlist(Request $request){
        $wish_id = decrypt($request->id);
        $remove_wishlist  = Wishlist::where('id','=',$wish_id)->delete();
        if($remove_wishlist==true){
            return back()->with('success','product removed from wishlist');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    // share wishlist to any one

    public function sharewishlist(Request $request){
        $cust_id = decrypt($request->cust_id);
        $wshlists = Wishlist::leftJoin('products','products.id','=','wishlists.prod_id')
                    ->leftJoin('users','users.id','=','wishlists.cust_id')
                    ->select('products.*','users.name','users.email','users.mobile','wishlists.id as wish_id','wishlists.share_status')
                    ->where('wishlists.cust_id','=',$cust_id)
                    ->orderBy('wishlists.id','desc')
                    ->get();
        return view('website.share_wishlist',compact('wshlists','cust_id'));
    }

    // coupons at checkout

    public function discount_coupon(Request $request){
        $getcoupon = Coupon::where('coupon_code','=',$request->discount_coupon)->where('coupontype','=','1')->first();
        if($getcoupon){
            return response()->json(["status"=>"200","msg"=>$getcoupon]);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }
    }

    // gift card coupon 

    public function giftcard_coupon(Request $request){
        $getcoupon = Coupon::where('coupon_code','=',$request->discount_coupon)->where('coupontype','=','2')->first();
        if($getcoupon){
            return response()->json(["status"=>"200","msg"=>$getcoupon]);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }
    }

    // corporate coupon 

    public function corporate_coupon(Request $request){
        $getcoupon = Coupon::where('coupon_code','=',$request->discount_coupon)->where('coupontype','=','3')->first();
        if($getcoupon){
            return response()->json(["status"=>"200","msg"=>$getcoupon]);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }
    }

    // card info save

    public function Usercardinfo(Request $request){
        $cust_id = Auth::user()->id;
        $saveCards = new CardInfo;
        $saveCards->cust_id = $cust_id;
        $saveCards->card_type = $request->inlineRadioOptions;
        $saveCards->card_holder_name = $request->card_holder;
        $saveCards->card_no = $request->card_no;
        $saveCards->exp_month = $request->card_exp_month;
        $saveCards->exp_year = $request->card_exp_year;
        $saveCards->cvv = $request->cvv;
        $saveCards->save();
        if($saveCards==true){
            return response()->json(["status"=>"200","msg"=>"1"]);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }
        
    }
    public function confermordercod($id)
    {
        $orderid = $id;
        return view('website.guestthanks',compact('orderid'));
    }


    // logged in user orders

    public function placeorder(Request $request){
        $cust_id = Auth::user()->id;
        $cust_Add = CustomerAddress::where('cust_id','=',$cust_id)->first();

        $address = "Unit No: $cust_Add->unit_no, Building No: $cust_Add->building_no, Zone: $cust_Add->zone, Street: $cust_Add->street";

        $products = array_map(function($n) {
            return Product::find($n)->title;
        }, $request->prodid);


        $order_number = mt_rand(100000000, 999999999);
        $order_details = [
            'order_number' => $order_number,
            'total' => $request->amount,
            'quantity' => $request->cartQty,
            'amount' => $request->cart_amount,
            'address' => $address,
            'products' => $products,
        ];

        if($cust_Add)
        {
            $cust_add_id = $cust_Add['id'];
            $prod_id = $request->prodid;
            $qty = $request->cartQty;
            $total_amount = $request->amount;
            $total_prod_id = count($prod_id);
            if($request->mode==1){
                for($i=0;$i<$total_prod_id;$i++){
                    $place_order = new Order;
                    $place_order->orderid=$order_number;
                    $place_order->cust_id=$cust_id;
                    $place_order->cust_add_id=$cust_add_id;
                    $place_order->prod_id=$prod_id[$i];
                    $place_order->qty = $qty[$i];
                    $place_order->amount = $total_amount;
                    $place_order->mode = '1';
                    $place_order->save();

                }
                if($place_order==true){
                    $cartid = Cmf::ipaddress();
                    $update_cart = Cart::where('cust_id','=',$cartid)->delete();
                    event(new OrderPlaced($order_details));
                    return response()->json(["status"=>"200","msg"=>"1","orderid"=>$order_number]);
                    exit();
                }else{
                    return response()->json(["status"=>"400","msg"=>"2"]);
                    exit();
                }
            }
        }else{
            return response()->json(["status"=>"300","msg"=>"3"]);
            exit();
        }

        
        

    }


    public function ordeconferm()
    {
        echo "string";
    }


    // customer order history 


    public function orderhistory(){
        $cust_id = Auth::user()->id;
        $orders = Order::leftJoin('products','products.id','=','orders.prod_id')
                ->select('products.*','orders.qty as OrderQty','orders.amount as orderAmt','orders.status as orderStatus','orders.id as orderid')
                ->where('orders.cust_id','=',$cust_id)
                ->orderBy('orders.id','desc')
                ->get();
        return view('website.orderHistory',compact('orders'));
    }


   




    // cart without login 


    public function addtocartWithoutLogin(Request $request){
        $cart = session()->get('cart');
        if(!$cart){
            $cart=[
                $request->id=>[
                    'name'=>$request->name,
                    'quantity'=>$request->qty,
                    'price'=>$request->price,
                    'image'=>$request->image
                ]
                ];
                session()->put('cart',$cart);
                return back()->with('success','added to cart');
                exit();
        }
        if(isset($cart[$request->id])){
            $cart[$request->id]['quantity']+$request->qty;
            session()->put('cart',$cart);
            return back()->with('success','added to cart');
            exit();
        }

        $cart[$request->id]=[
            'name'=>$request->name,
            'quantity'=>$request->qty,
            'price'=>$request->price,
            'image'=>$request->image
        ];
        session()->put('cart',$cart);
        return back()->with('success','added to cart');
    }


// your points

public function yourpoints(Request $request){
    return view('website.points');
}

public function giftcard(Request $request){
    return view('website.giftcards');
}




public function changepassword(Request $request){
    return view('website.changepassword');
}

    

    public function products(Request $request) {
        $products = Product::query();

        if ($request->has('24months')) {
            $products->where('recommended_age', '<=', 24);
        }

        if ($request->has('2_4years')) {
            $products->whereBetween('recommended_age', [24, 48]);
        }

        if ($request->has('5_7years')) {
            $products->whereBetween('recommended_age', [60, 84]);
        }

        if ($request->has('8_13years')) {
            $products->whereBetween('recommended_age', [96, 156]);
        }

        if ($request->has('14years')) {
            $products->where('recommended_age', '>=', 168);
        }

        if ($request->hasAny('min_value', 'max_value')) {
            $products->whereBetween('unit_price', [$request->min_value, $request->max_value]);
        }

        if ($request->has('search')) {
            $products->where('title', 'LIKE', "%{$request->search}%");
        }

        $products = $products->paginate(12);

        return view('website.product-list',compact('products'));
    }

    public function search(Request $request) {
        $products = Product::with('category', 'subCategory');
        $categories = Category::query();
        $subCategories = SubCategory::with(['parentCategory' => fn($q) => $q->select('id', 'url')]);
        $request->whenFilled('search', function($search) use ($products, $categories, $subCategories) {
            $products->where('title', 'LIKE', "%$search%")
                ->orWhere('barcode', 'LIKE', "%$search%")
                ->orWhere('sku', 'LIKE', "%$search%");
            $categories = $categories->where('category_name', 'LIKE', "%{$search}%");
            $subCategories = $subCategories->where('subcat_name', 'LIKE', "%{$search}%");
        });
        $products = $products->limit(4)->get();
        $categories = $categories->limit(4)->select('category_name', 'url')->get()
            ->map(function($item) {
                $item->url = route('website.cat_products', ['id' => $item->url]);
                return $item;
            });
        $subCategories = $subCategories->limit(4)->select('parent_cat', 'subcat_name', 'url')->get()
            ->map(function($item) {
                $item->url = route('website.subcat_products', ['main' => $item->parentCategory->url, 'id' => $item->url]);
                return $item;
            });

        return SearchProductResource::collection($products)->additional([
            'categories' => $categories,
            'subCategories' => $subCategories
        ]);
    }

}
