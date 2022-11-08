<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusChanged;
use App\Exports\AbandonedOrdersReportExport;
use App\Exports\CustomersReportExport;
use App\Exports\GeneratedGiftCardsReportExport;
use App\Exports\GuestsReportExport;
use App\Exports\InventoryReportExport;
use App\Exports\POSItemsSoldReportExport;
use App\Exports\POSRefundsReportExport;
use App\Exports\POSSalesReportExport;
use App\Exports\ReturnedOrderItemsReportExport;
use App\Exports\ReturnedOrdersReportExport;
use App\Exports\SalesReportExport;
use App\Exports\UsedGiftCardsReportExport;
use App\Helpers\Cmf;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\AttrValue;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\GuestOrder;
use App\Models\Customer;
use App\Models\Coupon;
use App\Models\giftcards;
use App\Models\homepagebanners;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\POSInvoice;
use App\Models\ReturnRequest;
use App\Models\User;
use App\Models\requiredproducts;
use App\Models\Setting;
use App\Models\usergiftcards;
use Bavix\Wallet\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class AdminController extends Controller
{
    //
    public function dashboard(){
        // orders
        $orders = Order::whereIn('order_status', ['delivered', 'cancelled'])->get();

        // delivered orders count
        $deliveredOrdersCount = $orders->where('order_status', 'delivered')->count();

        // cancelled orders count
        $cancelledOrdersCount = $orders->where('order_status', 'cancelled')->count();

        // users
        $users = User::all();

        // verified users
        $verifiedUsersCount = $users->where('status', 2)->count();

        // unverified users
        $unverifiedUsersCount = $users->where('status', 1)->count();

        return view('admin.dashboard', compact('deliveredOrdersCount', 'cancelledOrdersCount', 'verifiedUsersCount', 'unverifiedUsersCount'));
    }
    public function productrequest()
    {
        $data = requiredproducts::all();
        return view('admin.productrequest',compact('data'));
    }
    public function homepagebanners()
    {
        $data = homepagebanners::orderBy('id','desc')->get();
        return view('admin.settigns.homepagebanners',compact('data'));
    }
    public function homepagebannerssubmit(Request $request)
    {
        $banner = new homepagebanners();
        if ($request->hasFile('image')) {
            $banner->image=Cmf::sendimagetodirectory($request->image);
        }
        $banner->position = $request->position;
        $banner->url = $request->url ?? '';
        $banner->status = 1;
        $banner->save();
        return back()->with('success','Banner Added SuccessFull!');
    }
    public function homepagebannersedit(Request $request)
    {
        $banner = homepagebanners::find($request->id);
        if ($request->hasFile('image')) {
            $banner->image=Cmf::sendimagetodirectory($request->image);
        }
        $banner->position = $request->position;
        $banner->url = $request->url ?? '';
        $banner->save();
        return back()->with('success','Banner Added SuccessFull!');
    }
    public function deactivatebanner(Request $request){
        $id = decrypt($request->id);
        $deactivate = homepagebanners::where('id','=',$id)->update([
            'status'=>'1'
        ]);
        if($deactivate==true){
            return back()->with('success','Banner  deactivated successfull');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }
    public function activatebanner(Request $request){
        $id = decrypt($request->id);
        $activate = homepagebanners::where('id','=',$id)->update([
            'status'=>'2'
        ]);
        if($activate==true){
            return back()->with('success','Banner activated successfull');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    public function deletebanner(Request $request){
        $catid = decrypt($request->id);
        $deletecust = homepagebanners::where('id','=',$catid)->delete();
        if($deletecust==true){
            return back()->with('success','Banner deleted SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }







    public function giftcards()
    {
        $giftcard = giftcards::orderBy('id','desc')->get();
        return view('admin.giftcards',compact('giftcard'));
    }

    public function addgiftcardsubmit(Request $request)
    {
        $giftCard = giftcards::create([
            'name' => $request->coupon_title,
            'price' => $request->price,
            'code' => $request->coupon_code,
            'status' => $request->status ?? 0
        ]);
        // giftcard 100 points reward functionality
        // withdraw 100 points if it's reward
        if ($request->type == 'reward') {
            User::find($request->user_id)->withdraw($request->points, ["description" => $giftCard->name . " Generated"]);
            // add usergiftcards entry for the record
            usergiftcards::create([
                'order_number' => rand(123456789, 987654321),
                'user_id' => $request->user_id,
                'giftcard_id' => $giftCard->id,
                'price' => $giftCard->price,
                'payment_status' => 'paid',
                'transaction_number' => null
            ]);
        }
        // if it's ajax request
        if ($request->ajax()) {
            return response()->json([
                'status' => true
            ]);
        }
        return back()->with('success','Gift Card Added SuccessFull!');

    }
    public function activategiftcards(giftcards $giftcard){
        $activate = $giftcard->update([
            'status' => 1
        ]);
        if($activate){
            return back()->with('success','Gift Card Activated');
        }else{
            return back()->with('error','something went wrong');
        }
    }

    // deactivate giftcard 

    public function deactivategiftcards(giftcards $giftcard){
        $deactivate = $giftcard->update([
            'status' => 0
        ]);
        if($deactivate){
            return back()->with('success','Gift Card Deactivated');
        }else{
            return back()->with('error','something went wrong');
        }
    }

    public function deletegiftcards(giftcards $giftcard) {
        $delete = $giftcard->delete();
        if($delete){
            return back()->with('success','Gift Card Deleted');
        }else{
            return back()->with('error','something went wrong');
        }
    }
    // customer details

    public function customer(){
        $customers = User::where('type' , 'customer')->get();
        return view('admin.customer', compact('customers'));
    }


    // customer activate and deactivate

    public function activateCustomer(Request $request){
        $catid = decrypt($request->id);
        $activate = DB::table('users')->where('id','=',$catid)->update([
            'status'=>'2'
        ]);
        if($activate==true){
            return back()->with('success','customer activated SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    // customer deactivate

    public function deactivateCustomer(Request $request){
        $catid = decrypt($request->id);
        $deactivate = DB::table('users')->where('id','=',$catid)->update([
            'status'=>'3'
        ]);
        if($deactivate==true){
            return back()->with('success','customer deactivated SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    // customer delete

    public function deleteCust(Request $request){
        $catid = decrypt($request->id);
        $deletecust = Customer::where('id','=',$catid)->delete();
        if($deletecust==true){
            return back()->with('success','Customer deleted SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    public function shorten_url($text)
    {
        $words = explode('-', $text);
        $five_words = array_slice($words,0,12);
        $String_of_five_words = implode('-',$five_words)."\n";

        $String_of_five_words = preg_replace('~[^\pL\d]+~u', '-', $String_of_five_words);
        $String_of_five_words = iconv('utf-8', 'us-ascii//TRANSLIT', $String_of_five_words);
        $String_of_five_words = preg_replace('~[^-\w]+~', '', $String_of_five_words);
        $String_of_five_words = trim($String_of_five_words, '-');
        $String_of_five_words = preg_replace('~-+~', '-', $String_of_five_words);
        $String_of_five_words = strtolower($String_of_five_words);
        if (empty($String_of_five_words)) {
          return 'n-a';
        }
        return $String_of_five_words;
    }

    public function categories(){
        $categories = Category::orderBy('id','desc')->get();
        return view('admin.categories',compact('categories'));
    }

    public function addcategories(){
        return view('admin.add-categories');
    }

    public function cateProcess(Request $request){
        $exist_ct = Category::where('category_name','=',$request->catname)->count();
        if($exist_ct>0){
            return back()->with('category already exist');
        }else{

            $catBanner = time().'.'.$request->file('catBanner')->getClientOriginalName();   
             $request->catBanner->move(public_path('uploads'), $catBanner);

             $catIcon = time().'.'.$request->file('catIcon')->getClientOriginalName();
             $request->catIcon->move(public_path('uploads'), $catIcon);

             $category = new Category;
             $category->category_name=$request->catname;
             $category->url = $this->shorten_url($request->catname);
             $category->category_type=$request->catType;
             $category->cat_banner=$catBanner;
             $category->cat_icon=$catIcon;
             $category->save();
             if($category==true){
                 return back()->with('success','category added successfull');
                 exit();
             }else{
                return back()->with('error','something went wrong');
                exit();
             }


        }
    }

    // activate category

    public function activateCategories(Request $request){
        $catid = decrypt($request->id);
        $activate = Category::where('id','=',$catid)->update([
            'status'=>'2'
        ]);
        if($activate==true){
            return back()->with('success','category activated SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    // deactivate categories

    public function deactivateCategories(Request $request){
        $catid = decrypt($request->id);
        $deactivate = Category::where('id','=',$catid)->update([
            'status'=>'1'
        ]);
        if($deactivate==true){
            return back()->with('success','category deactivated SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    // delete category 

    public function deleteCat(Request $request){
        $catid = decrypt($request->id);
        $deletecat = Category::where('id','=',$catid)->delete();
        if($deletecat==true){
            return back()->with('success','category deleted SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }


    // subcategory 

    public function subcategories(){
        $subcategories = SubCategory::leftJoin('categories','categories.id','=','sub_categories.parent_cat')
        ->select('sub_categories.*','category_name')
        ->orderBy('sub_categories.id','desc')->get();
        $categories = Category::where('status','=','2')->orderBy('id','desc')->get();
        return view('admin.subcategories',compact('subcategories','categories'));
    }

    public function addSubCat(){
        $categories = Category::where('status','=','2')->orderBy('id','desc')->get();
        return view('admin.add-subcategory',compact('categories'));
    }

    public function getsubcategories($id)
    {
        $data = SubCategory::where('parent_cat' , $id)->where('status' , 2)->get();

        echo '<option value="">Select Sub Category</option>';
        foreach ($data as $r) {
            echo '<option value="'.$r->id.'"> '.$r->subcat_name.'</option>';
        }
        
    }


    // add sub category

    public function SubcateProcess(Request $request){
        $exist_ct = SubCategory::where('subcat_name','=',$request->catname)->count();
        if($exist_ct>0){
            return back()->with('Sub-category already exist');
        }else{            
             $category = new SubCategory;
             $category->subcat_name=$request->catname;
             $category->parent_cat=$request->parent_cat;
             $category->url = $this->shorten_url($request->catname);       
             $category->save();
             if($category==true){
                 return back()->with('success','Sub-category added successfull');
                 exit();
             }else{
                return back()->with('error','something went wrong');
                exit();
             }
        }
    }



      // activate subcategory

      public function activateSubCategories(Request $request){
        $catid = decrypt($request->id);
        $activate = SubCategory::where('id','=',$catid)->update([
            'status'=>'2'
        ]);
        if($activate==true){
            return back()->with('success','sub-category activated SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    // deactivate subcategories

    public function deactivateSubCategories(Request $request){
        $catid = decrypt($request->id);
        $deactivate = SubCategory::where('id','=',$catid)->update([
            'status'=>'1'
        ]);
        if($deactivate==true){
            return back()->with('success','sub-category deactivated SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    // delete subcategory 

    public function deleteSubCat(Request $request){
        $catid = decrypt($request->id);
        $deletecat = SubCategory::where('id','=',$catid)->delete();
        if($deletecat==true){
            return back()->with('success','subcategory deleted SuccessFull!');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

public function listCategories(){
    $categories = Category::where('status','=','2')->orderBy('id','desc')->get();
    return $categories;
}

// brands

public function brands(){
    $brands = Brand::orderBy('id','desc')->get();
    return view('admin.brands',compact('brands'));
}
// add brands
public function BrandProcess(Request $request){
    $exist_ct = Brand::where('brand_name','=',$request->catname)->count();
    if($exist_ct>0){
        return back()->with('brand already exist');
    }else{            
         $category = new Brand;
         $category->brand_name=$request->brandname;
         if ($request->hasFile('brandIcon')) {
            $category->logo=Cmf::sendimagetodirectory($request->brandIcon);
         }
         $category->status=2;
         $category->save();
         if($category==true){
             return back()->with('success','Brand Added Successfully');
             exit();
         }else{
            return back()->with('error','something went wrong');
            exit();
         }
    }
}
public function updatebrand(Request $request)
{
    $category = Brand::find($request->id);
    $category->brand_name=$request->brandname;
    if ($request->hasFile('brandIcon')) {
        $category->logo=Cmf::sendimagetodirectory($request->brandIcon);
    }
    $category->save();
    return back()->with('success','Brand Updated Successfully');
}

  // activate brands

  public function activateBrand(Request $request){
    $catid = decrypt($request->id);
    $activate = Brand::where('id','=',$catid)->update([
        'status'=>'2'
    ]);
    if($activate==true){
        return back()->with('success','Brands activated SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// deactivate brands

public function deactivateBrand(Request $request){
    $catid = decrypt($request->id);
    $deactivate = Brand::where('id','=',$catid)->update([
        'status'=>'1'
    ]);
    if($deactivate==true){
        return back()->with('success','brand deactivated SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// delete brands 

public function deleteBrands(Request $request){
    $catid = decrypt($request->id);
    $deletecat = Brand::where('id','=',$catid)->delete();
    if($deletecat==true){
        return back()->with('success','brands deleted SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}


// // attribute

// public function atribute(){
//     $attr = Attribute::orderBy('id','desc')->get();
//     $attrVal = AttrValue::leftJoin('attributes','attributes.id','=','attr_values.attr_id')
//             ->select('attr_values.*','attributes.id as attrID','attribute_name')
//             ->orderBy('id','desc')
//             ->get();
//     $attributs = Attribute::where('status','=','2')->orderBy('id','desc')->get();
//     return view('admin.attribute',compact('attr','attrVal','attributs'));
// }

// public function addattr(Request $request){
//     $exist_attr = Attribute::where('attribute_name','=',$request->attrname)->count();
//     if($exist_attr>0){
//         return back()->with('error','attribute already exist');
//         exit();
//     }else{
//         $attribute = new Attribute;
//         $attribute->attribute_name=$request->attrname;
//         $attribute->save();
//         if($attribute==true){
//             return back()->with('success','attribute added successfull');
//             exit();
//         }else{
//             return back()->with('error','something went wrong');
//             exit();
//         }
//     }
// }

// activate attribute

 

//   public function activateAttr(Request $request){
//     $catid = decrypt($request->id);
//     $activate = Attribute::where('id','=',$catid)->update([
//         'status'=>'2'
//     ]);
//     if($activate==true){
//         return back()->with('success','Attribute activated SuccessFull!');
//         exit();
//     }else{
//         return back()->with('error','something went wrong');
//         exit();
//     }
// }

// // deactivate attribute

// public function deactivatAttr(Request $request){
//     $catid = decrypt($request->id);
//     $deactivate = Attribute::where('id','=',$catid)->update([
//         'status'=>'1'
//     ]);
//     if($deactivate==true){
//         return back()->with('success','Attribute deactivated SuccessFull!');
//         exit();
//     }else{
//         return back()->with('error','something went wrong');
//         exit();
//     }
// }

// // delete attribute 

// public function deleteAttr(Request $request){
//     $catid = decrypt($request->id);
//     $deleteattr = Attribute::where('id','=',$catid)->delete();
//     if($deleteattr==true){
//         return back()->with('success','attribute deleted SuccessFull!');
//         exit();
//     }else{
//         return back()->with('error','something went wrong');
//         exit();
//     }
// }



// attribute value

// public function addattrVal(Request $request){
//     $exist_attr = AttrValue::where('attr_value','=',$request->attrval)->count();
//     if($exist_attr>0){
//         return back()->with('error','attribute value already exist');
//         exit();
//     }else{
//         $attribute = new AttrValue;
//         $attribute->attr_id=$request->attrname;
//         $attribute->attr_value=$request->attrval;
//         $attribute->save();
//         if($attribute==true){
//             return back()->with('success','attribute value added successfull');
//             exit();
//         }else{
//             return back()->with('error','something went wrong');
//             exit();
//         }
//     }
// }



// activate attribute value

 

// public function activateAttrVal(Request $request){
//     $catid = decrypt($request->id);
//     $activate = AttrValue::where('id','=',$catid)->update([
//         'status'=>'2'
//     ]);
//     if($activate==true){
//         return back()->with('success','Attribute value activated SuccessFull!');
//         exit();
//     }else{
//         return back()->with('error','something went wrong');
//         exit();
//     }
// }

// // deactivate attribute value

// public function deactivatAttrVal(Request $request){
//     $catid = decrypt($request->id);
//     $deactivate = AttrValue::where('id','=',$catid)->update([
//         'status'=>'1'
//     ]);
//     if($deactivate==true){
//         return back()->with('success','Attribute value deactivated SuccessFull!');
//         exit();
//     }else{
//         return back()->with('error','something went wrong');
//         exit();
//     }
// }

// delete attribute value 

// public function deleteAttrVal(Request $request){
//     $catid = decrypt($request->id);
//     $deleteattr = AttrValue::where('id','=',$catid)->delete();
//     if($deleteattr==true){
//         return back()->with('success','attribute value deleted SuccessFull!');
//         exit();
//     }else{
//         return back()->with('error','something went wrong');
//         exit();
//     }
// }

    public function pointOfSale() {
        return view('admin.point-of-sale');
    }

    public function POSSalesReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $invoices = POSInvoice::where('type', 'sale')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->get()
            ->map(function($product) {
                return [
                    'date' => $product->created_at->toDateString(),
                    'invoice_number' => $product->invoice_number,
                    'total' => $product->total,
                    'type' => strtoupper($product->method),
                    'quantity' => $product->quantity,
                ];
            })
            ->sortByDesc('date');

        // delivered orders count
        $numberOfSales = $invoices->count();

        // Total revenue
        $salesTotal = $invoices->reduce(function($total, $current) {
            return $total + $current['total'];
        }, 0);

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new POSSalesReportExport($invoices, $numberOfSales, $salesTotal), 'pos-sales-report.xlsx');
        }
        return view('admin.pos.sales-report', compact('invoices', 'numberOfSales', 'salesTotal'));
    }

    public function POSRefundReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $invoices = POSInvoice::where('type', 'refund')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->get()
            ->map(function($product) {
                return [
                    'date' => $product->created_at->toDateString(),
                    'invoice_number' => $product->invoice_number,
                    'total' => abs($product->total),
                    'type' => strtoupper($product->method),
                    'quantity' => abs($product->quantity),
                ];
            })
            ->sortByDesc('date');

        // delivered orders count
        $numberOfRefunds = $invoices->count();

        // Total revenue
        $refundsTotal = $invoices->reduce(function($total, $current) {
            return $total + $current['total'];
        }, 0);

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new POSRefundsReportExport($invoices, $numberOfRefunds, $refundsTotal), 'pos-refunds-report.xlsx');
        }
        return view('admin.pos.refund-report', compact('invoices', 'numberOfRefunds', 'refundsTotal'));
    }

    public function POSItemsSoldReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $invoices = POSInvoice::with('products.product')->where('type', 'sale')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->get()
            ->map(function($invoice) {
                return [
                    'date' => $invoice->created_at->toDateString(),
                    'invoice_number' => $invoice->invoice_number,
                    'quantity' => $invoice->quantity,
                    'items' => $invoice->products->pluck('product.code')->join(', ')
                ];
            })
            ->sortByDesc('date');

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new POSItemsSoldReportExport($invoices), 'items-sold-report.xlsx');
        }
        return view('admin.pos.items-sold-report', compact('invoices'));
    }

    // products

    public function products(){
        $products = Product::with('brand')->latest()->get();
        return view('admin.products',compact('products'));
    }

    public function bulkUploadProducts() {
        return view('admin.bulk-upload-products');
    }

    public function storeBulkUploadProducts(Request $request) {
        $failures = [];
        try {
            Excel::import(new ProductsImport, $request->file);
        } catch (ValidationException  $e) {
            $failures = $e->failures();
        }
        return back()->with('success', 'Products Imported Successfully')->with('failures', $failures);
    }

    public function listBrands(){
        $brands = Brand::where('status','=','2')->orderBy('id','desc')->get();
        return $brands;
    }
    public function listAttr(){
        $attribute = Attribute::where('status','=','2')->orderBy('id','desc')->get();
        return $attribute;
    }
    public function addproducts(){
        $categories = $this->listCategories();
        $brands = $this->listBrands();
        $attributes = $this->listAttr();
        $product = new Product;
        return view('admin.add-products',compact('categories','brands','attributes','product'));
    }

    // list atribute value 

    public function prodAttrVal(Request $request){
        $attrval = AttrValue::leftJoin('attributes','attributes.id','=','attr_values.attr_id')                         
                    ->select('attr_values.*','attributes.id as attrID','attribute_name')
                    ->where('attr_values.attr_id','=',$request->attr)
                    ->where('attr_values.status','=','2')
                    ->orderBy('id','desc')
                    ->get();
        if($attrval==true){
            return response()->json(["status"=>"200","msg"=>$attrval]);
            exit();
        }else{
            return response()->json(["status"=>"400","msg"=>"2"]);
            exit();
        }
    }


    // add product process


    public function addProductProcess(Request $request){
        $existprod = Product::where('title','=',$request->prodname)->count();
        if($existprod>0){
            return back()->with('error','product already exist');
            exit();
        }else{ 
                      
            $thumbnail_img = time().'.'.$request->file('thumbnail_img')->getClientOriginalName();   
            $request->thumbnail_img->move(public_path('products'), $thumbnail_img);
            
                if($request->featured==''){
                    $featured='0';
                }else{
                    $featured = $request->featured;
                }

                if($request->todays_deal==''){
                    $todaysdeal='0';
                }else{
                    $todaysdeal=$request->todays_deal;
                }

            $addproduct = new Product;
            $addproduct->title=$request->prodname;
            $addproduct->category_id=$request->category_id;
            $addproduct->linked_categories=$request->linked_categories;
            $addproduct->brand_id=$request->brand_id;
            $addproduct->unit=$request->unit;
            $addproduct->min_qty=$request->min_qty;
            $addproduct->sub_cat=$request->sub_cat;
            $addproduct->barcode=$request->barcode;
            $addproduct->featured_img=$thumbnail_img;
            $addproduct->unit_price=$request->unit_price;
            $addproduct->discount=$request->discount;
            $addproduct->price_discount_unit=$request->discount_type;
            $addproduct->url = $this->shorten_url($request->prodname);
            $addproduct->new_arrival=$request->new_arrival;
            $addproduct->best_seller=$request->best_seller;
            $addproduct->best_offer=$request->best_offer;
            $addproduct->qty=$request->current_qty;
            $addproduct->sku=$request->sku;
            $addproduct->short_desc=$request->shortdescription;
            $addproduct->long_desc=$request->longdescription;
            $addproduct->featured_status=$featured;
            $addproduct->todays_deal=$todaysdeal;
            $addproduct->shiping_time=$request->est_shipping_days;
            $addproduct->tax=$request->tax;
            $addproduct->tax_unit=$request->tax_type;
            $addproduct->vat=$request->vat;
            $addproduct->vat_unit=$request->vat_type;
            $addproduct->recommended_age=$request->recommended_age;
            $addproduct->save();
            $lastid = $addproduct->id;
                $galler_size = count($request->photos);
            for($j=0;$j<$galler_size;$j++){
                $gallery = time().'.'.$request->file('photos')[$j]->getClientOriginalName();   
                $request->photos[$j]->move(public_path('products'), $gallery);
                $addProductImage = new ProductImage;
                $addProductImage->gallery_img=$gallery;
                $addProductImage->prod_id=$lastid;
                $addProductImage->save();
            }

            if($addproduct==true){
                return back()->with('success','product successfully added');
                exit();
            }else{
                return back()->with('error','something went wrong');
                exit();
            }

        }

    }


    // activate product

 

public function activateProd(Request $request){
    $catid = decrypt($request->id);
    $activate = Product::where('id','=',$catid)->update([
        'status'=>'2'
    ]);
    if($activate==true){
        return back()->with('success','Product activated SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// deactivate product

public function deactivateprod(Request $request){
    $catid = decrypt($request->id);
    $deactivate = Product::where('id','=',$catid)->update([
        'status'=>'1'
    ]);
    if($deactivate==true){
        return back()->with('success','Product deactivated SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// delete product 

public function deleteprod(Request $request){
    $catid = decrypt($request->id);
    $deleteattr = Product::where('id','=',$catid)->delete();
    if($deleteattr==true){
        return back()->with('success','product deleted SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}


// guest orders 

public function guestOrders(){
    // $orders = GuestOrder::leftJoin('products','products.id','=','guest_orders.prod_id')
    //           ->select('products.title as productName','featured_img','products.unit_price as prod_price','guest_orders.*')  
    //           ->groupby('guest_orders.order_id')
    //           ->orderBy('guest_orders.id','desc')->get();
    $orders = Order::whereNull('user_id')->where('additional_details->is_abandoned', false)->get();
    // new orders
    $newOrders = Order::whereNull('user_id')->where('additional_details->is_new', true)->update([
        'additional_details->is_new' => false
    ]);
    return view('admin.guest-order',compact('orders'));
}

// confirm guest orders


public function confirmGuestOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = GuestOrder::where('id','=',$orderid)->update([
        'status'=>'2'
    ]);
    $order = GuestOrder::where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Confirmed!',
        'description' => 'Your order has confirmed.',
        'order_number' => $orderid,
        'to' => $order->cust_name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Confirmed',
        'email' => $order->cust_email
    ];
    event(new OrderStatusChanged($data));
    if($update_orders==true){
        return back()->with('success','orders is confirmed');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}


// shipped orderss

public function shippedGuestOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = GuestOrder::where('id','=',$orderid)->update([
        'status'=>'3'
    ]);
    $order = GuestOrder::where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Shipped!',
        'description' => 'Your order is shipped.',
        'order_number' => $orderid,
        'to' => $order->cust_name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Shipped',
        'email' => $order->cust_email
    ];
    event(new OrderStatusChanged($data));
    if($update_orders==true){
        return back()->with('success','orders is shipped');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// cancelled orders

public function cancelledGuestOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = GuestOrder::where('id','=',$orderid)->update([
        'status'=>'4'
    ]);
    $order = GuestOrder::where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Cancelled!',
        'description' => 'Your order is cancelled.',
        'order_number' => $orderid,
        'to' => $order->cust_name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Cancelled',
        'email' => $order->cust_email
    ];
    event(new OrderStatusChanged($data));
    if($update_orders==true){
        return back()->with('success','orders is cancelled');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}


// delivered guest orders

public function deliveredGuestOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = GuestOrder::where('id','=',$orderid)->update([
        'status'=>'5'
    ]);
    $order = GuestOrder::where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Delivered!',
        'description' => 'Your order is delivered.',
        'order_number' => $orderid,
        'to' => $order->cust_name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Delivered',
        'email' => $order->cust_email
    ];
    event(new OrderStatusChanged($data));
    if($update_orders==true){
        return back()->with('success','orders is delivered');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}


// guest order details 

public function guestOrdersDetails(Request $request){
    $order_id = decrypt($request->id);
    // $orders = GuestOrder::leftJoin('products','products.id','=','guest_orders.prod_id')
    //           ->select('products.title as productName','featured_img','products.unit_price as prod_price','guest_orders.*')
    //           ->where('guest_orders.id','=',$orderid)  
    //           ->first();
    $order = Order::with(['user', 'items.product'])->where('id', $order_id)->first();
    return view('admin.guestorderDetails', compact('order'));
}


// coupon management 


public function coupon(){
    $coupons = Coupon::orderBy('id','desc')->get();
    return view('admin.coupons',compact('coupons'));
}

// add coupon 

public function addcouponProcess(Request $request){
    $coupons = new Coupon;
    $coupons->coupontype=$request->coupon_type;
    $coupons->coupon_title=$request->coupon_title;
    $coupons->coupon_code=$request->coupon_code;
    $coupons->exp_date=$request->validupto;
    $coupons->offer=$request->offer;
    $coupons->desc=$request->desc;
    $coupons->status=0;
    $coupons->save();
    if($coupons==true){
        return back()->with('success','coupon created successFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }

}

// coupon activate

public function activateCoupon(Request $request){
    $id = decrypt($request->id);
    $activate = Coupon::where('id','=',$id)->update([
        'status'=>'1'
    ]);
    if($activate==true){
        return back()->with('success','coupon activated successfull');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// deactivate coupon 

public function deactivateCoupon(Request $request){
    $id = decrypt($request->id);
    $deactivate = Coupon::where('id','=',$id)->update([
        'status'=>'0'
    ]);
    if($deactivate==true){
        return back()->with('success','coupon deactivated successfull');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// delete coupon 

public function deleteCoupon(Request $request){
    $id = decrypt($request->id);
    $deleted = Coupon::where('id','=',$id)->delete();
    if($deleted==true){
        return back()->with('success','coupon deleted successfull');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}



// edit categories

public function update_categories(Request $request){
    $id = decrypt($request->id);
    $cat = Category::where('id','=',$id)->first();
    return view('admin.update_cat',compact('cat'));
}


public function edit_category_process(Request $request){

            if($request->hasFile('catBanner') && $request->hasFile('catIcon')){
            $catBanner = time().'.'.$request->file('catBanner')->getClientOriginalName();   
             $request->catBanner->move(public_path('uploads'), $catBanner);

             $catIcon = time().'.'.$request->file('catIcon')->getClientOriginalName();
             $request->catIcon->move(public_path('uploads'), $catIcon); 

             $update_cat = Category::where('id','=',$request->catid)->update([
                 'category_name'=>$request->catname,
                 'category_type'=>$request->catType,
                 'cat_banner'=>$catBanner,
                 'cat_icon'=>$catIcon
             ]);

            }else if($request->hasFile('catIcon')){
             $catIcon = time().'.'.$request->file('catIcon')->getClientOriginalName();
             $request->catIcon->move(public_path('uploads'), $catIcon);

             $update_cat = Category::where('id','=',$request->catid)->update([
                'category_name'=>$request->catname,
                'category_type'=>$request->catType,                
                'cat_icon'=>$catIcon
            ]);

            }else if($request->hasFile('catBanner')){
                $catBanner = time().'.'.$request->file('catBanner')->getClientOriginalName();   
             $request->catBanner->move(public_path('uploads'), $catBanner);

             $update_cat = Category::where('id','=',$request->catid)->update([
                 'category_name'=>$request->catname,
                 'category_type'=>$request->catType,
                 'cat_banner'=>$catBanner                 
             ]);
            }else{
                $update_cat = Category::where('id','=',$request->catid)->update([
                    'category_name'=>$request->catname,
                    'category_type'=>$request->catType                                    
                ]);
            }
             

             if($update_cat==true){
                 return back()->with('success','category updated successfull');
                 exit();
             }else{
                return back()->with('error','something went wrong');
                exit();
             }

}

// order details status change

public function orderStatus(Request $request){
    $order_status = Order::where('id', $request->id)->update([
        'order_status' => $request->status
    ]);
    if($order_status==true){
        return response()->json('1');
        exit();
    }else{
        return response()->json('2');
        exit();
    }
}

public function returnItems(Order $order) {
    $order = $order->load('items.product');
    $discountPercentage = $order->subtotal > 0 ? ($order->discount / $order->subtotal) * 100 : 0;
    return view('admin.return_items', compact('order', 'discountPercentage'));
}

public function returnItemProceed(Order $order, OrderItem $item) {
    $discountPercentage = ($order->discount / $order->subtotal) * 100;
    $itemPrice = reduceByPercentage($item->total_amount, $discountPercentage);
    $discount = $item->total_amount - $itemPrice;
    DB::beginTransaction();
    // change item status to returned
    $item->update([
        'status' => 'returned'
    ]);
    // updating order parameters
    $itemOriginalPrice = ($item->price - $item->discount) * $item->quantity;
    $order->update([
        'subtotal' => $order->subtotal - $itemOriginalPrice,
        'discount' => $order->discount - $discount,
        'total_amount' => $order->total_amount - $itemPrice
    ]);
    // reduce points and test with discounted order
    $item->product()->increment('qty', $item->quantity);
    // return points
    if ($order->user_id) {
        $qarInPoints = Setting::where('name', 'qar_in_points')->value('value') ?? 2;
        $rewardPoints = round($itemPrice * $qarInPoints);
        $orderNumber = $order->order_number;
        $itemID = $item->id;
        $order->user->withdraw($rewardPoints, ['description' => "Order #$orderNumber: Cancelled reward points on Order Item #$itemID return"]);
    }
    DB::commit();
    return back()->with('success', 'Item successfully returned');
}


// logged in user orders

public function custOrders(){
    $orders = Order::with(['user', 'address'])
        ->whereNotNull('user_id')
        ->where('is_wishlist', false)
        ->where('additional_details->is_abandoned', false)
        ->get();
    // mark new orders is_new to false
    Order::whereNotNull('user_id')->where('is_wishlist', false)->where('additional_details->is_new', true)->update([
        'additional_details->is_new' => false
    ]);
    return view('admin.order', compact('orders'));
}

public function wishlistorders()
{
    // $orders = Order::select(
    //         "orders.id",
    //         "orders.orderid",
    //         "orders.orderstatus",
    //         "orders.cust_id",
    //         "orders.cust_add_id",
    //         "orders.payment_id",
    //         "orders.mode",
    //         "orders.amount",
    //         "orders.status",
    //         "orders.created_at",
    //         "users.name",
    //         "users.email",
    //         "users.mobile",
    //         "customer_addresses.unit_no",
    //         "customer_addresses.building_no",
    //         "customer_addresses.zone",
    //         "customer_addresses.street",
                  
    //                     )
    //         ->where('orders.orderstatus' , '!=' , 'payementpending')
    //         ->leftJoin('users', 'orders.cust_id', '=', 'users.id')
    //         ->leftJoin('customer_addresses', 'orders.cust_add_id', '=', 'customer_addresses.id')
    //         ->groupBy('orders.orderid')
    //         ->orderby('orders.id' , 'desc')
    //         ->where('orders.ordertype' , 'wishlist')
    //         ->get();
    $orders = Order::with(['user', 'address'])
        ->whereNotNull('user_id')->where('is_wishlist', true)
        ->where('additional_details->is_abandoned', false)->get();
    // mark new orders is_new to false
    Order::whereNotNull('user_id')->where('is_wishlist', true)->where('additional_details->is_new', true)->update([
        'additional_details->is_new' => false
    ]);
    $type = 'wishlist';
    return view('admin.order',compact('orders','type'));
}

public function abandonedOrders() {
    $orders = Order::with(['user', 'address'])
        ->where('additional_details->is_abandoned', true)
        ->get();
    return view('admin.abandoned_orders', compact('orders'));
}

// confirm guest orders


public function confirmCustOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = Order::where('id','=',$orderid)->update([
        'status'=>'2'
    ]);
    $order = Order::with('customer')->where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Confirmed!',
        'description' => 'Your order has confirmed.',
        'order_number' => $order->orderid,
        'to' => $order->customer->name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Confirmed',
        'email' => $order->customer->email
    ];
    event(new OrderStatusChanged($data));
    if($update_orders==true){
        return back()->with('success','orders is confirmed');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}


// shipped orderss

public function shippedCustOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = Order::where('id','=',$orderid)->update([
        'status'=>'3'
    ]);
    $order = Order::with('customer')->where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Shipped!',
        'description' => 'Your order is shipped.',
        'order_number' => $order->orderid,
        'to' => $order->customer->name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Shipped',
        'email' => $order->customer->email
    ];
    event(new OrderStatusChanged($data));
    if($update_orders==true){
        return back()->with('success','orders is shipped');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// cancelled orders

public function cancelledCustOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = Order::where('id','=',$orderid)->update([
        'status'=>'4'
    ]);
    $order = Order::with('customer')->where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Cancelled!',
        'description' => 'Your order is cancelled.',
        'order_number' => $order->orderid,
        'to' => $order->customer->name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Cancelled',
        'email' => $order->customer->email
    ];
    event(new OrderStatusChanged($data));
    if($update_orders==true){
        return back()->with('success','orders is cancelled');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}


// delivered customer orders

public function deliveredCustOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = Order::where('id','=',$orderid)->update([
        'status'=>'5'
    ]);
    $order = Order::with('customer')->where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Delivered!',
        'description' => 'Your order is delivered.',
        'order_number' => $order->orderid,
        'to' => $order->customer->name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Delivered',
        'email' => $order->customer->email,
        'customer' => $order->customer,
        'total' => Order::getTotalAmount($order->orderid)
    ];
    event(new OrderStatusChanged($data));
    if($update_orders==true){
        return back()->with('success','orders is delivered');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}


public function custOrdersDetails(Request $request){
    $order_id = decrypt($request->id);
/*
    $orders = Order::leftJoin('products','products.id','=','orders.prod_id')
                ->leftJoin('users','users.id','=','orders.cust_id')
                ->leftJoin('customer_addresses','customer_addresses.id','=','orders.cust_add_id')
              ->select('products.id as product_id','products.title as productName','featured_img','products.unit_price as prod_price','orders.*','name','email','mobile','unit_no','building_no','zone','street','faddress')  
              ->where('orders.orderid','=',$orderid)->get();
    $orderdetail = Order::leftJoin('products','products.id','=','orders.prod_id')
                ->leftJoin('users','users.id','=','orders.cust_id')
                ->leftJoin('customer_addresses','customer_addresses.id','=','orders.cust_add_id')
              ->select('products.title as productName','featured_img','products.unit_price as prod_price','orders.*','name','email','mobile','unit_no','building_no','zone','street','faddress')  
              ->where('orders.orderid','=',$orderid)->first();
*/
// $order = Order::leftJoin('users','users.id','=','orders.user_id')
//                 ->leftJoin('customer_addresses','customer_addresses.id','=','orders.address_id')
//               ->select('orders.*','name','email','mobile','unit_no','building_no','zone','street','faddress','order_status as status,orders.payment_type as mode')  
//               ->where('orders.id','=',$orderid)->first();
// //leftJoin('products','products.id','=','orders.prod_id')
// $orderdetail = Order::leftJoin('order_items','order_items.order_id','=','orders.id')
//                 ->leftJoin('products','products.id','=','order_items.product_id')
//                 ->leftJoin('users','users.id','=','orders.user_id')
//                 ->leftJoin('customer_addresses','customer_addresses.id','=','orders.address_id')
//               ->select('products.id as prod_id,products.title as productName','featured_img','products.unit_price as prod_price','order_items.*')  
//               ->where('order_items.order_id','=',$orderid)->get();
    $order = Order::with(['user', 'address', 'items.product'])->where('id', $order_id)->first();
    return view('admin.orderdetails', compact('order'));
}



// customer order status

public function CustomerorderStatus(Request $request){
    $order_status = Order::where('id','=',$request->orderid)->update([
        'order_status' => $request->status
    ]);
    if($order_status==true){
        return response()->json('1');
        exit();
    }else{
        return response()->json('2');
        exit();
    }
}

public function changeOrderStatus(Request $request) {
    $order = Order::with('user')->find($request->order_id);
    // order status before updating
    $previousOrderStatus = $order->order_status;
    // updating order status
    $orderUpdated = $order->update([
        'order_status' => $request->status
    ]);
    // updating order items status
    $order->items()->where('status', '!=', 'returned')->update([
        'status' => $order->order_status
    ]);
    // setting previous order status for orderstatuschanged event
    $order->previous_order_status = $previousOrderStatus;

    // if order updated
    if ($orderUpdated) {
        event(new OrderStatusChanged($order));
    }

    if ($request->ajax()) {
        return response()->json([
            'status' => $orderUpdated
        ]);
    }

    return back();

}


// edit products

public function editproducts(Request $request){
    $prod_id = decrypt($request->id);
    $categories = $this->listCategories();
    $brands = $this->listBrands();
    $attributes = $this->listAttr();
    $products = Product::where('id','=',$prod_id)->orderBy('id','desc')->first();
    return view('admin.editproduct',compact('categories','brands','attributes','products'));
}

// edit product process

public function editProcess(Request $request){
    $prod_id = $request->prod_id;

    if($request->featured==''){
        $featured='0';
    }else{
        $featured = $request->featured;
    }

    if($request->todays_deal==''){
        $todaysdeal='0';
    }else{
        $todaysdeal=$request->todays_deal;
    }

    

 if($request->hasFile('thumbnail_img')){
    $thumbnail_img = time().'.'.$request->file('thumbnail_img')->getClientOriginalName();
    $request->thumbnail_img->move(public_path('products'), $thumbnail_img);

    $update_product = Product::where('id','=',$prod_id)->update([
        'title'=>$request->prodname,
        'category_id'=>$request->category_id,
        'brand_id'=>$request->brand_id,
        'linked_categories'=>$request->linked_categories,
        'url'=>$this->shorten_url($request->prodname),
        'unit'=>$request->unit,
        'min_qty'=>$request->min_qty,
        'sub_cat'=>$request->sub_cat,
        'barcode'=>$request->barcode,
        'featured_img'=>$thumbnail_img,
        'unit_price'=>$request->unit_price,
        'discount'=>$request->discount,
        'price_discount_unit'=>$request->discount_type,
        // 'points'=>$request->earn_point,
        'new_arrival'=>$request->new_arrival,
        'best_seller'=>$request->best_seller,
        'best_offer'=>$request->best_offer,
        'qty'=>$request->current_qty,
        'sku'=>$request->sku,
        'short_desc'=>$request->shortdescription,
        'long_desc'=>$request->longdescription,
        'featured_status'=>$featured,
        'todays_deal'=>$todaysdeal,
        'shiping_time'=>$request->est_shipping_days,
        'tax'=>$request->tax,
        'tax_unit'=>$request->tax_type,
        'vat'=>$request->vat,
        'vat_unit'=>$request->vat_type,
        'recommended_age'=>$request->recommended_age
    ]);
}else{
    $update_product = Product::where('id','=',$prod_id)->update([
        'title'=>$request->prodname,
        'category_id'=>$request->category_id,
        'brand_id'=>$request->brand_id,
        'linked_categories'=>$request->linked_categories,
        'unit'=>$request->unit,
        'min_qty'=>$request->min_qty,
        'sub_cat'=>$request->sub_cat,
        'barcode'=>$request->barcode,
        'unit_price'=>$request->unit_price,
        'discount'=>$request->discount,
        'price_discount_unit'=>$request->discount_type,
        'url'=>$this->shorten_url($request->prodname),
        'new_arrival'=>$request->new_arrival,
        'best_seller'=>$request->best_seller,
        'best_offer'=>$request->best_offer,
        'qty'=>$request->current_qty,
        'sku'=>$request->sku,
        'short_desc'=>$request->shortdescription,
        'long_desc'=>$request->longdescription,
        'featured_status'=>$featured,
        'todays_deal'=>$todaysdeal,
        'shiping_time'=>$request->est_shipping_days,
        'tax'=>$request->tax,
        'tax_unit'=>$request->tax_type,
        'vat'=>$request->vat,
        'vat_unit'=>$request->vat_type,
        'best_seller'=>$request->best_seller ?? 0,
        'new_arrival'=>$request->new_arrival ?? 0,
        'recommended_age'=>$request->recommended_age
    ]);

}
    $lastid = $prod_id;
    $galler_size = count($request->photos ?? []);
    if ($galler_size > 0) {
        ProductImage::where('prod_id', $lastid)->delete();
        for($j=0;$j<$galler_size;$j++){
            $gallery = time().'.'.$request->file('photos')[$j]->getClientOriginalName();   
            $request->photos[$j]->move(public_path('products'), $gallery);
            $addProductImage = new ProductImage;
            $addProductImage->gallery_img=$gallery;
            $addProductImage->prod_id=$lastid;
            $addProductImage->save();
        }
    }
    if($update_product==true){
        return back()->with('success','product successfully updated');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}


    public function returnRequests() {
        $returnRequests = ReturnRequest::with('user')->get();
        return view('admin.return-requests', compact('returnRequests'));
    }
    
    public function returnRequestStatus(ReturnRequest $returnRequest, $status) {
        $returnRequest->update(['status' => $status]);
        return redirect()->route('admin.return-requests.index')->with('success', 'Return request status changed!');
    }

    // Reports

    public function salesReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $products = Product::query()
            ->withSum(['deliveredOrderItems' => function($query) use ($applyFilter, $start_date, $end_date) {
                $query->when($applyFilter, function($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            }], 'quantity')
            ->havingRaw('delivered_order_items_sum_quantity > 0')
            ->get()
            ->map(function($product) {
                return [
                    'title' => $product->title,
                    'sales' => $product->delivered_order_items_sum_quantity
                ];
            })
            ->sortByDesc('sales');

        // delivered orders count
        $productsSold = $products->reduce(function($total, $current) {
            return $total + $current['sales'];
        }, 0);

        // Total revenue
        $revenueCount = Order::where('order_status', 'delivered')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->sum('total_amount');

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new SalesReportExport($products, $productsSold, $revenueCount), 'sales-report.xlsx');
        }

        return view('admin.reports.sales-report', compact('products', 'productsSold', 'revenueCount'));
    }

    public function inventoryReport(Request $request) {
        $products = Product::with('category:id,category_name', 'subCategory:id,subcat_name', 'brand:id,brand_name')
            ->where('status', 2)
            ->select('title', 'sku', 'unit_price', 'qty', 'category_id', 'sub_cat', 'brand_id', 'recommended_age', 'long_desc', 'status')
            ->get()
            ->map(function($product) {
                $product->category_id = $product->category->category_name;
                if ($product->subCategory) {
                    $product->sub_cat = $product->subCategory->subcat_name;
                }
                $product->brand_id = $product->brand->brand_name;
                $product->recommended_age = formatRecommendedAge($product->recommended_age);
                $product->long_desc = preg_replace("/<\/?[^>]+(>|$)/", "", html_entity_decode($product->long_desc));
                return $product;
            });

        // total products count
        $productsCount = $products->count();

        // total cagegories count
        $categoriesCount = Category::where('status', 2)->count();

        // total subcagegories count
        $subcategoriesCount = SubCategory::where('status', 2)->count();

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new InventoryReportExport($products, $productsCount, $categoriesCount, $subcategoriesCount), 'inventory-report.xlsx');
        }

        return view('admin.reports.inventory-report', compact('products', 'productsCount', 'categoriesCount', 'subcategoriesCount'));
    }

    public function customersReport(Request $request) {

        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $users = User::with(['deliveredOrders' => function($query) use ($applyFilter, $start_date, $end_date) {
            $query->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            });
        }, 'address', 'siblings'])
            ->withCount(['deliveredOrders' => function($query) use ($applyFilter, $start_date, $end_date) {
                $query->when($applyFilter, function($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            }])
            ->withSum(['deliveredOrders' => function($query) use ($applyFilter, $start_date, $end_date) {
                $query->when($applyFilter, function($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            }], 'total_amount')
            ->get()
            ->sortByDesc('deliveredOrders.*.created_at')
            ->map(function ($user) use ($request) {
                return [
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                    'address' => $this->formatAddress($user->address),
                    'siblings' => $request->export == true
                                    ? $this->formatSiblings($user->siblings)
                                    : $user->siblings,
                    'points' => $user->balance,
                    'total_orders' => $user->delivered_orders_count,
                    'total_amount' => $user->delivered_orders_sum_total_amount ?? 0,
                ];
            });

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new CustomersReportExport($users), 'customers-report.xlsx');
        }

        return view('admin.reports.customers-report', compact('users'));
    }

    public function guestsReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $orders = Order::whereNull('user_id')->where('order_status', 'delivered')
            ->orderByDesc('created_at')
            ->select('total_amount', 'additional_details->email as email')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->get()
            ->groupBy('email')
            ->map(function($orders, $key) {
                return [
                    'email' => $key,
                    'total_orders' => $orders->count(),
                    'total_amount' => $orders->sum('total_amount')
                ];
            });

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new GuestsReportExport($orders), 'guests-report.xlsx');
        }

        return view('admin.reports.guests-report', compact('orders'));
    }

    public function generatedGiftCardsReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $userGiftCards = usergiftcards::with('user', 'giftCard')->latest()
            ->where('payment_status', 'paid')
            ->select('user_id', 'giftcard_id', 'payment_status', 'created_at')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->get()
            ->map(function($userGiftCard) {
                return [
                    'code' => $userGiftCard->giftCard->code,
                    'name' => $userGiftCard->user_id ? $userGiftCard->user->name : 'Guest',
                    'mobile' => $userGiftCard->user_id ? $userGiftCard->user->mobile : 'N/A',
                    'type' => $userGiftCard->transaction_number ? 'Purchased' : 'Rewarded',
                    'date_generated' => $userGiftCard->created_at->format('d-m-Y')
                ];
            });

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new GeneratedGiftCardsReportExport($userGiftCards), 'generated-giftcards-report.xlsx');
        }

        return view('admin.reports.generated-giftcards-report', compact('userGiftCards'));
    }

    public function usedGiftCardsReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $giftCards = giftcards::with('user','order')
            ->whereHas('order', function($query) use ($applyFilter, $start_date, $end_date) {
                $query->when($applyFilter, function($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            })
            ->latest()
            ->select('id', 'user_id', 'order_id', 'code', 'price', 'status', 'created_at')
            ->get()
            ->map(function($giftCard) {
                return [
                    'code' => $giftCard->code,
                    'price' => $giftCard->price,
                    'name' => $giftCard->user_id ? $giftCard->user->name : $giftCard->order->additional_details['name'],
                    'mobile' => $giftCard->user_id ? $giftCard->user->mobile : $giftCard->order->additional_details['mobile'],
                    'order_number' => $giftCard->order->order_number,
                    'date_used' => $giftCard->order->created_at->format('d-m-Y')
                ];
            });

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new UsedGiftCardsReportExport($giftCards), 'used-giftcards-report.xlsx');
        }

        return view('admin.reports.used-giftcards-report', compact('giftCards'));
    }

    public function returnedOrdersReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $orders = Order::where('order_status', 'returned')
            ->orderByDesc('updated_at')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('updated_at', [$start_date, $end_date]);
            })
            ->get()
            ->map(function($order) {
                return [
                    'order_number' => $order->order_number,
                    'order_type' => $order->user_id
                        ? ($order->is_wishlist ? 'Wishlist' : 'Customer')
                        : 'Guest',
                    'payment_type' => strtoupper($order->order_type),
                    'payment_status' => $order->payment_status,
                    'total_items' => $order->items->count(),
                    'total_amount' => $order->total_amount,
                    'returned_at' => $order->updated_at
                ];
            });

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new ReturnedOrdersReportExport($orders), 'returned-orders-report.xlsx');
        }

        return view('admin.reports.returned-orders-report', compact('orders'));
    }

    public function returnOrderItemsReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $orderItems = OrderItem::with('order')
            ->where('status', 'returned')
            ->orderByDesc('updated_at')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('updated_at', [$start_date, $end_date]);
            })
            ->get()
            ->map(function($orderItem) {
                return [
                    'order_number' => $orderItem->order->order_number,
                    'order_type' => $orderItem->order->user_id
                        ? ($orderItem->order->is_wishlist ? 'Wishlist' : 'Customer')
                        : 'Guest',
                    'payment_type' => strtoupper($orderItem->order->order_type),
                    'payment_status' => $orderItem->order->payment_status,
                    'product_id' => $orderItem->product_id,
                    'quantity' => $orderItem->quantity,
                    'total_amount' => $orderItem->total_amount,
                    'returned_at' => $orderItem->updated_at
                ];
            });

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new ReturnedOrderItemsReportExport($orderItems), 'returned-order-items-report.xlsx');
        }

        return view('admin.reports.returned-order-items-report', compact('orderItems'));
    }

    public function abandonedOrdersReport(Request $request) {
        $applyFilter = $request->anyFilled('start_date', 'end_date');
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $orders = Order::where('additional_details->is_abandoned', 'true')
            ->orderByDesc('created_at')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->get()
            ->map(function($order) {
                return [
                    'order_number' => $order->order_number,
                    'order_type' => $order->user_id
                        ? ($order->is_wishlist ? 'Wishlist' : 'Customer')
                        : 'Guest',
                    'payment_type' => strtoupper($order->order_type),
                    'payment_status' => $order->payment_status,
                    'total_items' => $order->items->count(),
                    'total_amount' => $order->total_amount,
                    'abandoned_at' => $order->created_at
                ];
            });

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new AbandonedOrdersReportExport($orders), 'abandoned-orders-report.xlsx');
        }

        return view('admin.reports.abandoned-orders-report', compact('orders'));
    }

    public function bulkupload()
    {
        return view('admin.reports.bulkupload');
    }
    public function bulkupdateprocess(Request $request)
    {
        $sheet = Excel::toCollection(null, $request->file('file'))->first();
        $selectedProductsSKU = $sheet->pluck(0);
        $products = Product::all();
        $selectedProducts = $products->whereIn('sku', $selectedProductsSKU);
        $otherProducts = $products->whereNotIn('sku', $selectedProductsSKU);
        // Selected Products
        foreach ($sheet as $row) {
            $product = $selectedProducts->firstWhere('sku', $row[0]);
            if ($product) {
                $product->update([
                    'qty' => $row[1],
                    'unit_price' => $row[2],
                    'discount' => $row[3]
                ]);
            }
        }
        // Order Products
        foreach ($otherProducts as $product) {
            $product->update(['qty' => 0]);
        }
        return back()->with('success','Produts Updated Successfully');
    }

    private function formatAddress($address) {
        $format = '';
        if ($address) {
            $format .= $address->unit_no ? "Unit No: {$address->unit_no}" : '';
            $format .= $address->building_no ? ", Building No: {$address->building_no}" : '';
            $format .= $address->zone ? ", Zone: {$address->zone}" : '';
            $format .= $address->street ? ", Street: {$address->street}" : '';
            $format .= $address->latitude ? ", Latitude: {$address->latitude}" : '';
            $format .= $address->longitude ? ", Longitude: {$address->longitude}" : '';
        }
        return $format;
    }

    private function formatSiblings($siblings) {
        $format = '';
        $count = 1;
        $genders = ['boy', 'girl'];
        $numbers = ['one', 'two', 'three', 'four', 'five'];
        if ($siblings) {
            foreach ($genders as $gender) {
                foreach ($numbers as $number) {
                    $separator = $count !== 1 ? ', ': '';
                    $format .= $siblings["{$gender}_{$number}_name"]
                        ? sprintf("%s%d) Name: %s, Gender: Boy, Date of birth: %s", $separator, $count++, $siblings["{$gender}_{$number}_name"], $siblings["{$gender}_{$number}_dob"])
                        : '';
                }
            }
        }
        return $format;
    }

    public function points(Request $request) {
        // points system
        $settings = Setting::whereIn('name', ['points_threshold', 'reward_on_threshold'])->pluck('value', 'name');
        $points = $settings['points_threshold'] ?? 5000; // threshold points for the gift card
        $reward = $settings['reward_on_threshold'] ?? 100; // gift card reward value
        // wallet
        $totalBalance = Wallet::sum('balance');
        $eligibleUsers = User::with(['wallet', 'transactions' => fn ($q) => $q->orderBy('created_at', 'desc')])
            ->whereHas('wallet', fn ($q) => $q->where('balance', '>=', $points))
            ->get();
        return view('admin.points', compact('totalBalance', 'eligibleUsers', 'points', 'reward'));
    }

    public function changeProductFeaturedType(Request $request, Product $product, $type) {
        $status = $product->update([
            $type => $request->status
        ]);

        return response()->json([
            'status' => $status
        ]);
    }

    public function addOrderRemarks(Request $request) {
        if (!$request->order_id) {
            return response()->json([
                'status' => false,
            ], 400);
        }
        $order = Order::find( $request->order_id );
        $order->update([
            'remarks' => $request->remarks
        ]);
        return response()->json([
            'status' => true
        ], 200);
    }

    public function getNewOrdersCount(Request $request) {
        $time = Carbon::parse($request->time) ?? now();
        $count = Order::where('created_at', '>=', $time)
            ->where([
                'additional_details->is_new' => true,
                'additional_details->is_abandoned' => false
            ])->count();
        return response()->json([
            'status' => true,
            'count' => $count
        ]);
    }
}
