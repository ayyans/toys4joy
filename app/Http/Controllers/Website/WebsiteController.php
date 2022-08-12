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
// use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\CustomerAddress;
use App\Models\CardInfo;
use App\Models\Coupon;
use App\Models\giftcards;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\requiredproducts;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Stripe;
use Session;
use Auth;
use Carbon\Carbon;
use Darryldecode\Cart\CartCondition;
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

        $newarrivals = Product::where('new_arrival','=',1)->where('status','=','2')->orderBy('id','desc')->limit(10)->get();
        $bestsellers = Product::where('best_seller','=',1)->where('status','=','2')->orderBy('id','desc')->limit(10)->get();

        return view('website.home',compact('categories','products','newarrivals','bestsellers'));
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
    public function brandshow($id)
    {
        $categories = $this->listCategory();
        $brand = Brand::where('brand_name' , $id)->get()->first();
        $products = Product::where('brand_id','=',$brand->id)->where('status','=','2')->orderBy('id','desc')->paginate(12);
        return view('website.product-list',compact('categories','products'));
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

    
    public function guestthankorder($id)
    {
        $order_number = $id;
        return view('website.guestthanks',compact('order_number'));
    }


    // guest thanks page

    public function guestthank(Request $request) {
        $data =  $request->all();

        $status = $data['STATUS'];

        // check for successful transaction
        if ($status != 'TXN_SUCCESS') {
            return redirect()->route('website.payasmember')->with('error','Payment failed!');
        }

        $order_number = $data['ORDERID'];
        $transaction_number = $data['transaction_number'];

        $order = Order::where('order_number', $order_number)->first();
        $order->update([
            'payment_status' => 'paid',
            'transaction_number' => $transaction_number
        ]);

        $giftCardIds = cart()->getConditionsByType('giftcard')->map(function($g) {
            return $g->getAttributes()['id'];
        })->values();

        giftcards::whereIn('id', $giftCardIds)->update([
            'user_id' => auth()->id(),
            'order_id' => $order->id
        ]);

        // clearing cart
        cart()->clear();
        cart()->clearCartConditions();

        return view('website.guestthanks', compact('order_number'));

        // $ipaddres = Cmf::ipaddress();
        // $allparms =  $request->all();
        // $getorder = Order::where('orderid' , $allparms['ORDERID'])->get()->first();
        // $customer = DB::table('users')->where('id' , $getorder->cust_id)->get()->first();
        // auth()->attempt(['email'=>$customer->email,'password'=>$customer->show_password]);
        // if(Auth::check()){
        //     if($allparms['STATUS'] == 'TXN_SUCCESS')
        //     {
        //         $data = Order::where('orderid' , $allparms['ORDERID'])->get();
        //         foreach ($data as $r) {
        //             $updateorder = Order::find($r->id);
        //             $updateorder->orderstatus = 'sadadpayement';
        //             $updateorder->payment_id = $allparms['transaction_number'];
        //             $updateorder->save();
        //         }
        //         $cust_id = Auth::user()->id;
        //         $cust_Add = CustomerAddress::where('cust_id','=',$cust_id)->first();
        //         $cust_card = CardInfo::where('cust_id','=',$cust_id)->first();
        //         $cust_add_id = $cust_Add['id'];
        //         if($updateorder==true){
        //             $products = $updateorder->pluck('prod_id')->map(fn($i) => Product::find($i))->pluck('title');
        //             $quantity = $updateorder->pluck('qty');
        //             $amount = $updateorder->pluck('amount');
        //             $address = "Unit No: $cust_Add->unit_no, Building No: $cust_Add->building_no, Zone: $cust_Add->zone, Street: $cust_Add->street";
        //             $order_details = [
        //                 'order_number' => $allparms['ORDERID'],
        //                 'total' => $allparms['TXNAMOUNT'],
        //                 'quantity' => $quantity,
        //                 'amount' => $amount,
        //                 'address' => $address,
        //                 'products' => $products,
        //             ];
        //             event(new OrderPlaced($order_details));
        //             Cmf::sendordersms($allparms['ORDERID']);
        //             // $update_cart = Cart::where('cust_id','=',$ipaddres)->delete();
        //             // update gift card uses
        //             $giftCardIds = cart()->getConditionsByType('giftcard')->map(function($g) {
        //                 return $g->getAttributes()['id'];
        //             })->values();
        //             giftcards::whereIn('id', $giftCardIds)->update([ 'user_id' => auth()->id() ]);
        //             cart()->clear();
        //             $orderid = $allparms['ORDERID'];
        //             return view('website.guestthanks',compact('orderid'));
        //         }else{
        //            return redirect()->route('website.payasmember')->with('error','Order Not Placed!');
        //         }
        //     }else{
        //         return redirect()->route('website.payasmember')->with('error','Payement Failed!');
        //     }
        // }else{
        //     return redirect()->route('website.login')->with('error','Please Login!');
        // }
    }


    // add to cart



    public function addTocart(Request $request)
    {
        // $cust = Cmf::ipaddress();
        $prod_id = $request->prod_id;
        $qty = $request->quantity;

        $product = Product::where('id', '=', $prod_id)->first();

        if ($product->discount) {
            $price = $product->discount;
        } else {
            $price = $product->unit_price;
        }

        cart()->add([
            'id' => $product->id,
            'name' => $product->title,
            'price' => $price,
            'quantity' => $qty,
            'attributes' => [],
            'associatedModel' => $product
        ]);

        return response()->json([
            'status' => 200,
            'msg' => 1
        ]);

        // $existcart = Cart::where('cust_id', '=', $cust)->where('prod_id', '=', $prod_id)->count();
        // if ($existcart > 0) {
        //     $existqty = Cart::where('cust_id', '=', $cust)->where('prod_id', '=', $prod_id)->first();
        //     $updateqty = $existqty['qty'] + $qty;
        //     $qtyupdate = Cart::where('cust_id', '=', $cust)->where('prod_id', '=', $prod_id)->update(['qty' => $updateqty]);
        //     if ($qtyupdate == true) {
        //         return response()->json(["status" => "200", "msg" => "1"]);
        //     } else {
        //         return response()->json(["status" => "400", "msg" => "2"]);
        //     }
        // } else {
        //     $getproduct = Product::where('id', '=', $prod_id)->first();
        //     if ($qty <= $getproduct['qty']) {
        //         $addTo = new Cart;
        //         $addTo->cust_id = $cust;
        //         $addTo->prod_id = $prod_id;
        //         $addTo->qty = $qty;
        //         $addTo->amount = $price;
        //         $addTo->save();
        //         if ($addTo == true) {
        //             return response()->json(["status" => "200", "msg" => "1"]);
        //         } else {
        //             return response()->json(["status" => "400", "msg" => "2"]);
        //         }
        //     } else {
        //         return response()->json(["status" => "400", "msg" => "3"]);
        //     }
        // }
    }

    public function cartPageContent()
    {
        // $cust_id = Cmf::ipaddress();
        // $data = Cart::leftJoin('products','products.id','=','carts.prod_id')
                
        // ->select('carts.id as crtid','carts.qty as cartQty','products.*')
        // ->where('carts.cust_id','=',$cust_id)       
        // ->orderBy('carts.id','desc')
        // ->get();

        $items = cart()->getContent();
        $totalPrice = cart()->getSubTotal();

        // $totalPrice = $data->sum(function ($cart) {
        //     if($cart->discount)
        //     {
        //         $price = $cart->discount;
        //     }else{
        //         $price = $cart->unit_price;
        //     }
        //     return $price * $cart->cartQty;
        // });

        $body = '';

        foreach ($items as $item) {
            $body .= '
                <tr>
                    <td class="qty"><input type="number" value="'.$item->quantity.'" id="quantity" name="quantity" min="1" max="'.$item->associatedModel['qty'].'" onchange="updatecartQty('.$item->id.',this.value)"></td>
                    <td class="title">
                    <div class="d-flex product-rank">
                        <div class="detail"><p>'.$item->name.'</p></div>
                    </div>
                    </td>
                    <td><div class="img-box"><img src="'.asset('products/'.$item->associatedModel['featured_img']).'"/></div></td>
                    <td class="price"><span>QAR '.$item->price.'</span></td>
                    <td class="delete"><div class="rmv-icon"><a href="javascript:void(0)" onclick="removeCartContent('.$item->id.')"><img src="'.asset('website/img/delete-product.png').'"/></a></div></td>
                </tr>';
        }

        // if($data->count() > 0) {
        //     $total_price = 0;
        //     foreach($data as $cart) {

        //         if($cart->discount)
        //         {
        //             $price = $cart->discount;
        //         }else{
        //             $price = $cart->unit_price;
        //         }

                
        //         $total_price+=$price*$cart->cartQty;
        //         $body .= '
        //         <tr>
        //             <td class="qty"><input type="number" value="'.$cart->cartQty.'" id="quantity" name="quantity" min="1" max="'.$cart->qty.'" onchange="updatecartQty('.$cart->crtid.',this.value)"></td>
        //             <td class="title">
        //             <div class="d-flex product-rank">
        //                 <div class="detail"><p>'.$cart->title.'</p></div>
        //             </div>
        //             </td>
        //             <td><div class="img-box"><img src="'.asset('products/'.$cart->featured_img).'"/></div></td>
        //             <td class="price"><span>QAR '.$price.'</span></td>
        //             <td class="delete"><div class="rmv-icon"><a href="javascript:void(0)" onclick="removeCartContent('.$cart->crtid.')"><img src="'.asset('website/img/delete-product.png').'"/></a></div></td>
        //         </tr>';
        //     }
        // }

        return [
            'body' => $body,
            'total' => $totalPrice
        ];
    }

    // view cart 
    public function showcart()
    {
        // $cust_id = Cmf::ipaddress();
        // $data = Cart::leftJoin('products', 'products.id', '=', 'carts.prod_id')

        // ->select('carts.id as crtid', 'carts.qty as cartQty', 'products.*')
        // ->where('carts.cust_id', '=', $cust_id)
        // ->orderBy('carts.id', 'desc')
        // ->get();

        $items = cart()->getContent();
        $total_price = cart()->getSubTotal();
        if (cart()->isEmpty()) {
            echo '<div class="cart-main-title"><h5 id="offcanvasRightLabel">My Bag</h5></div>       
            <div id="cartdetailsheader">
                <p>No products in cart</p>
            </div>
            ';
        } else {
            foreach ($items as $item) {
                echo '<div class="cart-main-title"><h5 id="offcanvasRightLabel">My Basket</h5></div>       
                <div id="cartdetailsheader">';
                echo '<div class="d-flex added-products"> 
                    <div class="pro-image">
                    <img src="' . asset("products") . '/' . $item->associatedModel['featured_img'] . '">
                    </div><div class="product-detail"> 
                    <h2 class="title">' . $item->name . '</h2> 
                    <h4 class="price">QAR ' . $item->price . '</h4> 
                    <div class="d-flex rmv-or-edit"> 
                    <div class="qty">
                    <input type="number" value="' . $item->quantity . '" id="quantity" name="quantity" min="1" max="2" onchange="updateQty(' . $item->id . ',this.value)">
                    </div>
                    <div class="remove icon">
                    <a href="javascript:void(0)" onclick="removecart(' . $item->id . ')">
                    <img src="' . asset('website/img/delete.png') . '">
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
                    <h5 class="price" id="subtotal_price">QAR ' . $total_price . '</h5>
                </div>
            </div>
            <div class="d-flex btn-area">
                <div class="checkout btn"><a href="' . route('website.cartpage') . '">Checkout</a></div>
            </div>';
        }

        // if ($data->count() > 0
        // ) {
        //     echo '<div class="cart-main-title"><h5 id="offcanvasRightLabel">My Basket</h5></div>       
        //     <div id="cartdetailsheader">';
        //     $total_price = 0;
        //     foreach ($data as $r) {
        //         if ($r->discount) {
        //             $price = $r->discount;
        //         } else {
        //             $price = $r->unit_price;
        //         }

        //         $total_price += $r->cartQty * $price;
        //         echo '<div class="d-flex added-products"> 
        //         <div class="pro-image">
        //         <img src="' . asset("products") . '/' . $r->featured_img . '">
        //         </div><div class="product-detail"> 
        //         <h2 class="title">' . $r->title . '</h2> 
        //         <h4 class="price">QAR ' . $price . '</h4> 
        //         <div class="d-flex rmv-or-edit"> 
        //         <div class="qty">
        //         <input type="number" value="' . $r->cartQty . '" id="quantity" name="quantity" min="1" max="2" onchange="updateQty(' . $r->crtid . ',this.value)">
        //         </div>
        //         <div class="remove icon">
        //         <a href="javascript:void(0)" onclick="removecart(' . $r->crtid . ')">
        //         <img src="' . asset('website/img/delete.png') . '">
        //         </a>
        //         </div>
        //         </div>
        //         </div>
        //         </div>';
        //     }

        //     echo '</div>
        //      <hr>
        //     <div class="d-flex total-n-shipping">
        //         <div class="d-flex subtotal">
        //             <h4>Subtotal:</h4>
        //             <h5 class="price" id="subtotal_price">QAR ' . $total_price . '</h5>
        //         </div>
        //     </div>
        //     <div class="d-flex btn-area">
        //         <div class="checkout btn"><a href="' . route('website.cartpage') . '">Checkout</a></div>
        //     </div>';
        // } else {
        //     echo '<div class="cart-main-title"><h5 id="offcanvasRightLabel">My Bag</h5></div>       
        //     <div id="cartdetailsheader">
        //         <p>No products in cart</p>
        //     </div>
        //     ';
        // }
    }

    public function headerCart(Request $request){
        // $cust_id = $request->cust_id;
        // $data = Cart::leftJoin('products','products.id','=','carts.prod_id')
                
        // ->select('carts.id as crtid','carts.qty as cartQty','products.*')
        // ->where('carts.cust_id','=',$cust_id)       
        // ->orderBy('carts.id','desc')
        // ->get();
        $count = cart()->getContent()->count();
        if($count!=0){
            return response()->json(["status"=>"200","count"=>$count]);
        }else{
            return response()->json(["status"=>"400","msg"=>"1"]);
        } 
    }

    // cart page

    public function cartpage(){
        // $cust_id = Cmf::ipaddress();
        // $carts = Cart::leftJoin('products','products.id','=','carts.prod_id')                
        // ->select('carts.id as crtid','carts.qty as cartQty','products.*')
        // ->where('carts.cust_id','=',$cust_id)       
        // ->orderBy('carts.id','desc')
        // ->get();

        return view('website.cartpage');
    }

    // remove product from cart

    public function removedcartProd(Request $request){
        cart()->remove($request->cartid);
        return response()->json([
            'status' => 200,
            'msg' => 1
        ]);
        // $removed = Cart::where('id','=',$request->cartid)->delete();
        // if($removed==true){
        //     return response()->json(["status"=>"200","msg"=>"1"]);
        // }else{
        //     return response()->json(["status"=>"400","msg"=>"2"]); 
        // }

    }

    // update cart

    public function updateQTY(Request $request){
        cart()->update($request->cartid, [
            'quantity' => [
                'relative' => false,
                'value' => $request->qty
            ]
        ]);
        return response()->json([
            'status' => 200,
            'msg' => 1
        ]);
        // $updateQty = Cart::where('id','=',$request->cartid)->update([
        //     'qty'=>$request->qty
        // ]);
        // if($updateQty == true){
        //     return response()->json(["status"=>"200","msg"=>"1"]);
        // }else{
        //     return response()->json(["status"=>"200","msg"=>"1"]);
        // }
    }


    // pay as member

    public function payasmember(Request $request){
        $cust_id = Cmf::ipaddress();
        // $data = array('customer_id' => Auth::user()->id);
        // DB::table('carts')->where('cust_id' , $cust_id)->update($data);
        // $products = Cart::leftJoin('products','products.id','=','carts.prod_id')
        //             ->leftJoin('brands','brands.id','=','products.brand_id')                    
        //             ->select('products.*','brand_name','logo','carts.id as crtid','carts.qty as cartQty','carts.giftcode as giftcode')
        //             ->where('carts.cust_id','=',$cust_id)
        //             ->get();
        $items = cart()->getContent();

        
        // $giftcoupencode = Cart::where('cust_id' , $cust_id)->where('giftcode' , '!=' , '')->count();


        // if($products->count()>0)
        if(! cart()->isEmpty())
        {
            $checkaddres = CustomerAddress::where('cust_id' , Auth::user()->id)->count();
            if($checkaddres > 0)
            {
                // return view('website.payasmember',compact('products','giftcoupencode'));
                return view('website.payasmember',compact('items'));
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
    function grabIpInfo($ip)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.ipgeolocation.io/ipgeo?apiKey=97136d19e82c4014a6ca11f8fe1971ab&ip=".$ip);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $returnData = curl_exec($curl);
        curl_close($curl);
        return $returnData;
    }
    function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function addAddressInfo(){
        $ip_address =  $this->getUserIpAddr();
        $ipInfo = $this->grabIpInfo($ip_address);
        $ipdata =  json_decode($ipInfo);
        $address = CustomerAddress::where('cust_id' , Auth::user()->id);
        if($address->count() > 0)
        {
            if($address->get()->first()->latitude)
            {
                $lattitude =  $ipdata->latitude ?? 25.281639;
                $longitude =  $ipdata->longitude ?? 51.524300;
            }
        }else{
            $lattitude =  $ipdata->longitude ?? 25.281639;
            $longitude =  $ipdata->latitude ?? 51.524300;
        }
        return view('website.add_address')->with(array('lattitude'=>$lattitude,'longitude'=>$longitude));
    }


    public function registrationThank(){
        return view('website.registration_thank');
    }

    // add address process

    


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
            $addwishlist->share_status=1;
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
        $cust_id = $request->cust_id;
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
        // Check if any type of coupon already in use
        $coupon = cart()->getConditionsByType('coupon');
        if ($coupon->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'You can\'t use more than 1 coupon at a time.'
            ]);
        }

        $discountCoupon = Coupon::where([
            'coupon_code' => $request->discount,
            'coupontype' => 1 // discount coupon
        ])->first();

        // check availability
        if (!$discountCoupon) {
            return response()->json([
                'status' => false,
                'message' => 'Code is invalid.'
            ]);
        }
        // check status
        if ($discountCoupon->status == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon is blocked.'
            ]);
        }

        $expire_date = Carbon::parse($discountCoupon->exp_date)->endOfDay();
        if (now()->greaterThan($expire_date)) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon is expired.'
            ]);
        }

        $couponCondition = new CartCondition([
            'name' => 'Discount Coupon',
            'type' => 'coupon',
            'target' => 'total',
            'value' => -$discountCoupon->offer.'%',
            'attributes' => [
                'id' => $discountCoupon->id,
                'code' => $discountCoupon->coupon_code
            ]
        ]);

        cart()->condition($couponCondition);

        return response()->json([
            'status' => true,
            'message' => 'Discount coupon added.'
        ]);

        // $getcoupon = Coupon::where('coupon_code','=',$request->discount_coupon)->where('coupontype','=','1')->first();
        // if($getcoupon){
        //     return response()->json(["status"=>"200","msg"=>$getcoupon]);
        //     exit();
        // }else{
        //     return response()->json(["status"=>"400","msg"=>"2"]);
        //     exit();
        // }
    }

    // remove discount coupon
    public function removeDiscountCoupon(Request $request) {
        cart()->removeCartCondition($request->name);
		return back()->with('success','Discount coupon removed.');
    }

    // corporate coupon 

    public function corporate_coupon(Request $request){
        // $getcoupon = Coupon::where('coupon_code','=',$request->discount_coupon)->where('coupontype','=','3')->first();
        // if($getcoupon){
        //     return response()->json(["status"=>"200","msg"=>$getcoupon]);
        //     exit();
        // }else{
        //     return response()->json(["status"=>"400","msg"=>"2"]);
        //     exit();
        // }

        // Check if any type of coupon already in use
        $coupon = cart()->getConditionsByType('coupon');
        if ($coupon->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'You can\'t use more than 1 coupon at a time.'
            ]);
        }

        $corporateCoupon = Coupon::where([
            'coupon_code' => $request->corporate,
            'coupontype' => 3 // corporate coupon
        ])->first();

        // check availability
        if (!$corporateCoupon) {
            return response()->json([
                'status' => false,
                'message' => 'Code is invalid.'
            ]);
        }
        // check status
        if ($corporateCoupon->status == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon is blocked.'
            ]);
        }

        $expire_date = Carbon::parse($corporateCoupon->exp_date)->endOfDay();
        if (now()->greaterThan($expire_date)) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon is expired.'
            ]);
        }

        $couponCondition = new CartCondition([
            'name' => 'Corporate Coupon',
            'type' => 'coupon',
            'target' => 'total',
            'value' => -$corporateCoupon->offer.'%',
            'attributes' => [
                'id' => $corporateCoupon->id,
                'code' => $corporateCoupon->coupon_code
            ]
        ]);

        cart()->condition($couponCondition);

        return response()->json([
            'status' => true,
            'message' => 'Corporate coupon added.'
        ]);
    }

    // remove discount coupon
    public function removeCorporateCoupon(Request $request) {
        cart()->removeCartCondition($request->name);
		return back()->with('success','Corporate coupon removed.');
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
        $order_number = $id;
        return view('website.guestthanks',compact('order_number'));
    }


    // logged in user orders

    public function placeorder(Request $request)
    {
        $items = cart()->getContent();
        $user = auth()->user()->load('address');
        $order_number = mt_rand(100000000, 999999999);
        // creating order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => $order_number,
            'address_id' => $user->address->id,
            'order_type' => 'cod',
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

        $giftCardIds = cart()->getConditionsByType('giftcard')->map(function($g) {
            return $g->getAttributes()['id'];
        })->values();

        giftcards::whereIn('id', $giftCardIds)->update([ 'user_id' => auth()->id() ]);

        // clearing cart
        cart()->clear();
        cart()->clearCartConditions();

        return response()->json([
            'status' => true,
            'order_number' => $order_number
        ]);

        // $cust_id = Auth::user()->id;
        // $cust_Add = CustomerAddress::where('cust_id','=',$cust_id)->first();

        // $address = "Unit No: $cust_Add->unit_no, Building No: $cust_Add->building_no, Zone: $cust_Add->zone, Street: $cust_Add->street";

        // $products = array_map(function($n) {
        //     return Product::find($n)->title;
        // }, $request->prodid);


        // $order_number = mt_rand(100000000, 999999999);
        // $order_details = [
        //     'order_number' => $order_number,
        //     'total' => $request->amount,
        //     'quantity' => $request->cartQty,
        //     'amount' => $request->cart_amount,
        //     'address' => $address,
        //     'products' => $products,
        // ];

        // if($cust_Add)
        // {
        //     $cust_add_id = $cust_Add['id'];
        //     $prod_id = $request->prodid;
        //     $qty = $request->cartQty;
        //     $total_amount = $request->amount;
        //     $total_prod_id = count($prod_id);

        //     // $cartid = Cmf::ipaddress();
        //     // $cartproducts = Cart::where('cust_id','=',$cartid)->get()->first();

        //     $giftCardCodes = cart()->getConditionsByType('giftcard')->map(function($g) {
        //         return $g->getAttributes()['code'];
        //     })->values()->implode(', ');


        //     if($request->mode==1){
        //         for($i=0;$i<$total_prod_id;$i++){
        //             $place_order = new Order;
        //             $place_order->orderid=$order_number;
        //             $place_order->orderstatus='simpleorder';
        //             $place_order->cust_id=$cust_id;
        //             $place_order->cust_add_id=$cust_add_id;
        //             $place_order->prod_id=$prod_id[$i];
        //             $place_order->qty = $qty[$i];
        //             $place_order->amount = $total_amount;
        //             $place_order->ordertype = 'membercashondelivery';
        //             $place_order->newstatus = 1;
        //             $place_order->giftcode = $giftCardCodes;
        //             $place_order->mode = '1';
        //             $place_order->save();

        //         }
        //         if($place_order==true){
        //             // $cartid = Cmf::ipaddress();
        //             // $update_cart = Cart::where('cust_id','=',$cartid)->delete();
        //             cart()->clear();
        //             event(new OrderPlaced($order_details));
        //             Cmf::sendordersms($order_number);
        //             return response()->json(["status"=>"200","msg"=>"1","orderid"=>$order_number]);
        //             exit();
        //         }else{
        //             return response()->json(["status"=>"400","msg"=>"2"]);
        //             exit();
        //         }
        //     }
        // }else{
        //     return response()->json(["status"=>"300","msg"=>"3"]);
        //     exit();
        // }
    }


    public function ordeconferm()
    {
        echo "string";
    }


    // customer order history 


   


   




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
