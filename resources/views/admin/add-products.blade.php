@extends('admin.layouts.master')
@push('otherstyle')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endpush
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <form action="{{route('admin.addProductProcess')}}" method="POST" enctype="multipart/form-data" id="products_form">
        @csrf
        <div class="row gutters-5">
            <div class="col-lg-8">

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Product Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control addprodfrm" name="prodname"
                                    placeholder="Product Name" required="" />
                            </div>
                        </div>
                        <div class="form-group row" id="category">
                            <label class="col-md-3 col-from-label">Category <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select onchange="subcategories(this.value)" class="form-control addprodfrm"
                                    name="category_id" id="category_id">
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
                                    <option>Select Subcategory</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Linked Categories</label>
                            <div class="col-md-8">
                                <select class="form-control addprodfrm" name="linked_categories[]" id="linked_categories" multiple>
                                    <option></option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
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
                                <select class="form-control addprodfrm" name="brand_id" id="brand_id">
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
                                <input type="text" class="form-control" name="unit"
                                    placeholder="Unit (e.g. KG, Pc etc)" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Minimum Purchase Qty <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" lang="en" class="form-control addprodfrm" name="min_qty" value="1"
                                    min="1" required="" />
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-md-3 col-from-label">Tags <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control aiz-tag-input" name="tags" placeholder="Type and hit enter to add a tag" />
                                <small class="text-muted">This is used for search. Input those words by which cutomer can find this product.</small>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Barcode</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="barcode" placeholder="Barcode" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Recommended Age</label>
                            <div class="col-md-8">
                                <select class="form-control " name="recommended_age">
                                    @for ($i = 0; $i <= 192; $i++) 
                                    <option value="{{ $i }}">{{ formatRecommendedAge($i) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!--  <div class="form-group row">
                            <label class="col-md-3 col-from-label">Refundable</label>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="refundable" checked="" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">Gallery Images
                                <small>(600x600)</small></label>
                            <div class="col-md-8">
                                <div class="input-group">

                                    <input type="file" name="photos[]" class="selected-files addprodfrm" multiple />
                                </div>
                                <div class="file-preview box sm"></div>
                                <small class="text-muted">These images are visible in product details page gallery. Use
                                    600x600 sizes images.</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">Thumbnail Image
                                <small>(300x300)</small></label>
                            <div class="col-md-8">
                                <div class="input-group">

                                    <input type="file" name="thumbnail_img" class="selected-files addprodfrm" />
                                </div>
                                <div class="file-preview box sm"></div>
                                <small class="text-muted">
                                    This image is visible in all product box. Use 300x300 sizes image. Keep some blank
                                    space around main object of your image as we had to crop some edge in different
                                    devices to make it responsive.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product price + stock</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Unit price <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="0.01" placeholder="Unit price"
                                    name="unit_price" class="form-control addprodfrm" required="" />
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Discount <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="0.01" placeholder="Discount"
                                    name="discount" class="form-control addprodfrm" required="" />
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                Set Point
                            </label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="1" placeholder="1" name="earn_point" class="form-control addprodfrm" />
                            </div>
                        </div> -->

                        <div id="show-hide-div">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Quantity <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="0" step="1" placeholder="Quantity"
                                        name="current_qty" class="form-control addprodfrm" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    SKU
                                </label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="SKU" name="sku" class="form-control addprodfrm" />
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
                                <textarea class="form-control" name="shortdescription" rows="5"></textarea>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Long Description</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="longdescription" rows="8" id="longdesc"></textarea>

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
                        <h5 class="mb-0 h6">Featured</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Status</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="featured" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">New Arrival</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="new_arrival" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Best Seller</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="best_seller" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Best Offers</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="best_offer" value="1" />
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
                                    <input type="checkbox" name="todays_deal" value="1" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <input type="number" class="form-control" name="est_shipping_days" min="1" step="1"
                                    placeholder="Shipping Days" />
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
                                <input type="number" lang="en" min="0" value="0" step="0.01" placeholder="Tax"
                                    name="tax" class="form-control" required="" />
                            </div>
                            <div class="form-group col-md-6">

                                <select class="form-control" name="tax_type" tabindex="-98">
                                    <option value="amount">Flat</option>
                                    <option value="percent">Percent</option>
                                </select>



                            </div>
                        </div>
                        <label for="name">
                            Vat
                            <input type="hidden" value="4" name="tax_id[]" />
                        </label>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="0.01" placeholder="Tax"
                                    name="vat" class="form-control" required="" />
                            </div>
                            <div class="form-group col-md-6">

                                <select class="form-control" name="vat_type" tabindex="-98">
                                    <option value="amount">Flat</option>
                                    <option value="percent">Percent</option>
                                </select>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">

                    <div class="btn-group" role="group" aria-label="Second group">
                        <button type="submit" name="button"
                            class="btn btn-success action-btn addproductSubmitBtn">Submit</button>
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
    @import url(https://fonts.googleapis.com/icon?family=Material+Icons);


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
        box-shadow: 4px 8px 16px 0 rgba(0, 0, 0, 0.1);
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



    .dropzone {
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

    #img {
        position: absolute;
        opacity: 0;
        width: 150px;
        height: 130px;
        cursor: pointer;
        z-index: 99999;
    }

    .content {
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


    .syncing {
        font-size: 100px;
        color: #021754d1;
        text-shadow: 0 0 5px #049191;
        opacity: .3;
    }

    .multiselect-container>li>a>label {
        padding: 4px 20px 3px 20px;
    }

    .attrbutelist {
        list-style: none;
        max-height: 100px;
        border: 1px solid #d1d3e2;
        width: 100%;
        overflow: auto;
        border-radius: 5px;
        padding: 10px
    }

    .attrbutelist>li>label {
        padding: 4px 10px 3px 10px;
    }

    .attrbutelist>li {
        padding-left: 5px;
    }

    .attrbutelist>li:hover {
        background: #d1d3e2;
    }
</style>
@endpush

@push('otherscript')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#linked_categories').select2({
        theme: 'bootstrap4',
        placeholder: 'Link Categories'
    });
</script>
<script>
    tinymce.init({
        selector:'textarea#longdesc', 
        plugins: 'lists',
    });
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