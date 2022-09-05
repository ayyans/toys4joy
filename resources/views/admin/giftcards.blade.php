@extends('admin.layouts.master')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">


<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
        <div class="card-header">
            Add New Gift Card
        </div>
        <div class="card-body">
            <div class="row">
               
                <div class="col-md-12">
                    <form action="{{route('admin.addgiftcardsubmit')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                            <label>Gift Card Name</label>
                            <input type="text" class="form-control categoriesfrm" placeholder="Gift Card Name" name="coupon_title" id="coupon_title"/>
                        </div>
                        <div class="row form-group">
                            <label>Gift Card Code</label>
                            <input type="text" class="form-control categoriesfrm" placeholder="Gift Card Code Will Be Automaticaly Genrated" name="coupon_code" id="coupon_code" readonly/>
                        </div>
                        
                        <div class="row form-group">
                            <label>Price (QAR)</label>
                            <input type="text" name="price" class="form-control">
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
        <h6 class="m-0 font-weight-bold text-primary">All Gift Card</h6>
        <!-- <a href="{{route('admin.addcategories')}}"><button type="btn" class="btn btn-round btn-success" style="float:right">Add Category</button></a> -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Price</th>
                        <th>Status</th> 
                        <th>Action</th>                        
                    </tr>
                </thead>
                
                <tbody>
                  @foreach($giftcard as $coupon)
                  <tr>
                      <td>{{$coupon->name}}</td>
                      <td>{{$coupon->code}}</td>
                      <td>QAR {{$coupon->price}}</td>
                      <td>
                        @if($coupon->user_id)
                        <div class="badge badge-pill badge-primary px-3 py-2">Used</div>
                        @elseif($coupon->status==0)
                        <div class="badge badge-danger">Inactive</div>
                        @elseif($coupon->status==1)
                        <div class="badge badge-success">Active</div>
                        @endif
                      </td>
                      <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-dark">Action</button>
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                        @if($coupon->status==0)
                            <li><a href="{{route('admin.activategiftcard',$coupon->id)}}" class="dropdown-item">Activate</a></li>
                            @elseif($coupon->status==1)
                            <li><a href="{{route('admin.deactivategiftcard',$coupon->id)}}" class="dropdown-item">Deactivate</a></li>
                            @endif
                            {{-- <li><a href="javascript:void(0)" class="dropdown-item">Edit</a></li> --}}
                            <li><a href="{{route('admin.deletegiftcard', $coupon->id)}}" class="dropdown-item">Delete</a></li>
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