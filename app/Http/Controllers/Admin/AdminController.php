<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Order;

class AdminController extends Controller
{
    //
    public function dashboard(){
        return view('admin.dashboard');
    }


    // customer details 

    public function customer(){
        $customers = Customer::orderBy('id','desc')->get();
        return view('admin.customer',compact('customers'));
    }


    // customer activate and deactivate

    public function activateCustomer(Request $request){
        $catid = decrypt($request->id);
        $activate = Customer::where('id','=',$catid)->update([
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
        $deactivate = Customer::where('id','=',$catid)->update([
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


    // add sub category

    public function SubcateProcess(Request $request){
        $exist_ct = SubCategory::where('subcat_name','=',$request->catname)->count();
        if($exist_ct>0){
            return back()->with('Sub-category already exist');
        }else{            

             $catIcon = time().'.'.$request->file('catIcon')->getClientOriginalName();
             $request->catIcon->move(public_path('uploads'), $catIcon);

             $category = new SubCategory;
             $category->subcat_name=$request->catname;
             $category->parent_cat=$request->parent_cat;            
             $category->icon=$catIcon;
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

         $brandIcon = time().'.'.$request->file('brandIcon')->getClientOriginalName();
         $request->brandIcon->move(public_path('uploads'), $brandIcon);

         $category = new Brand;
         $category->brand_name=$request->brandname;                    
         $category->logo=$brandIcon;
         $category->save();
         if($category==true){
             return back()->with('success','brands added successfull');
             exit();
         }else{
            return back()->with('error','something went wrong');
            exit();
         }


    }
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
        return view('admin.add-products',compact('categories','brands','attributes'));
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
            // $addproduct->tags=$request->tags;
            $addproduct->barcode=$request->barcode;
            $addproduct->featured_img=$thumbnail_img;
            $addproduct->video_provider=$request->video_provider;
            $addproduct->videolink=$request->video_link;
            $addproduct->unit_price=$request->unit_price;
            $addproduct->discount=$request->discount;
            $addproduct->price_discount_unit=$request->discount_type;
            // $addproduct->points=$request->earn_point;
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
    $orders = Order::leftJoin('products','products.id','=','orders.prod_id')
                ->leftJoin('customers','customers.id','=','orders.cust_id')
                ->leftJoin('customer_addresses','customer_addresses.id','=','orders.cust_add_id')
              ->select('products.title as productName','featured_img','products.unit_price as prod_price','orders.*','name','email','mobile','unit_no','building_no','zone','street','faddress')  
              ->orderBy('orders.id','desc')->get();
    return view('admin.order',compact('orders'));
}


// confirm guest orders


public function confirmCustOrders(Request $request){
    $orderid = decrypt($request->id);
    $update_orders = Order::where('id','=',$orderid)->update([
        'status'=>'2'
    ]);
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
                ->leftJoin('customers','customers.id','=','orders.cust_id')
                ->leftJoin('customer_addresses','customer_addresses.id','=','orders.cust_add_id')
              ->select('products.title as productName','featured_img','products.unit_price as prod_price','orders.*','name','email','mobile','unit_no','building_no','zone','street','faddress')  
              ->where('orders.id','=',$orderid)->first();
    return view('admin.custorderDetails',compact('orders'));
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
        'unit'=>$request->unit,
        'min_qty'=>$request->min_qty,
        'tags'=>$request->tags,
        'barcode'=>$request->barcode,
        'featured_img'=>$thumbnail_img,
        'video_provider'=>$request->video_provider,
        'videolink'=>$request->video_link,
        'unit_price'=>$request->unit_price,
        'discount'=>$request->discount,
        'price_discount_unit'=>$request->discount_type,
        'points'=>$request->earn_point,
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
        'vat_unit'=>$request->vat_type
    ]);
}else{
    $update_product = Product::where('id','=',$prod_id)->update([
        'title'=>$request->prodname,
        'category_id'=>$request->category_id,
        'brand_id'=>$request->brand_id,
        'unit'=>$request->unit,
        'min_qty'=>$request->min_qty,
        'tags'=>$request->tags,
        'barcode'=>$request->barcode,
        'video_provider'=>$request->video_provider,
        'videolink'=>$request->video_link,
        'unit_price'=>$request->unit_price,
        'discount'=>$request->discount,
        'price_discount_unit'=>$request->discount_type,
        'points'=>$request->earn_point,
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
        'vat_unit'=>$request->vat_type
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





    


    
    

    
}
