@extends('admin.layouts.master')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
        <div class="card-header">
            Add New Homepage Banner
        </div>
        <div class="card-body">
            <div class="row">
               
                <div class="col-md-12">
                    <form action="{{route('admin.homepagebannerssubmit')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                            <label>Banner</label>
                            <input required type="file" class="form-control categoriesfrm"  name="image" id="coupon_title"/>
                        </div>
                        <div class="row form-group">
                            <label>Position</label>
                            <input required type="number" class="form-control categoriesfrm"  name="position"/>
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
        <h6 class="m-0 font-weight-bold text-primary">All Homepage Banners</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Banner</th>
                        <th>Position</th>
                        <th>Status</th> 
                        <th>Action</th>                        
                    </tr>
                </thead>
                
                <tbody>
                  @foreach($data as $coupon)
                  <tr>
                      <td style="text-align: center;">
                        <img style="width:100px" src="{{ url('uploads') }}/{{ $coupon->image }}">
                       </td>
                      <td>
                        {{ $coupon->position }}
                      <td>
                      @if($coupon->status==1)
                        <div class="badge badge-danger">not active</div>
                        @elseif($coupon->status==2)
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
                            @if($coupon->status==1)
                            <li><a href="{{route('admin.activatebanner',[encrypt($coupon->id)])}}" class="dropdown-item">Activate</a></li>
                            @elseif($coupon->status==2)
                            <li><a href="{{route('admin.deactivatebanner',[encrypt($coupon->id)])}}" class="dropdown-item">Deactivate</a></li>
                            @endif
                            <li><a href="{{route('admin.deletebanner',[encrypt($coupon->id)])}}" class="dropdown-item">Delete</a></li>
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