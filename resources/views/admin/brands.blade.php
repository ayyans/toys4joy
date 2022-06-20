@extends('admin.layouts.master')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

<div class="row">
    <div class="col-lg-4">
    <div class="card mb-4">
        <div class="card-header">
            Add new brands
        </div>
    <div class="card-body">
   
            <div class="row">
                
                <div class="col-md-12">
                    <form action="{{route('admin.BrandProcess')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                           
                                <label>Brand Name</label>
                            
                                <input type="text" class="form-control categoriesfrm" placeholder="write here brand name" name="brandname"/>
                           
                        </div>
                       
                        
                        <div class="row form-group">
                           
                                <label>Icon</label>
                            
                                <input type="file" class="form-control categoriesfrm" name="brandIcon"/>
                           
                        </div>

                       <button type="btn" class="btn btn-success categorieSubmit">Submit</button>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</div>
    <div class="col-lg-8">
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Brands</h6>
       
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>                                              
                        <th>Icon</th>
                        <th>Status</th>
                        <th>Action</th>                        
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($brands as $brand)
                    <tr>
                        <td>{{$brand->brand_name}}</td>
                     
                        
                        <td><img src="{{asset('uploads/'.$brand->logo)}}" style="width:50px"/></td>
                        <td>
                            @if($brand->status==1)
                            <div class="badge badge-danger">not active</div>
                            @elseif($brand->status==2)
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
  @if($brand->status==1)
    <li><a href="{{route('admin.activateBrand',[encrypt($brand->id)])}}" class="dropdown-item">Activate</a></li>
    @elseif($brand->status==2)
    <li><a href="{{route('admin.deactivateBrand',[encrypt($brand->id)])}}" class="dropdown-item">Deactivate</a></li>
    @endif
    <li><a href="javascript:void(0)" class="dropdown-item">Edit</a></li>
    
    <li><a href="{{route('admin.deleteBrands',[encrypt($brand->id)])}}" class="dropdown-item">Delete</a></li>
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
<!-- /.container-fluid -->
@stop

@push('otherscript')
<script>
    $(function(){
        $("button.categorieSubmit").click(function(e){
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