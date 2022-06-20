@extends('admin.layouts.master')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">


<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
        <div class="card-header">
            Add new categories
        </div>
        <div class="card-body">
            <div class="row">
               
                <div class="col-md-12">
                    <form action="{{route('admin.cateProcess')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                          
                                <label>Category Name</label>
                           
                          
                                <input type="text" class="form-control categoriesfrm" placeholder="write here category name" name="catname"/>
                           
                        </div>
                        <div class="row form-group">
                            
                                <label>Type</label>
                           
                           
                                <select type="text" class="form-control categoriesfrm" name="catType">
                                    <option value="0">--select type--</option>
                                    <option value="1">Physical</option>
                                    <option value="2">Digital</option>
                            </select>
                           
                        </div>
                        <div class="row form-group">
                            
                                <label>Banner</label>
                           
                           
                                <input type="file" class="form-control categoriesfrm" name="catBanner"/>
                          
                        </div>
                        <div class="row form-group">
                           
                                <label>Icon</label>
                          
                          
                                <input type="file" class="form-control categoriesfrm" name="catIcon"/>
                           
                        </div>

                       <button type="btn" class="btn btn-success categorieSubmit">Submit</button>
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
        <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
        <!-- <a href="{{route('admin.addcategories')}}"><button type="btn" class="btn btn-round btn-success" style="float:right">Add Category</button></a> -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Type</th>                                                
                        <th>Status</th>
                        <th>Action</th>                        
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                    <td><img src="{{asset('uploads/'.$category->cat_icon)}}" style="width:50px"/></td>
                        <td>{{$category->category_name}}</td>
                        <td>
                            @if($category->category_type==1)
                            Physical
                            @else
                            Digital
                            @endif

                        </td>
                        
                        
                        <td>
                            @if($category->status==1)
                            <div class="badge badge-danger">not active</div>
                            @elseif($category->status==2)
                            <div class="badge badge-success">Active</div>
                            @endif
                        </td>
                        <td>
                            <!-- @if($category->status==1)
                            <a href="{{route('admin.activateCategories',[encrypt($category->id)])}}"><button class="btn btn-circle btn-warning"><i class="fa fa-ban"></i></button></a>
                            @elseif($category->status==2)
                            <a href="{{route('admin.deactivateCategories',[encrypt($category->id)])}}"><button class="btn btn-circle btn-primary"><i class="fa fa-check"></i></button></a>
                            @endif
                            <button class="btn btn-circle btn-success"><i class="fa fa-pen"></i></button>
                            <a href="{{route('admin.deleteCat',[encrypt($category->id)])}}"><button class="btn btn-circle btn-danger"><i class="fa fa-trash"></i></button> -->

                            <div class="btn-group">
                                <button type="button" class="btn btn-dark">Info</button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                @if($category->status==1)
                                    <li><a href="{{route('admin.activateCategories',[encrypt($category->id)])}}" class="dropdown-item">Activate</a></li>
                                    @elseif($category->status==2)
                                    <li><a href="{{route('admin.deactivateCategories',[encrypt($category->id)])}}" class="dropdown-item">Deactivate</a></li>
                                    @endif
                                    <li><a href="{{route('admin.update_categories',[encrypt($category->id)])}}" class="dropdown-item">Edit</a></li>
                                    
                                    <li><a href="{{route('admin.deleteCat',[encrypt($category->id)])}}" class="dropdown-item">Delete</a></li>
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