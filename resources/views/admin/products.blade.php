@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row mb-2">    
        <div class="col-md-12">    
        <a href="{{route('admin.addproducts')}}"><button type="btn" class="btn btn-round btn-success" style="float:right">Add Product</button></a>
        </div>
    </div>
<div class="card shadow mb-4">

<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
    
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>price</th> 
                    <th>discount</th> 
                    <th>Qty</th>                                              
                    <th>Status</th>
                    <th>Action</th>                        
                </tr>
            </thead>
            
            <tbody>
              @foreach($products as $product)
              <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{$product->title}}</td>
                    <td>{{$product->unit_price}}</td>
                    <td>{{$product->discount}}</td>
                    <td>{{$product->qty}}</td>
                    <td>
                            @if($product->status==1)
                            <div class="badge badge-danger">not active</div>
                            @elseif($product->status==2)
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
                                <li><a href="javascript:void(0)" class="dropdown-item">View</a></li>
                                @if($product->status==1)
                                
                                    <li><a href="{{route('admin.activateProd',[encrypt($product->id)])}}" class="dropdown-item">Activate</a></li>
                                    @elseif($product->status==2)
                                    <li><a href="{{route('admin.deactivateprod',[encrypt($product->id)])}}" class="dropdown-item">Deactivate</a></li>
                                    @endif
                                    <li><a href="{{route('admin.editproducts',[encrypt($product->id)])}}" class="dropdown-item">Edit</a></li>
                                    
                                    <li><a href="{{route('admin.deleteprod',[encrypt($product->id)])}}" class="dropdown-item">Delete</a></li>
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

@stop