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
                            <input type="file" class="form-control" name="brandIcon"/>
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
                        <td style="text-align: center;">
                            @if($brand->logo)
                            <img src="{{asset('uploads/'.$brand->logo)}}" style="width:50px"/>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($brand->status==1)
                            <div class="badge badge-danger">Not Active</div>
                            @elseif($brand->status==2)
                            <div class="badge badge-success">Active</div>
                            @endif
                        </td>
                        <td style="text-align: center;">
                           

                            <div class="btn-group">
                              <button type="button" class="btn btn-dark">Action</button>
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
                                <li><a data-toggle="modal" data-target="#myModal{{ $brand->id }}" href="javascript:void(0)" class="dropdown-item">Edit</a></li>
                                
                                <li><a href="{{route('admin.deleteBrands',[encrypt($brand->id)])}}" class="dropdown-item">Delete</a></li>
                              </ul>
                            </div>
           
                        </td>
                    </tr>

                    <div id="myModal{{ $brand->id }}" class="modal fade" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Edit Brand: {{ $brand->brand_name }}</h4>
                          </div>
                          <form action="{{ url('admin/updatebrand') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                          <div class="modal-body">
                                <input type="hidden" name="id" value="{{ $brand->id }}">
                                <div class="row form-group">
                                    <label>Brand Name</label>
                                    <input value="{{ $brand->brand_name }}" type="text" class="form-control" placeholder="write here brand name" name="brandname"/>
                                </div>
                                <div class="row form-group">
                                    <label>Icon</label>
                                    <input style="height: 45px;" type="file" class="form-control" name="brandIcon"/>
                                </div>
                               
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Update</button>
                            
                          </div>
                          </form>
                        </div>

                      </div>
                    </div>
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