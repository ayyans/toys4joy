<?php

namespace App\Http\Controllers\Website;
use DB;
use Auth;
use Mail;
use Stripe;
use Session;
use App\Helpers\Cmf;
use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\CardInfo;
use App\Models\Category;
use App\Models\ProdAttr;
use App\Models\Wishlist;
use App\Models\Attribute;
use App\Models\AttrValue;
use App\Models\giftcards;
use App\Models\OrderItem;
use App\Models\sibblings;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ReturnRequest;
use App\Models\usergiftcards;
use Illuminate\Http\Response;
use App\Models\CustomerAddress;
use App\Http\Controllers\Controller;
use Darryldecode\Cart\CartCondition;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
	// gift card coupon 
	public function removegiftcard(Request $request)
	{
		// $cartid = Cmf::ipaddress();
		// $getcode = Cart::where('cust_id','=',$cartid)->get()->first()->giftcode;
		// usergiftcards::where('code' , $getcode)->update(['isused'=>' ']);
		// Cart::where('cust_id','=',$cartid)->update(['giftcode'=>' ']);
		cart()->removeCartCondition($request->name);
		giftcards::find($request->id)->update([ 'engaged' => false ]);
		return back()->with('success','Gift card removed.');
	}
    public function giftcard_coupon(Request $request){

    	$giftCard = giftcards::firstWhere('code', $request->giftCard);

			// check availability
			if (!$giftCard) {
				return response()->json([
					'status' => false,
					'message' => 'Code is invalid.'
				]);
			}
			// check status
			if ($giftCard->status == 0) {
				return response()->json([
					'status' => false,
					'message' => 'Gift Card is blocked.'
				]);
			}
			// check engaged
			if ($giftCard->engaged) {
				return response()->json([
					'status' => false,
					'message' => 'Gift Card is engaged.'
				]);
			}
			// check already used
			if ($giftCard->order_id) {
				return response()->json([
					'status' => false,
					'message' => 'Code is already used.'
				]);
			}


			$giftCardCondition = new CartCondition([
				'name' => 'Gift Card ' . $giftCard->id,
				'type' => 'giftcard',
				'target' => 'total',
				'value' => -$giftCard->price,
				'attributes' => [
					'id' => $giftCard->id,
					'code' => $giftCard->code
				]
			]);

			cart()->condition($giftCardCondition);

			$giftCard->update([ 'engaged' => 1 ]);

			return response()->json([
				'status' => true,
				'message' => 'Gift Card added.'
			]);

    	// if($checkcode->count() > 0)
    	// {
    	// 	if($checkcode->first()->isused == 'yes')
    	// 	{
    	// 		return response()->json(["status"=>"400","msg"=>"Code is Already Used."]);
      //       	exit();
    	// 	}else
    	// 	{
    			// $cartid = Cmf::ipaddress();
    			// Cart::where('cust_id','=',$cartid)->update(['giftcode'=>$request->discount_coupon]);
			// 		$giftcardCondition = new CartCondition([
			// 			'name' => 'Gift Card',
			// 			'type' => 'giftcard',
			// 			'target' => 'total',
			// 			'value' => -300,
			// 			'attributes' => [
			// 				'code' => $request->discount_coupon
			// 			]
			// 		]);

			// 		cart()->condition($giftcardCondition);
			// 		usergiftcards::where('code' , $request->discount_coupon)->update(['isused'=>'yes']);

    	// 		return response()->json(["status"=>"200","msg"=>'1']);
      //       	exit();
    	// 	}
    	// }else
    	// {
    	// 	return response()->json(["status"=>"400","msg"=>"Code is Invalid."]);
      //       exit();
    	// }
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
	public function addgiftcard($price, $order_number)
	{
		usergiftcards::create([
			'order_number' => $order_number,
			'user_id' => auth()->id(),
			'price' => $price,
			'payment_status' => 'unpaid'
		]);

		return response()->json([
			'status' => true
		]);
		// $giftcard = giftcards::where('id' , $id)->get()->first();
		// $card = new usergiftcards();
		// $card->user_id = Auth::user()->id;
		// $card->gift_card_id = $id;
		// $card->code = $this->generateRandomString();
		// $card->orderid = $orderid;
		// $card->status = 1;
		// $card->payement = 'pending';
		// $card->save();
		// if($card){
    //         return response()->json(["status"=>"200","msg"=>'success']);
    //         exit();
    //     }else{
    //         return response()->json(["status"=>"400","msg"=>"2"]);
    //         exit();
    //     }
	}
	public function giftcardconfermorder(Request $request)
	{
		$data =  $request->all();

		$status = $data['STATUS'];

		// check for successful transaction
		if ($status != 'TXN_SUCCESS') {
			return redirect()->route('website.giftcard')->with('error','Payement Failed');
		}

		$order_number = $data['ORDERID'];
    $transaction_number = $data['transaction_number'];

		$userGiftCard = usergiftcards::where('order_number', $order_number)->first();

		$giftCard = giftcards::create([
			'name' => 'Gift Card Purchased ' . Str::random(3) . auth()->id(),
			'code' => 'GIFT' . auth()->id() ?? random_int(1, 999) . Str::random(6),
			'price' => $userGiftCard->price,
			'status' => 1
		]);

		$userGiftCard->update([
			'giftcard_id' => $giftCard->id,
			'payment_status' => 'paid',
			'transaction_number' => $transaction_number
		]);

		return view('website.guestthanksgiftcard', compact('order_number'));

		// $allparms =  $request->all();
		// if($allparms['STATUS'] == 'TXN_SUCCESS')
    //     {
    //     	$usergiftcard = usergiftcards::where('orderid' , $allparms['ORDERID'])->get()->first();
    //     	$card = usergiftcards::find($usergiftcard->id);
		// 	$card->status = 2;
		// 	$card->payement = 'completed';
		// 	$card->save();
		// 	$customer = DB::table('users')->where('id' , $card->user_id)->get()->first();
    //     	auth()->attempt(['email'=>$customer->email,'password'=>$customer->show_password]);
		// 	Mail::send('emails.giftcard', ['card' => $card], function($message) use($request){
	  //             $message->to(Auth::user()->email);
	  //             $message->subject('Purchase Gift Card');
	  //       });
	  //       $orderid = $allparms['ORDERID'];
		// 	return view('website.guestthanksgiftcard',compact('orderid'));
    //     }else{
    //     	return redirect()->route('website.giftcard')->with('error','Payement Failed');
    //     }
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
			// $orders = Order::leftJoin('products','products.id','=','orders.prod_id')
			//         ->select('products.*','orders.qty as OrderQty','orders.orderid as ordernumber','orders.amount as orderAmt','orders.status as orderStatus','orders.id as orderid')
			//         ->where('orders.cust_id','=',$cust_id)
			//         ->orderBy('orders.id','desc')
			//         ->groupby('orders.orderid')
			//         ->get();
			$orders = Order::with('items')->where( 'user_id', auth()->id() )->get();
			return view('website.user.orderHistory', compact('orders'));
    }
    public function orderdetail($id)
    {
			$order = Order::with('user', 'address', 'items.product')->where('order_number', $id)->first();
    	// $orders = Order::leftJoin('products','products.id','=','orders.prod_id')
      //           ->select('products.*','orders.qty as OrderQty','orders.orderid as ordernumber','orders.amount as orderAmt','orders.status as orderStatus','orders.id as orderid')
      //           ->orderBy('orders.id','desc')
      //           ->where('orders.orderid' , $id)
      //           ->get();
    	return view('website.user.orderdetail',compact('order'));
    	
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
							event(new PasswordReset($users));
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