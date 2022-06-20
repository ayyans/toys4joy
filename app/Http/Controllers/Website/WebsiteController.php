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


class WebsiteController extends Controller
{
    //

    public function __construct(){ 

        $categoriestest = $this->listCategory();
        View::share('categoriestest', $categoriestest);
        
    }


    public function index(){
        $categories = $this->listCategory();
        return view('website.home',compact('categories'));
    }

    // listing category

    public function listCategory(){
        $categories = Category::where('status','=','2')->orderBy('id','desc')->get();
        return $categories;

    }

    // category wise product

    public function listproducts(Request $request){
        $categories = $this->listCategory();
        $catid = decrypt($request->catid);
        $products = Product::where('category_id','=',$catid)->where('status','=','2')->orderBy('id','desc')->get();
        return view('website.product-list',compact('categories','products','catid'));
    }


    // product details

    public function productDetails(Request $request){
        $categories = $this->listCategory();
        $catid = decrypt($request->catid);
        $prodid = decrypt($request->prodid);
        $products = Product::leftJoin('brands','brands.id','=','products.brand_id')                    
                    ->select('products.*','brand_name','logo')
                    ->where('products.id','=',$prodid)
                    ->first();
          $gallery = ProductImage::where('prod_id','=',$prodid)->orderBy('id','desc')->get();          
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
        $updatemobile = $request->cntrycode.$request->mobile;
        $custDetails = new GuestOrder;
        $custDetails->prod_id=$request->prod_id;
        $custDetails->qty=$request->prod_qty;
        $custDetails->cust_name=$request->custname;
        $custDetails->cust_email=$request->email;
        $custDetails->cust_mobile=$updatemobile;
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
            return response()->json(["status"=>"200","msg"=>$lastID]);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }       

    }


    // guest thanks page

    public function guestthank(){
        return view('website.guestthanks');
    }


    // add to cart


    
    public function addTocart(Request $request){
           
        $cust = Auth::guard('cust')->user()->id;
        $prod_id = $request->prod_id;
        $qty = $request->quantity;
        $existcart = Cart::where('cust_id','=',$cust)->where('prod_id','=',$prod_id)->count();        
        if($existcart>0){
            $existqty = Cart::where('cust_id','=',$cust)->where('prod_id','=',$prod_id)->first();
            $updateqty = $existqty['qty']+$qty;
            $qtyupdate = Cart::where('cust_id','=',$cust)->where('prod_id','=',$prod_id)
                        ->update([
                            'qty'=>$updateqty
                        ]);
                        if($qtyupdate==true){
                            return response()->json(["status"=>"200","msg"=>"1"]);
                        }else{
                            return response()->json(["status"=>"400","msg"=>"2"]); 
                        }
        }else{
            $getproduct = Product::where('id','=',$prod_id)->first();
            if($qty<$getproduct['qty']){
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
        $cust_id = Auth::guard('cust')->user()->id;
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
        $cust_id = Auth::guard('cust')->user()->id;
        $products = Cart::leftJoin('products','products.id','=','carts.prod_id')
                    ->leftJoin('brands','brands.id','=','products.brand_id')                    
                    ->select('products.*','brand_name','logo','carts.id as crtid','carts.qty as cartQty')
                    ->where('carts.cust_id','=',$cust_id)
                    ->get();
        return view('website.payasmember',compact('products'));
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
        $cust_id = Auth::guard('cust')->user()->id;
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
        $cust_id = Auth::guard('cust')->user()->id;
        $prod_id = $request->prod_id;
        $getwishlist = Wishlist::where('cust_id','=',$cust_id)->where('prod_id','=',$prod_id)->count();
        if($getwishlist > 0){
            return response()->json(["status"=>"400","msg"=>"3"]);
            exit();
        }else{
            $addwishlist = new Wishlist;
            $addwishlist->cust_id=$cust_id;
            $addwishlist->prod_id=$prod_id;
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


    // wishlist list

    public function mywishlist(Request $request){
        $cust_id = decrypt($request->cust_id);
        $wshlists = Wishlist::leftJoin('products','products.id','=','wishlists.prod_id')
                    ->select('products.*','wishlists.id as wish_id')
                    ->where('wishlists.cust_id','=',$cust_id)
                    ->orderBy('wishlists.id','desc')
                    ->get();
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
                    ->select('products.*','wishlists.id as wish_id')
                    ->where('wishlists.cust_id','=',$cust_id)
                    ->orderBy('wishlists.id','desc')
                    ->get();
        return view('website.share_wishlist',compact('wshlists'));
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
        $cust_id = Auth::guard('cust')->user()->id;
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


    // logged in user orders

    public function placeorder(Request $request){

        $cust_id = Auth::guard('cust')->user()->id;
        $cust_Add = CustomerAddress::where('cust_id','=',$cust_id)->first();
        $cust_card = CardInfo::where('cust_id','=',$cust_id)->first();
        $cust_add_id = $cust_Add['id'];
        $cust_card_id = $cust_card['id'];

        $prod_id = $request->prodid;
        $qty = $request->cartQty;
        $total_amount = $request->amount;
        $total_prod_id = count($prod_id);
        if($request->mode==1){
            for($i=0;$i<$total_prod_id;$i++){
                $place_order = new Order;
                $place_order->cust_id=$cust_id;
                $place_order->cust_add_id=$cust_add_id;
                $place_order->prod_id=$prod_id[$i];
                $place_order->qty = $qty[$i];
                $place_order->amount = $total_amount;
                $place_order->mode = '1';
                $place_order->save();

            }
            if($place_order==true){
                $update_cart = Cart::where('cust_id','=',$cust_id)->delete();
                return response()->json(["status"=>"200","msg"=>"1"]);
                exit();
            }else{
                return response()->json(["status"=>"400","msg"=>"2"]);
                exit();
            }
        }
        

    }



    // customer order history 


    public function orderhistory(){
        $cust_id = Auth::guard('cust')->user()->id;
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

public function myprofile(Request $request){
    return view('website.myprofile');
}


public function changepassword(Request $request){
    return view('website.changepassword');
}

    


}
