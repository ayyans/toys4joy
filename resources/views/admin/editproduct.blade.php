@extends('admin.layouts.master')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <form action="{{route('admin.editProcess')}}" method="POST" enctype="multipart/form-data" id="products_form">
        @csrf
        <input type="hidden" name="prod_id" id="prod_id" value="{{$products->id}}" />
        <input type="hidden" name="catid" id="catid" value="{{$products->category_id}}" />
        <input type="hidden" name="brandid" id="brandid" value="{{$products->brand_id}}" />    
        <input type="hidden" name="shippingType" id="shippingType" value="{{$products->shipping_type}}" />
        <input type="hidden" name="featured_type" id="featured_type" value="{{$products->featured_status}}" />
        <input type="hidden" name="todaydeals" id="todaydeals" value="{{$products->todays_deal}}" />
        <div class="row gutters-5">
            <div class="col-lg-8">
              
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Product Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control addprodfrm" name="prodname" placeholder="Product Name"  required="" value="{{$products->title}}" />
                            </div>
                        </div>
                        <div class="form-group row" id="category">
                            <label class="col-md-3 col-from-label">Category <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select onchange="subcategories(this.value)" class="form-control addprodfrm selectcat" name="category_id" id="category_id">
                                    <option value="0">select category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="category">
                            <label class="col-md-3 col-from-label">Sub Category </label>
                            <div class="col-md-8">
                                <select class="form-control addprodfrm" name="sub_cat" id="subcat_id">
                                    <option value="">Select Sub Category</option>
                                    @foreach(DB::table('sub_categories')->where('parent_cat' , $products->category_id)->get() as $r)
                                    <option @if($products->sub_cat == $r->id) selected @endif value="{{ $r->id }}">{{ $r->subcat_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <script type="text/javascript">
                            function subcategories(id)
                            {
                                var url = '{{ url("admin/getsubcategories") }}'
                                $.ajax({
                                    type: "GET",
                                    url: url+'/'+id,
                                    success: function(resp) {
                                        $('#subcat_id').html(resp)
                                    }
                                });
                            }
                        </script>
                            <div class="form-group row" id="brand">
                                <label class="col-md-3 col-from-label">Brand</label>
                                <div class="col-md-8">
                                    <select class="form-control addprodfrm selectbrand" name="brand_id" id="brand_id">
                                        <option value="0">Select Brand</option>
                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                        @endforeach
                                    </select>                                   
                                   
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Unit</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control addprodfrm" name="unit" placeholder="Unit (e.g. KG, Pc etc)" required="" value="{{$products->unit}}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Minimum Purchase Qty <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" lang="en" class="form-control addprodfrm" name="min_qty" value="{{$products->min_qty}}" min="1" required="" />
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-md-3 col-from-label">Tags <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control aiz-tag-input" name="tags" placeholder="Type and hit enter to add a tag" value="{{$products->tags}}"/>
                                <small class="text-muted">This is used for search. Input those words by which cutomer can find this product.</small>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Barcode</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="barcode" placeholder="Barcode" value="{{$products->barcode}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Recommended Age</label>
                            <div class="col-md-8">
                                <select class="form-control " name="recommended_age" >
                                    @for ($i = 0; $i <= 192; $i++)
                                    <option value="{{ $i }}" {{ $i == $products->recommended_age ? 'selected' : '' }}>{{  $products->formatRecommendedAge($i) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Refundable</label>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="refundable" checked="" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">Gallery Images <small>(600x600)</small></label>
                            <div class="col-md-8">
                                
                                <div class="input-group" >
                                    
                                    <input type="file" name="photos[]" class="selected-files " multiple/>
                                </div>
                                <div class="file-preview box sm"></div>
                                <small class="text-muted">These images are visible in product details page gallery. Use 600x600 sizes images.</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">Thumbnail Image <small>(300x300)</small></label>
                            <div class="col-md-8">
                            <img src="{{asset('products/'.$products->featured_img)}}" style="width:100px" />
                                <div class="input-group" >
                                   
                                    <input type="file" name="thumbnail_img" class="selected-files " />
                                </div>
                                <div class="file-preview box sm"></div>
                                <small class="text-muted">
                                    This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Videos</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Video Provider</label>
                            <div class="col-md-8">
                               
                                    <select class="form-control " name="video_provider" id="video_provider" >
                                        <option value="youtube">Youtube</option>
                                        <option value="dailymotion">Dailymotion</option>
                                        <option value="vimeo">Vimeo</option>
                                    </select>                                   
                                    
                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Video Link</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="video_link" placeholder="Video Link" />
                                <small class="text-muted">Use proper link without extra parameter. Don't use short share link/embeded iframe code.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Variation</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row gutters-5">
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="Attribute" disabled="" />
                            </div>
                            <div class="col-md-8">                                
                                <ul class="attrbutelist">
                                @foreach($attributes as $attr)
                                    <li><input type="checkbox" value="{{$attr->id}}" name="attribute[]" data="{{$attr->attribute_name}}" class="attrlist"/><label>{{$attr->attribute_name}}</label></li>
                                @endforeach
                                </ul>                                
                            </div>                            
                        </div>                       
                        

                        <div>
                            <p>Choose the attributes of this product and then input values of each attribute</p>
                            <br />
                        </div>

                        <div id="attrvalues"></div>

                        

                        
                    </div>
                </div> -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product price + stock</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Unit price <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="{{$products->unit_price}}" step="0.01" placeholder="Unit price" name="unit_price" class="form-control addprodfrm" required="" />
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Discount <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="{{$products->discount}}" step="0.01" placeholder="Discount" name="discount" class="form-control addprodfrm" required="" />
                            </div>
                            <div class="col-md-3">
                                
                                    <select class="form-control addprodfrm" name="discount_type" tabindex="-98">
                                        @if($products->price_discount_unit=='amount')
                                        <option value="amount" selected>Flat</option>
                                        <option value="percent">Percent</option>
                                        @elseif($products->price_discount_unit=='percent')
                                        <option value="amount" >Flat</option>
                                        <option value="percent" selected>Percent</option>
                                        @endif
                                    </select>
                                   
                                    
                             
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                Set Point
                            </label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="{{$products->points}}" step="1" placeholder="1" name="earn_point" class="form-control addprodfrm" />
                            </div>
                        </div> -->

                        <div id="show-hide-div">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Quantity <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="{{$products->qty}}" step="1" placeholder="Quantity" name="current_qty" class="form-control addprodfrm" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    SKU
                                </label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="SKU" name="sku" class="form-control addprodfrm" value="{{$products->sku}}" />
                                </div>
                            </div>
                        </div>
                       
                        <br />
                        <div class="sku_combination" id="sku_combination"></div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Description</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Short Description</label>
                            <div class="col-md-8">
                                <textarea class="form-control addprodfrm" name="shortdescription" rows="5">{{$products->short_desc}}</textarea>
                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Long Description</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="longdescription" rows="8" id="longdesc">{{$products->long_desc}}</textarea>
                               
                            </div>
                        </div>
                    </div>
                </div>

                <!--                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Shipping Cost</h5>
                    </div>
                    <div class="card-body">

                    </div>
                </div>-->

               
                
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">
                            Shipping Configuration
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Free Shipping</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="shipping_type" value="free" checked="" />
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Flat Rate</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="shipping_type" value="flat_rate" />
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="flat_rate_shipping_div" style="display: none;">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">Shipping cost</label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="0" step="0.01" placeholder="Shipping cost" name="flat_shipping_cost" class="form-control" required="" />
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label class="col-md-6 col-from-label">Is Product Quantity Mulitiply</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="is_quantity_multiplied" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Low Stock Quantity Warning</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">
                                Quantity
                            </label>
                            <input type="number" name="low_stock_quantity" value="{{$products->low_qty_warning}}" min="0" step="1" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">
                            Stock Visibility State
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Show Stock Quantity</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="stock_visibility_state" value="quantity" checked="" />
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Show Stock With Text Only</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="stock_visibility_state" value="text" />
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Hide Stock</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="stock_visibility_state" value="hide" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Featured</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Status</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="featured" value="1" id="featured_prod" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">New Arrival</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input @if($products->new_arrival == 1) checked @endif type="checkbox" name="new_arrival" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Best Seller</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input @if($products->best_seller == 1) checked @endif type="checkbox" name="best_seller" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Best Offers</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input @if($products->best_offer == 1) checked @endif type="checkbox" name="best_offer" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Todays Deal</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Status</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="todays_deal" value="1" id="todaysdeal_prod" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Flash Deal</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">
                                Add To Flash
                            </label>
                           
                                <select class="form-control" name="flash_deal_id" id="flash_deal" tabindex="-98">
                                    <option value="">Choose Flash Title</option>
                                    <option value="1">
                                        Winter Sell
                                    </option>
                                    <option value="2">
                                        Falsh sale
                                    </option>
                                    <option value="3">
                                        Electronic
                                    </option>
                                    <option value="4">
                                        Flash Deal
                                    </option>
                                </select>
                               
                            
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">
                                Discount
                            </label>
                            <input type="number" name="flash_discount" value="0" min="0" step="1" class="form-control" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">
                                Discount Type
                            </label>
                            
                                <select class="form-control" name="flash_discount_type" id="flash_discount_type">
                                    <option value="">Choose Discount Type</option>
                                    <option value="amount">Flat</option>
                                    <option value="percent">Percent</option>
                                </select>
                               
                                
                           
                        </div>
                    </div>
                </div> -->

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Estimate Shipping Time</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">
                                Shipping Days
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="est_shipping_days" min="1" step="1" placeholder="Shipping Days" value="{{$products->shiping_time}}"/>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend">Days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Vat &amp; TAX</h5>
                    </div>
                    <div class="card-body">
                        <label for="name">
                            Tax
                            <input type="hidden" value="3" name="tax_id" />
                        </label>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="number" lang="en" min="0" value="{{$products->tax}}"step="0.01" placeholder="Tax" name="tax" class="form-control" required="" />
                            </div>
                            <div class="form-group col-md-6">
                                
                                    <select class="form-control" name="tax_type" tabindex="-98">
                                        @if($products->tax_unit=='amount')
                                        <option value="amount" selected>Flat</option>
                                        <option value="percent">Percent</option>
                                        @elseif($products->tax_unit=='percent')
                                        <option value="amount" >Flat</option>
                                        <option value="percent" selected>Percent</option>
                                        @endif
                                    </select>
                                   
                                   
                               
                            </div>
                        </div>
                        <label for="name">
                            Vat
                            <input type="hidden" value="4" name="tax_id[]" />
                        </label>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="number" lang="en" min="0" value="{{$products->vat}}" step="0.01" placeholder="Tax" name="vat" class="form-control" required="" />
                            </div>
                            <div class="form-group col-md-6">
                               
                                    <select class="form-control" name="vat_type" tabindex="-98">
                                    @if($products->vat_unit=='amount')
                                        <option value="amount" selected>Flat</option>
                                        <option value="percent">Percent</option>
                                        @elseif($products->vat_unit=='percent')
                                        <option value="amount" >Flat</option>
                                        <option value="percent" selected>Percent</option>
                                        @endif
                                    </select>
                                   
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                   
                    <div class="btn-group" role="group" aria-label="Second group">
                        <button type="submit" name="button" class="btn btn-success action-btn addproductSubmitBtn">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



<!-- /.container-fluid -->
@stop

@push('otherstyle')


<style>
    @import
url(https://fonts.googleapis.com/icon?family=Material+Icons);


.select-checkbox option::before {
  content: "\2610";
  width: 1.3em;
  text-align: center;
  display: inline-block;
}
.select-checkbox option:checked::before {
  content: "\2611";
}

.select-checkbox-fa option::before {
  font-family: FontAwesome;
  content: "\f096";
  width: 1.3em;
  display: inline-block;
  margin-left: 2px;
}
.select-checkbox-fa option:checked::before {
  content: "\f046";
}

.frame {
 
 
  width: 100%;
  height: 200px;
   
  border-radius: 2px;
	box-shadow: 4px 8px 16px 0 rgba(0,0,0,0.1);
	overflow: hidden;
  background: #ffff;
  color: #fff;
	font-family: 'Open Sans', Helvetica, sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}

.center {
 
	width: 100%;
	height: 200px;
	display: flex;
	justify-content: center;
	align-items: center;
}



.dropzone{
	position: absolute;
	width: 200px;
	height: 200px;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}

.filename {
	color: #d9d9d9;
	width: 300px;
	height: 130px;
	word-break: break-all;
	font-size: 11px;
	line-height: 15px;
	z-index: 1;
}

#img{
	position: absolute;
	opacity: 0; 
	width: 150px;
	height: 130px;
	cursor: pointer;
	z-index: 99999;
}

.content{
	width: 150px;
	height: 130px;
	text-align: center;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 5px;
	border: 2px dashed #d9d9d9;
	cursor: pointer;
}


.syncing{
	font-size: 100px;
    color: #021754d1;
    text-shadow: 0 0 5px #049191;
    opacity: .3;
}
.multiselect-container>li>a>label {
  padding: 4px 20px 3px 20px;
}

.attrbutelist{
    list-style:none;
    max-height:100px;
    border:1px solid #d1d3e2;
    width:100%;
    overflow:auto;
    border-radius:5px;
    padding:10px
}

.attrbutelist>li>label{
    padding: 4px 10px 3px 10px;
}
.attrbutelist>li{
    padding-left:5px;
}
.attrbutelist>li:hover{
    background:#d1d3e2;
}

</style>
@endpush

@push('otherscript')
<script>
    tinymce.init({
        selector:'textarea#longdesc', 
        plugins: 'lists',              
             
    });
</script>

<script>
    $(function(){
        // selected category
        var cat = $("#catid").val();
        $(".selectcat option").each(function(){
            if($(this).val()==cat){
                $(this).attr('selected','selected');
            }
        })

        // selected brand

        var brand = $("#brandid").val();
        $(".selectbrand option").each(function(){
            if($(this).val()==brand){
                $(this).attr('selected','selected');
            }
        })

        // featured product 

        var featured = $("#featured_type").val();
        var featuredType = $("#featured_prod").val();
        if(featured==featuredType){
            $("#featured_prod").prop('checked',true);
        }else{
            $("#featured_prod").prop('checked',false);
        }

        // todays deal

        var todaysdeal = $("#todaydeals").val();
        var todaysdeal_prod = $("#todaysdeal_prod").val();
        if(todaysdeal==todaysdeal_prod){
            $("#todaysdeal_prod").prop('checked',true);
        }else{
            $("#todaysdeal_prod").prop('checked',false);
        }


    })
</script>
<script>
    $(function(){
        $("button.addproductSubmitBtn").click(function(e){
            e.preventDefault();
            var isValid = true;
        $('input.addprodfrm').each(function() {
            if ($.trim($(this).val()) == '') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });

        $('select.addprodfrm').each(function() {
            if ($.trim($(this).val()) == '0') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });


        $('textarea.addprodfrm').each(function() {
            if ($.trim($(this).val()) == '') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });

       
       

        if (isValid == false){ 
            e.preventDefault();
        }
        else {
            $('form#products_form').submit();
        }
    });

      
    })
</script>

<script>
   $(function() {
        $("input.attrlist").click(function(){ 
            var attrid = $(this).val();            
            if($(this).is(":checked")){
                $(this).prop('checked',true); 
                var attrid = $(this).val();
                var attrname = $(this).attr('data');
                $("#attrvalues").append('<div class="form-group row gutters-5" id="'+attrid+'"> <div class="col-md-3"> <input type="text" class="form-control" value="'+attrname+'" disabled=""/> </div><div class="col-md-8"> <select type="text" class="form-control selectattr'+attrid+'" id="'+attrid+'" name="attrval[]"></select> </div></div>');
                
                var form = new FormData();
                form.append('attr',attrid);
                $.ajax({
                    url:"{{route('admin.prodAttrVal')}}",
                    type:"POST",
                    data:form,
                    contentType:false,
                    cache:false,
                    processData:false,
                    success:function(res){
                        var js_data = JSON.parse(JSON.stringify(res));
                        if(js_data.status==200){
                            $.each(js_data.msg,function(a,v){
                                $("select.selectattr"+attrid).append('<option value="'+v.id+'">'+v.attr_value+'</option>');
                            })
                        }  
                    }
                })
            }else{
                $(this).prop('checked',false); 
                $("#"+attrid).remove();
                
            }
        })

});
</script>

<script>
    $(function(){
        $("input[name=shipping_type]").click(function(){
            if($(this).is(":checked")){
                $(this).prop('checked',true);
                if($(this).val()=='flat_rate'){
                    $(".flat_rate_shipping_div").show();
                }else{
                    $(".flat_rate_shipping_div").hide(); 
                }
            }else{
                $(this).prop('checked',false);
                $(".flat_rate_shipping_div").hide();
                
            }
        })
    })
</script>




@endpush