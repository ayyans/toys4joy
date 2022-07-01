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
use App\Models\User;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\CustomerAddress;
use App\Models\CardInfo;
use App\Models\Coupon;
use App\Models\sibblings;
use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Stripe;
use Session;
use Auth;
use DB;

class UserController extends Controller
{
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
}