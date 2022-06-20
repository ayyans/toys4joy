@extends('admin.layouts.master')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

<div class="row">
    <div class="col-lg-4">
    <div class="card mb-4">
        <div class="card-header">
            Add new Attribute
        </div>
    <div class="card-body">
   
            <div class="row">
                
                <div class="col-md-12">
                    <form action="{{route('admin.addattr')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                           
                                <label>Attribute Name</label>
                            
                                <input type="text" class="form-control categoriesfrm" placeholder="write here attribute name" name="attrname"/>
                           
                        </div>  
                       <button type="btn" class="btn btn-success categorieSubmit">Submit</button>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Add Attribute Value
        </div>
    <div class="card-body">
   
            <div class="row">
                
                <div class="col-md-12">
                    <form action="{{route('admin.addattrVal')}}" method="POST" enctype="multipart/form-data" id="attrvalFRM">
                        @csrf
                        <div class="row form-group">
                           
                                <label>Attribute value</label>
                            
                                <input type="text" class="form-control attrValfrm" placeholder="write here attribute name" name="attrval"/>
                           
                        </div>  

                        <div class="row form-group">
                           
                                <label>Attribute</label>
                            
                                <select type="text" class="form-control attrValfrm" name="attrname">
                                    <option value="0">select attribute</option>
                                    @foreach($attributs as $attribute)
                                    <option value="{{$attribute->id}}">{{$attribute->attribute_name}}</option>
                                    @endforeach
                                </select>
                           
                        </div> 
                       <button type="btn" class="btn btn-success attrvalSubmit">Submit</button>
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
        <h6 class="m-0 font-weight-bold text-primary">All Attribute</h6>
       
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered"  width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>                        
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($attr as $attrs)
                    <tr>
                        <td>{{$attrs->attribute_name}}</td>
                     
                        
                        
                        <td>
                            @if($attrs->status==1)
                            <div class="badge badge-danger">not active</div>
                            @elseif($attrs->status==2)
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
  @if($attrs->status==1)
    <li><a href="{{route('admin.activateAttr',[encrypt($attrs->id)])}}" class="dropdown-item">Activate</a></li>
    @elseif($attrs->status==2)
    <li><a href="{{route('admin.deactivatAttr',[encrypt($attrs->id)])}}" class="dropdown-item">Deactivate</a></li>
    @endif    
    
    <li><a href="{{route('admin.deleteAttr',[encrypt($attrs->id)])}}" class="dropdown-item">Delete</a></li>
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


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Attribute value</h6>
       
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>attribute</th>
                        <th>value</th>
                        <th>Status</th>
                        <th>Action</th>                        
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($attrVal as $attrv)
                    <tr>
                        <td>{{$attrv->attribute_name}}</td>
                        <td>{{$attrv->attr_value}}</td>
                        
                        
                        <td>
                            @if($attrv->status==1)
                            <div class="badge badge-danger">not active</div>
                            @elseif($attrv->status==2)
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
  @if($attrv->status==1)
    <li><a href="{{route('admin.activateAttrVal',[encrypt($attrv->id)])}}" class="dropdown-item">Activate</a></li>
    @elseif($attrv->status==2)
    <li><a href="{{route('admin.deactivatAttrVal',[encrypt($attrv->id)])}}" class="dropdown-item">Deactivate</a></li>
    @endif    
    
    <li><a href="{{route('admin.deleteAttrVal',[encrypt($attrv->id)])}}" class="dropdown-item">Delete</a></li>
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

<script>
    $(function(){
        $("button.attrvalSubmit").click(function(e){
            e.preventDefault();
            var isValid = true;
        $('input.attrValfrm').each(function() {
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

        $('select.attrValfrm').each(function() {
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
            $('form#attrvalFRM').submit();
        }
    });

      
    })
</script>

@endpush