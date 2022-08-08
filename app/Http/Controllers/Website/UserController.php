<?php

namespace App\Http\Controllers\Website;
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
use App\Models\giftcards;
use App\Models\User;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\CustomerAddress;
use App\Models\CardInfo;
use App\Models\Coupon;
use App\Models\usergiftcards;
use App\Models\sibblings;
use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Stripe;
use Session;
use Auth;
use Darryldecode\Cart\CartCondition;
use DB;
use Mail;
class UserController extends Controller
{
	// gift card coupon 
	public function removegiftcard()
	{
		// $cartid = Cmf::ipaddress();
		// $getcode = Cart::where('cust_id','=',$cartid)->get()->first()->giftcode;
		// usergiftcards::where('code' , $getcode)->update(['isused'=>' ']);
		// Cart::where('cust_id','=',$cartid)->update(['giftcode'=>' ']);
		cart()->removeCartCondition('Gift Card');
		return back()->with('success','Gift Card Remove Successfully');
	}
    public function giftcard_coupon(Request $request){

    	$checkcode = usergiftcards::where('code' , $request->discount_coupon)->get();

    	if($checkcode->count() > 0)
    	{
    		if($checkcode->first()->isused == 'yes')
    		{
    			return response()->json(["status"=>"400","msg"=>"Code is Already Used."]);
            	exit();
    		}else
    		{
    			// $cartid = Cmf::ipaddress();
    			// Cart::where('cust_id','=',$cartid)->update(['giftcode'=>$request->discount_coupon]);
					$giftcardCondition = new CartCondition([
						'name' => 'Gift Card',
						'type' => 'giftcard',
						'target' => 'total',
						'value' => -300,
						'attributes' => [
							'code' => $request->discount_coupon
						]
					]);

					cart()->condition($giftcardCondition);
					usergiftcards::where('code' , $request->discount_coupon)->update(['isused'=>'yes']);

    			return response()->json(["status"=>"200","msg"=>'1']);
            	exit();
    		}
    	}else
    	{
    		return response()->json(["status"=>"400","msg"=>"Code is Invalid."]);
            exit();
    	}
    }
	public function myprofile(Request $request)
	{
	    return view('website.user.myprofile');
	}
	public function changemobilenumber()
	{
		return view('website.user.changemobilenumber');
	}
	public function updatemobilenumber(Request $request)
	{
		$update = User::find(Auth::user()->id);
		$update->mobile = $request->mobilenumber;
		$update->save();
		return back()->with('success','Mobile Number Updated Successfully');
	}
	public function mysiblings()
	{
		$check = sibblings::where('user_id',Auth::user()->id)->count();

		if($check == 0)
		{
			$newsibling = new sibblings();
			$newsibling->user_id = Auth::user()->id;
			$newsibling->save();
		}
		$data = sibblings::where('user_id',Auth::user()->id)->get()->first();
        return view('website.user.mysiblings',compact('data'));
	}
	public function siblingsupdate(Request $request)
	{
		$check = sibblings::where('user_id',Auth::user()->id)->get()->first();
		$newsibling = sibblings::find($check->id);
		$newsibling->boy_one_name = $request->boy_one_name;
		$newsibling->boy_one_dob = $request->boy_one_dob;
		$newsibling->boy_tow_name = $request->boy_tow_name;
		$newsibling->boy_tow_dob = $request->boy_tow_dob;
		$newsibling->boy_three_name = $request->boy_three_name;
		$newsibling->boy_three_dob = $request->boy_three_dob;
		$newsibling->boy_four_name = $request->boy_four_name;
		$newsibling->boy_four_dob = $request->boy_four_dob;
		$newsibling->boy_five_name = $request->boy_five_name;
		$newsibling->boy_five_dob = $request->boy_five_dob;
		$newsibling->girl_one_name = $request->girl_one_name;
		$newsibling->girl_one_dob = $request->girl_one_dob;
		$newsibling->girl_tow_name = $request->girl_tow_name;
		$newsibling->girl_tow_dob = $request->girl_tow_dob;
		$newsibling->girl_three_name = $request->girl_three_name;
		$newsibling->girl_three_dob = $request->girl_three_dob;
		$newsibling->girl_four_name = $request->girl_four_name;
		$newsibling->girl_four_dob = $request->girl_four_dob;
		$newsibling->girl_five_name = $request->girl_five_name;
		$newsibling->girl_five_dob = $request->girl_five_dob;
		$newsibling->save();
		return back()->with('success','Siblings Updated Successfully');
	}

	public function returnRequest(Request $request) 
	{
		if ($request->hasFile('receipt')) {
			$receipt = $request->file('receipt')->store('receipts', 'public');
		}

		auth()->user()->returnRequests()->create([
			'reason' => $request->reason,
			'detail' => $request->detail,
			'receipt' => $receipt ?? null,
			'status' => 'in-progress',
		]);

		return view('website.user.return-request-thankyou');
	}
	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	public function addgiftcard($id , $orderid)
	{
		$giftcard = giftcards::where('id' , $id)->get()->first();
		$card = new usergiftcards();
		$card->user_id = Auth::user()->id;
		$card->gift_card_id = $id;
		$card->code = $this->generateRandomString();
		$card->orderid = $orderid;
		$card->status = 1;
		$card->payement = 'pending';
		$card->save();
		if($card){
            return response()->json(["status"=>"200","msg"=>'success']);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }
	}
	public function giftcardconfermorder(Request $request)
	{
		$allparms =  $request->all();
		if($allparms['STATUS'] == 'TXN_SUCCESS')
        {
        	$usergiftcard = usergiftcards::where('orderid' , $allparms['ORDERID'])->get()->first();
        	$card = usergiftcards::find($usergiftcard->id);
			$card->status = 2;
			$card->payement = 'completed';
			$card->save();
			$customer = DB::table('users')->where('id' , $card->user_id)->get()->first();
        	auth()->attempt(['email'=>$customer->email,'password'=>$customer->show_password]);
			Mail::send('emails.giftcard', ['card' => $card], function($message) use($request){
	              $message->to(Auth::user()->email);
	              $message->subject('Purchase Gift Card');
	        });
	        $orderid = $allparms['ORDERID'];
			return view('website.guestthanksgiftcard',compact('orderid'));
        }else{
        	return redirect()->route('website.giftcard')->with('error','Payement Failed');
        }
	}
	public function generateinvoicegiftcard()
	{
		
	}
	public function submituserprofile(Request $request)
	{
		$user = User::find(Auth::user()->id);
		$user->day = $request->day;
		$user->month = $request->month;
		$user->year = $request->year;
		$user->gender = $request->radio;
		$user->save();
		return back()->with('success','Profile Updated Successfully');
	}
	public function addAddressProcess(Request $request){
		$check = CustomerAddress::where('cust_id' , Auth::user()->id)->get();
		if($check->count() > 0)
		{
			$cust_address = CustomerAddress::find($check->first()->id);
	        $cust_address->unit_no=$request->unit_no;
	        $cust_address->building_no=$request->buid_no;
	        $cust_address->latitude=$request->latitude;
	        $cust_address->longitude=$request->longitude;
	        $cust_address->zone=$request->zone;
	        $cust_address->street=$request->street;
	        $cust_address->save();
		}else{
			$cust_id = Auth::user()->id;
	        $cust_address = new CustomerAddress;
	        $cust_address->cust_id=$cust_id;
	        $cust_address->unit_no=$request->unit_no;
	        $cust_address->latitude=$request->latitude;
	        $cust_address->longitude=$request->longitude;
	        $cust_address->building_no=$request->buid_no;
	        $cust_address->zone=$request->zone;
	        $cust_address->street=$request->street;
	        $cust_address->save();
		}
        if($cust_address==true){
            return response()->json('1');
            exit();
        }else{
            return response()->json('2');
            exit();
        }
    }
     public function orderhistory(){
        $cust_id = Auth::user()->id;
        $orders = Order::leftJoin('products','products.id','=','orders.prod_id')
                ->select('products.*','orders.qty as OrderQty','orders.orderid as ordernumber','orders.amount as orderAmt','orders.status as orderStatus','orders.id as orderid')
                ->where('orders.cust_id','=',$cust_id)
                ->orderBy('orders.id','desc')
                ->groupby('orders.orderid')
                ->get();
        return view('website.user.orderHistory',compact('orders'));
    }
    public function orderdetail($id)
    {
    	$orderid = $id;
    	$orders = Order::leftJoin('products','products.id','=','orders.prod_id')
                ->select('products.*','orders.qty as OrderQty','orders.orderid as ordernumber','orders.amount as orderAmt','orders.status as orderStatus','orders.id as orderid')
                ->orderBy('orders.id','desc')
                ->where('orders.orderid' , $id)
                ->get();
    	return view('website.user.orderdetail',compact('orders','orderid'));
    	
    }
    public function changepassword(Request $request){
	    return view('website.user.changepassword');
	}
	public function updateusersecurity(Request $request)
	{
		$this->validate($request, [
        'oldpassword' => 'required',
        'newpassword' => 'required',
        ]);
        if($request->newpassword == $request->password_confirmed){
        $hashedPassword = Auth::user()->password;
       if (\Hash::check($request->oldpassword , $hashedPassword )) {
         if (!\Hash::check($request->newpassword , $hashedPassword)) {
              $users =User::find(Auth::user()->id);
              $users->password = bcrypt($request->newpassword);
              User::where( 'id' , Auth::user()->id)->update( array( 'password' =>  $users->password));
              session()->flash('message','password updated successfully');
              return redirect()->back();
            }
            else{
                  session()->flash('errorsecurity','New password can not be the old password!');
                  return redirect()->back();
                }
           }
          else{
               session()->flash('errorsecurity','Old password Doesnt matched ');
               return redirect()->back();
             }
        }else{
            session()->flash('errorsecurity','Repeat password Doesnt matched With New Password');
            return redirect()->back();
        }
	}
}