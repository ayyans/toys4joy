@extends('admin.layouts.master')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

<div class="row">
    <div class="col-lg-4">
    <div class="card mb-4">
        <div class="card-header">
            Add new sub-categories
        </div>
    <div class="card-body">
   
            <div class="row">
                
                <div class="col-md-12">
                    <form action="{{route('admin.SubcateProcess')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                           
                                <label>Sub-Category Name</label>
                            
                                <input type="text" class="form-control categoriesfrm" placeholder="write here category name" name="catname"/>
                           
                        </div>
                        <div class="row form-group">
                           
                                <label>Parent Name</label>
                            
                                <select type="text" class="form-control categoriesfrm" name="parent_cat">
                                    <option value="0">--select parent--</option>
                                      @foreach($categories as $cat)  
                                      <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                      @endforeach
                                   
                            </select>
                           
                        </div>
                        
                        <div class="row form-group">
                           
                                <label>Icon</label>
                            
                                <input type="file" class="form-control categoriesfrm" name="catIcon"/>
                           
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
        <h6 class="m-0 font-weight-bold text-primary">All Sub-Categories</h6>
       <!-- <a href="{{route('admin.addSubCat')}}"><button type="btn" class="btn btn-outline-warning" style="float:right"><i class="fa fa-plus"></i></button></a> -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Parent Name</th>                        
                        <th>Icon</th>
                        <th>Status</th>
                        <th>Action</th>                        
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($subcategories as $subcategory)
                    <tr>
                        <td>{{$subcategory->subcat_name}}</td>
                        <td>
                            {{$subcategory->category_name}}

                        </td>
                        
                        <td><img src="{{asset('uploads/'.$subcategory->icon)}}" style="width:50px"/></td>
                        <td>
                            @if($subcategory->status==1)
                            <div class="badge badge-danger">not active</div>
                            @elseif($subcategory->status==2)
                            <div class="badge badge-success">Active</div>
                            @endif
                        </td>
                        <td>
                            <!-- @if($subcategory->status==1)
                            <a href="{{route('admin.activateSubCategories',[encrypt($subcategory->id)])}}"><button class="btn btn-circle btn-warning"><i class="fa fa-ban"></i></button></a>
                            @elseif($subcategory->status==2)
                            <a href="{{route('admin.deactivateSubCategories',[encrypt($subcategory->id)])}}"><button class="btn btn-circle btn-primary"><i class="fa fa-check"></i></button></a>
                            @endif
                            <button class="btn btn-circle btn-success"><i class="fa fa-pen"></i></button> -->
                            <!-- <a href="{{route('admin.deleteSubCat',[encrypt($subcategory->id)])}}"><button class="btn btn-circle btn-danger"><i class="fa fa-trash"></i></button></a> -->

                            <div class="btn-group">
  <button type="button" class="btn btn-dark">Info</button>
  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu">
  @if($subcategory->status==1)
    <li><a href="{{route('admin.activateSubCategories',[encrypt($subcategory->id)])}}" class="dropdown-item">Activate</a></li>
    @elseif($subcategory->status==2)
    <li><a href="{{route('admin.deactivateSubCategories',[encrypt($subcategory->id)])}}" class="dropdown-item">Deactivate</a></li>
    @endif
    <li><a href="javascript:void(0)" class="dropdown-item">Edit</a></li>
    
    <li><a href="{{route('admin.deleteSubCat',[encrypt($subcategory->id)])}}" class="dropdown-item">Delete</a></li>
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