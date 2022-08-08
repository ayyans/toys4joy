<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusChanged;
use App\Exports\InventoryReportExport;
use App\Exports\SalesReportExport;
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
use App\Models\Customer;
use App\Models\Coupon;
use App\Models\giftcards;
use App\Models\adminsmsnumbers;
use App\Models\Order;
use App\Models\ReturnRequest;
use App\Models\User;
use App\Models\requiredproducts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SettingsController extends Controller
{
	public function smssettings()
    {
        $data = adminsmsnumbers::orderBy('id','desc')->get();
        return view('admin.settigns.smssettings',compact('data'));
    }
    public function smsnumberprocess(Request $request)
    {
        $banner = new adminsmsnumbers();
        $banner->number = $request->mobilenumber;
        $banner->save();
        return back()->with('success','Number Added Successfully!');
    }
    public function deletesms(Request $request){
        $catid = decrypt($request->id);
        $deletecust = adminsmsnumbers::where('id','=',$catid)->delete();
        if($deletecust==true){
            return back()->with('success','Number deleted SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

}