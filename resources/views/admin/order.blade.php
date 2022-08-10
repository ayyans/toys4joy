@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
   
<div class="card shadow mb-4">

<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">@if($type == 'wishlist') All WishList Orders @else Orders @endif</h6>
    
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>    
                    <th>#</th>               
                    <th>Date</th>
                    <th>Time</th>
                    <th>Order ID</th> 
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Address</th>                                                                 
                    <th>Payement Method</th>
                    <th>Payement ID</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>                        
                </tr>
            </thead>
            
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{date('d M Y', strtotime($order->created_at))}}</td>
                    <td>{{date('h:i:s A', strtotime($order->created_at))}}</td>
                    <td>{{$order->order_number}}</td>
                    <td>{{$order->name}}</td>
                    <td>{{$order->mobile}}</td>
                    <td>{{$order->unit_no}},{{$order->building_no}},{{$order->zone}},{{$order->street}}</td>
                    <td style="text-align: center;">
                        @if($order->mode==2)
                        <div style="font-size: 16px;" class="badge badge-success"> PAID </div>
                        @else
                        <div style="font-size: 16px;" class="badge badge-danger"> COD </div>
                        @endif
                    </td>
                    <td>{{$order->payment_id}}</td>
                    <?php //$total_price = 0; ?>
                    {{--@foreach(DB::table('orders')->where('orderid' , $order->orderid)->get() as $r)
                    @php
                      $product = DB::table('products')->where('id' , $r->prod_id)->get()->first();
                      if($product->discount)
                      {
                          $price = $product->discount;
                      }else{
                          $price = $product->unit_price;
                      }

                    @endphp

                    <?php //$total_price+=$price*$r->qty; ?>
                    @endforeach--}}
                    <td>QAR {{ $order->real_total_amount }}</td>
                    <td>
                        @if($order->status==1)
                        <div class="badge badge-danger">Pending</div>
                        @elseif($order->status==2)
                        <div class="badge badge-success">Confirm</div>
                        @elseif($order->status==3)
                        <div class="badge badge-success">Shipped</div>
                        @elseif($order->status==4)
                        <div class="badge badge-danger">Cancelled</div>
                        @elseif($order->status==5)
                        <div class="badge badge-success">Delivered</div>
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
                                <li><a href="{{route('admin.custOrdersDetails',[encrypt($order->id)])}}" class="dropdown-item">View</a></li>
                                @if($order->status==1)
                                
                                    <li><a href="{{route('admin.confirmCustOrders',[encrypt($order->id)])}}" class="dropdown-item">Confirm</a></li>
                                    <li><a href="{{route('admin.cancelledCustOrders',[encrypt($order->id)])}}" class="dropdown-item">Concel</a></li>
                                    @elseif($order->status==2)
                                    <li><a href="{{route('admin.shippedCustOrders',[encrypt($order->id)])}}" class="dropdown-item">Shipped</a></li>
                                    <li><a href="{{route('admin.cancelledCustOrders',[encrypt($order->id)])}}" class="dropdown-item">Concel</a></li>
                                    @elseif($order->status==3)
                                    <li><a href="{{route('admin.deliveredCustOrders',[encrypt($order->id)])}}" class="dropdown-item">Delivered</a></li>
                                    <li><a href="{{route('admin.cancelledCustOrders',[encrypt($order->id)])}}" class="dropdown-item">Concel</a></li>
                                    @elseif($order->status==4)
                                    <li><a href="javascript:void(0)" class="dropdown-item">Concelled</a></li>
                                    @elseif($order->status==5)
                                    <li><a href="javascript:void(0)" class="dropdown-item">Delivered</a></li>
                                    @endif
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