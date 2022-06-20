@extends('admin.layouts.master')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">


<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
        <div class="card-header">
            Add new Coupons
        </div>
        <div class="card-body">
            <div class="row">
               
                <div class="col-md-12">
                    <form action="{{route('admin.addcouponProcess')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                          
                          <label>Coupon Type</label>                     
                    
                          <select type="text" class="form-control categoriesfrm"  name="coupon_type" id="coupon_type">
                                <option value="0">-select coupon type-</option>
                                <option value="1">Discount</option>
                                <option value="2">Gift Card</option>
                                <option value="3">Corporate</option>
                          </select>
                     
                  </div>
                        <div class="row form-group">
                          
                                <label>Coupon Title</label>
                           
                          
                                <input type="text" class="form-control categoriesfrm" placeholder="write here coupon title" name="coupon_title" id="coupon_title"/>
                           
                        </div>
                        <div class="row form-group">
                            
                                <label>Coupon code</label>
                           
                           
                                <input type="text" class="form-control categoriesfrm" placeholder="write here coupon code" name="coupon_code" id="coupon_code" readonly/>
                           
                        </div>
                        <div class="row form-group">
                            
                                <label>Valid upto</label>
                           
                           
                                <input type="date" class="form-control categoriesfrm" name="validupto"/>
                          
                        </div>
                        <div class="row form-group">
                            
                                <label>offer(in %)</label>
                           
                           
                                <input type="text" class="form-control categoriesfrm" name="offer"/>
                          
                        </div>

                        
                        <div class="row form-group">
                            
                            <label>Description</label>
                       
                       
                            <textarea type="text" class="form-control categoriesfrm" name="desc"></textarea>
                      
                    </div>


                       <button type="btn" class="btn btn-success coupnSubmit">Submit</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    </div>
    <div class="col-lg-8">
<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All coupons</h6>
        <!-- <a href="{{route('admin.addcategories')}}"><button type="btn" class="btn btn-round btn-success" style="float:right">Add Category</button></a> -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Coupon Type</th>
                        <th>coupon title</th>
                        <th>Coupon code</th>
                        <th>Valid upto</th> 
                        <th>Offer</th>                                               
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>                        
                    </tr>
                </thead>
                
                <tbody>
                  @foreach($coupons as $coupon)
                  <tr>
                      <td>
                        @if($coupon->coupontype==1)
                        Disscount
                        @elseif($coupon->coupontype==2)
                        Gift card
                        @elseif($coupon->coupontype==3)
                        Corporate
                        @endif
                    </td>
                      <td>{{$coupon->coupon_title}}</td>
                      <td>{{$coupon->coupon_code}}</td>
                      <td>{{$coupon->exp_date}}</td>
                      <td>{{$coupon->offer}}</td>
                      <td>{{$coupon->desc}}</td>
                      <td>
                      @if($coupon->status==1)
                            <div class="badge badge-danger">not active</div>
                            @elseif($coupon->status==2)
                            <div class="badge badge-success">Active</div>
                            @endif

                      </td>
                      <td>
                      <div class="btn-group">
                                <button type="button" class="btn btn-dark">Info</button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                @if($coupon->status==1)
                                    <li><a href="{{route('admin.activateCoupon',[encrypt($coupon->id)])}}" class="dropdown-item">Activate</a></li>
                                    @elseif($coupon->status==2)
                                    <li><a href="{{route('admin.deactivateCoupon',[encrypt($coupon->id)])}}" class="dropdown-item">Deactivate</a></li>
                                    @endif
                                    <li><a href="javascript:void(0)" class="dropdown-item">Edit</a></li>
                                    
                                    <li><a href="{{route('admin.deleteCoupon',[encrypt($coupon->id)])}}" class="dropdown-item">Delete</a></li>
                                </ul>
                                </div>
                      </td>
                  </tr>
                  @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>

</div>

@stop

@push('otherscript')
<script>
    $(function(){
        $("#coupon_title").on("blur",function(){
            var title = $(this).val();
            if(title==''){
                $("#coupon_code").val('');
                return false;
            }else{
                var update_title = title.substring(0,3);
                var generate_code = Math.random().toString(16).substr(2, 8);
                var couponCode = update_title+generate_code;
                $("#coupon_code").val(couponCode);
                //console.log(couponCode);
            }
        })
    })
</script>

<script>
    $(function(){
        $("button.coupnSubmit").click(function(e){
            e.preventDefault();
            var isValid = true;
        $('input.categoriesfrm').each(function() {
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

        $('select.categoriesfrm').each(function() {
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

       
       

        if (isValid == false){ 
            e.preventDefault();
        }
        else {
            $('form#categoryFRM').submit();
        }
    });


    })
</script>

@endpush