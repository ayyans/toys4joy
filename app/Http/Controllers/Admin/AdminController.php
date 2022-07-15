<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusChanged;
use App\Exports\CustomersReportExport;
use App\Exports\GuestsReportExport;
use App\Exports\InventoryReportExport;
use App\Exports\SalesReportExport;
use App\Imports\ImportProducts;
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
use App\Models\homepagebanners;
use App\Models\Order;
use App\Models\ReturnRequest;
use App\Models\User;
use App\Models\requiredproducts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class AdminController extends Controller
{
    //
    public function dashboard(){
        // delivered orders count
        $customersOrderCount = Order::where('status', 5)->count();
        $guestsOrderCount = GuestOrder::where('status', 5)->count();
        $ordersCount = $customersOrderCount + $guestsOrderCount;

        // total customers
        $customersCount = User::where('status', 2)->count();

        // total products
        $productsCount = Product::where('status', 2)->count();

        // Total revenue
        $customersOrderSum = Order::where('status', 5)->sum(DB::raw('amount * qty'));
        $guestsOrderSum = GuestOrder::where('guest_orders.status', 5)
            ->join('products', 'guest_orders.prod_id', 'products.id')
            ->sum(DB::raw('products.unit_price * guest_orders.qty'));
        $revenueCount = $customersOrderSum + $guestsOrderSum;

        return view('admin.dashboard', compact('ordersCount', 'customersCount', 'productsCount', 'revenueCount'));
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
        $banner->image=Cmf::sendimagetodirectory($request->image);
        $banner->position = $request->position;
        $banner->url = $request->url;
        $banner->status = 1;
        $banner->save();
        return back()->with('success','Banner Added SuccessFull!');
    }
    public function homepagebannersedit(Request $request)
    {
        $banner = homepagebanners::find($request->id);
        if($request->image)
        {
            $banner->image=Cmf::sendimagetodirectory($request->image);
        }
        $banner->position = $request->position;
        $banner->url = $request->url;
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
        $card = new giftcards();
        $card->name = $request->coupon_title;
        $card->price = $request->price;
        $card->code = $request->coupon_code;
        $card->status = 1;
        $card->save();
         return back()->with('success','Gift Card Added SuccessFull!');

    }
    public function activategiftcards(Request $request){
        $id = decrypt($request->id);
        $activate = giftcards::where('id','=',$id)->update([
            'status'=>'2'
        ]);
        if($activate==true){
            return back()->with('success','Gift Card activated successfull');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }

    // deactivate giftcard 

    public function deactivategiftcards(Request $request){
        $id = decrypt($request->id);
        $deactivate = giftcards::where('id','=',$id)->update([
            'status'=>'1'
        ]);
        if($deactivate==true){
            return back()->with('success','Gift Card  deactivated successfull');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }
    // customer details 

    public function customer(){
        $customers = DB::table('users')->where('type' , 'customer')->orderBy('id','desc')->get();
        return view('admin.customer',compact('customers'));
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
         if($request->brandIcon)
         {
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
    if($request->brandIcon)
    {
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


// attribute

public function atribute(){
    $attr = Attribute::orderBy('id','desc')->get();
    $attrVal = AttrValue::leftJoin('attributes','attributes.id','=','attr_values.attr_id')
            ->select('attr_values.*','attributes.id as attrID','attribute_name')
            ->orderBy('id','desc')
            ->get();
    $attributs = Attribute::where('status','=','2')->orderBy('id','desc')->get();
    return view('admin.attribute',compact('attr','attrVal','attributs'));
}

public function addattr(Request $request){
    $exist_attr = Attribute::where('attribute_name','=',$request->attrname)->count();
    if($exist_attr>0){
        return back()->with('error','attribute already exist');
        exit();
    }else{
        $attribute = new Attribute;
        $attribute->attribute_name=$request->attrname;
        $attribute->save();
        if($attribute==true){
            return back()->with('success','attribute added successfull');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }
}

// activate attribute

 

  public function activateAttr(Request $request){
    $catid = decrypt($request->id);
    $activate = Attribute::where('id','=',$catid)->update([
        'status'=>'2'
    ]);
    if($activate==true){
        return back()->with('success','Attribute activated SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// deactivate attribute

public function deactivatAttr(Request $request){
    $catid = decrypt($request->id);
    $deactivate = Attribute::where('id','=',$catid)->update([
        'status'=>'1'
    ]);
    if($deactivate==true){
        return back()->with('success','Attribute deactivated SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// delete attribute 

public function deleteAttr(Request $request){
    $catid = decrypt($request->id);
    $deleteattr = Attribute::where('id','=',$catid)->delete();
    if($deleteattr==true){
        return back()->with('success','attribute deleted SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}



// attribute value

public function addattrVal(Request $request){
    $exist_attr = AttrValue::where('attr_value','=',$request->attrval)->count();
    if($exist_attr>0){
        return back()->with('error','attribute value already exist');
        exit();
    }else{
        $attribute = new AttrValue;
        $attribute->attr_id=$request->attrname;
        $attribute->attr_value=$request->attrval;
        $attribute->save();
        if($attribute==true){
            return back()->with('success','attribute value added successfull');
            exit();
        }else{
            return back()->with('error','something went wrong');
            exit();
        }
    }
}



// activate attribute value

 

public function activateAttrVal(Request $request){
    $catid = decrypt($request->id);
    $activate = AttrValue::where('id','=',$catid)->update([
        'status'=>'2'
    ]);
    if($activate==true){
        return back()->with('success','Attribute value activated SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// deactivate attribute value

public function deactivatAttrVal(Request $request){
    $catid = decrypt($request->id);
    $deactivate = AttrValue::where('id','=',$catid)->update([
        'status'=>'1'
    ]);
    if($deactivate==true){
        return back()->with('success','Attribute value deactivated SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

// delete attribute value 

public function deleteAttrVal(Request $request){
    $catid = decrypt($request->id);
    $deleteattr = AttrValue::where('id','=',$catid)->delete();
    if($deleteattr==true){
        return back()->with('success','attribute value deleted SuccessFull!');
        exit();
    }else{
        return back()->with('error','something went wrong');
        exit();
    }
}

    // products

    public function products(){
        $products = Product::orderBy('id','desc')->get();
        return view('admin.products',compact('products'));
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
            $addproduct->brand_id=$request->brand_id;
            $addproduct->unit=$request->unit;
            $addproduct->min_qty=$request->min_qty;
            $addproduct->sub_cat=$request->sub_cat;
            $addproduct->barcode=$request->barcode;
            $addproduct->featured_img=$thumbnail_img;
            $addproduct->video_provider=$request->video_provider;
            $addproduct->videolink=$request->video_link;
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
            $addproduct->shiping_type=$request->shipping_type;
            $addproduct->flat_shipping_cost=$request->flat_shipping_cost;            
            $addproduct->low_qty_warning=$request->low_stock_quantity;
            $addproduct->stock_visibilty=$request->stock_visibility_state;
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

            // $attribute = $request->attribute;
            // $attrVal = $request->attrval;
            // $total_attr = count($attribute);

            // for($i=0;$i<$total_attr;$i++){
            //     $addattr = new ProdAttr;
            //     $addattr->prod_id=$lastid;
            //     $addattr->attr_id=$attribute[$i];
            //     $addattr->attrval_id=$attrVal[$i];
            //     $addattr->save();
            // }

            if($addproduct==true){
                return back()->with('success','product added successfull');
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
    $orders = GuestOrder::leftJoin('products','products.id','=','guest_orders.prod_id')
              ->select('products.title as productName','featured_img','products.unit_price as prod_price','guest_orders.*')  
              ->orderBy('guest_orders.id','desc')->get();
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
        'status' => 'Confirmed'
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
        'status' => 'Shipped'
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
        'status' => 'Cancelled'
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
        'status' => 'Delivered'
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
    $orderid = decrypt($request->id);
    $orders = GuestOrder::leftJoin('products','products.id','=','guest_orders.prod_id')
              ->select('products.title as productName','featured_img','products.unit_price as prod_price','guest_orders.*')
              ->where('guest_orders.id','=',$orderid)  
              ->first();
    return view('admin.guestorderDetails',compact('orders'));
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
        'status'=>'2'
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
        'status'=>'1'
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
    $order_status = GuestOrder::where('id','=',$request->orderid)->update([
        'status'=>$request->status
    ]);
    if($order_status==true){
        return response()->json('1');
        exit();
    }else{
        return response()->json('2');
        exit();
    }
}


// logged in user orders

public function custOrders(){
    $orders = Order::select(
            "orders.id",
            "orders.orderid",
            "orders.orderstatus",
            "orders.cust_id",
            "orders.cust_add_id",
            "orders.payment_id",
            "orders.mode",
            "orders.amount",
            "orders.status",
            "orders.created_at",
            "users.name",
            "users.email",
            "users.mobile",
            "customer_addresses.unit_no",
            "customer_addresses.building_no",
            "customer_addresses.zone",
            "customer_addresses.street",
                  
                        )
            ->where('orders.orderstatus' , '!=' , 'payementpending')
            ->leftJoin('users', 'orders.cust_id', '=', 'users.id')
            ->leftJoin('customer_addresses', 'orders.cust_add_id', '=', 'customer_addresses.id')
            ->groupBy('orders.orderid')
            ->orderby('orders.id' , 'desc')

            ->get();

    return view('admin.order',compact('orders'));
}


// confirm guest orders


public function confirmCustOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = Order::where('id','=',$orderid)->update([
        'status'=>'2'
    ]);
    $order = Order::where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Confirmed!',
        'description' => 'Your order has confirmed.',
        'order_number' => $order->orderid,
        'to' => User::find($order->cust_id)->name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Confirmed'
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
    $order = Order::where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Shipped!',
        'description' => 'Your order is shipped.',
        'order_number' => $order->orderid,
        'to' => User::find($order->cust_id)->name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Shipped'
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
    $order = Order::where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Cancelled!',
        'description' => 'Your order is cancelled.',
        'order_number' => $order->orderid,
        'to' => User::find($order->cust_id)->name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Cancelled'
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
    $order = Order::where('id','=',$orderid)->first();
    $data = [
        'title' => 'Order Delivered!',
        'description' => 'Your order is delivered.',
        'order_number' => $order->orderid,
        'to' => User::find($order->cust_id)->name,
        'date' => $order->created_at->format('d/m/Y'),
        'status' => 'Delivered'
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
    $orderid = decrypt($request->id);

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
    return view('admin.orderdetails',compact('orders','orderdetail'));
}



// customer order status

public function CustomerorderStatus(Request $request){
    $order_status = Order::where('id','=',$request->orderid)->update([
        'status'=>$request->status
    ]);
    if($order_status==true){
        return response()->json('1');
        exit();
    }else{
        return response()->json('2');
        exit();
    }
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
        'url'=>$this->shorten_url($request->prodname),
        'unit'=>$request->unit,
        'min_qty'=>$request->min_qty,
        'sub_cat'=>$request->sub_cat,
        'barcode'=>$request->barcode,
        'featured_img'=>$thumbnail_img,
        'video_provider'=>$request->video_provider,
        'videolink'=>$request->video_link,
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
        'shiping_type'=>$request->shipping_type,
        'flat_shipping_cost'=>$request->flat_shipping_cost,
        'low_qty_warning'=>$request->low_stock_quantity,
        'stock_visibilty'=>$request->stock_visibility_state,
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
        'unit'=>$request->unit,
        'min_qty'=>$request->min_qty,
        'sub_cat'=>$request->sub_cat,
        'barcode'=>$request->barcode,
        'video_provider'=>$request->video_provider,
        'videolink'=>$request->video_link,
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
        'shiping_type'=>$request->shipping_type,
        'flat_shipping_cost'=>$request->flat_shipping_cost,
        'low_qty_warning'=>$request->low_stock_quantity,
        'stock_visibilty'=>$request->stock_visibility_state,
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
    if($update_product==true){
        return back()->with('success','product updated successFull');
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
        $applyFilter = false;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($request->anyFilled('start_date', 'end_date')) {
            $applyFilter = true;
        }

        $products = Product::query()
            ->withSum(['orders' => function ($query) use ($applyFilter, $start_date, $end_date) {
                $query->where('status', 5)->when($applyFilter, function($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            }], 'qty')
            ->withSum(['guestOrders' => function ($query) use ($applyFilter, $start_date, $end_date) {
                $query->where('status', 5)->when($applyFilter, function($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            }], 'qty')
            ->havingRaw('guest_orders_sum_qty > 0 || orders_sum_qty > 0')
            ->get()
            ->map(function($product) {
                return [
                    'title' => $product->title,
                    'sales' => (int) ($product->guest_orders_sum_qty + $product->orders_sum_qty)
                ];
            })
            ->sortByDesc('sales');

        // delivered orders count
        $productsSold = $products->reduce(function($total, $current) {
            return $total + $current['sales'];
        }, 0);

        // Total revenue
        $customersOrderSum = Order::where('status', 5)
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->sum(DB::raw('amount * qty'));
        $guestsOrderSum = GuestOrder::where('guest_orders.status', 5)
            ->join('products', 'guest_orders.prod_id', 'products.id')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('guest_orders.created_at', [$start_date, $end_date]);
            })
            ->sum(DB::raw('products.unit_price * guest_orders.qty'));
        $revenueCount = $customersOrderSum + $guestsOrderSum;

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new SalesReportExport($products, $productsSold, $revenueCount), 'sales-report.xlsx');
        }

        return view('admin.reports.sales-report', compact('products', 'productsSold', 'revenueCount'));
    }

    public function inventoryReport(Request $request) {
        $products = Product::with('category:id,category_name', 'subCategory:id,subcat_name')
            ->where('status', 2)
            ->select('title', 'sku', 'unit_price', 'qty', 'category_id', 'sub_cat', 'status')
            ->get()
            ->map(function($product) {
                $product->category_id = $product->category->category_name;
                if ($product->subCategory) {
                    $product->sub_cat = $product->subCategory->subcat_name;
                }
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

        $applyFilter = false;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($request->anyFilled('start_date', 'end_date')) {
            $applyFilter = true;
        }

        $users = User::with(['paid_orders' => function($query) use ($applyFilter, $start_date, $end_date) {
            $query->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            });
        }])
            ->withCount(['paid_orders' => function($query) use ($applyFilter, $start_date, $end_date) {
                $query->when($applyFilter, function($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            }])
            ->withSum(['paid_orders' => function($query) use ($applyFilter, $start_date, $end_date) {
                $query->when($applyFilter, function($query) use ($start_date, $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                });
            }], 'amount')
            ->get()
            ->sortByDesc('paid_orders.*.created_at')
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'total_orders' => $user->paid_orders_count,
                    'total_amount' => $user->paid_orders_sum_amount ?? 0
                ];
            });

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new CustomersReportExport($users), 'customers-report.xlsx');
        }

        return view('admin.reports.customers-report', compact('users'));
    }

    public function guestsReport(Request $request) {

        $applyFilter = false;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($request->anyFilled('start_date', 'end_date')) {
            $applyFilter = true;
        }

        $orders = GuestOrder::where('guest_orders.status', 5)
            ->join('products', 'guest_orders.prod_id', 'products.id')
            ->select('guest_orders.cust_email', 'guest_orders.created_at', 'guest_orders.qty', 'products.title', 'products.unit_price')
            ->when($applyFilter, function($query) use ($start_date, $end_date) {
                $query->whereBetween('guest_orders.created_at', [$start_date, $end_date]);
            })
            ->get()
            ->groupBy('cust_email')
            ->sortByDesc(fn ($orders) => $orders->max('created_at'))
            ->map(function($orders, $key) {
                return [
                    'email' => $key,
                    'total_orders' => $orders->count(),
                    'total_amount' => $orders->sum(DB::raw('products.unit_price * guest_orders.qty'))
                ];
            });

        // Export
        if ($request->filled('export') && $request->export === 'true') {
            return Excel::download(new GuestsReportExport($orders), 'guests-report.xlsx');
        }

        return view('admin.reports.guests-report', compact('orders'));
    }

    public function bulkupload()
    {
        return view('admin.reports.bulkupload');
    }
    public function bulkupdateprocess(Request $request)
    {
        Excel::import(new ImportProducts, $request->file('file')->store('files'));
        return back()->with('success','Produts Updated Successfully');
    }
}
