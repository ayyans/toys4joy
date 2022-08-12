@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Guest Orders</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            {{-- <th>Shipping address</th> --}}
                            <th>Payement Status</th>
                            <th>Total Amount</th>
                            <th>Order Status</th>
                            {{-- <th>Payment ID</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>{{ $order->created_at->format('h:i:s A') }}</td>
                            <td>{{ $order->additional_details['name'] ?? null }}</td>
                            <td>{{ $order->additional_details['email'] ?? null }}</td>
                            <td>{{ $order->additional_details['mobile'] ?? null }}</td>
                            {{-- <td>{{ $order->apartment }},{{ $order->faddress }},{{ $order->city }}</td> --}}
                            {{-- <td>{{ $order->order_type }}</td> --}}
                            {{-- <td>{{ $order->payment_id }}</td> --}}
                            <td>
                                {{-- <div class="badge {{ in_array($order->order_status, ['placed', 'cancelled']) ? 'badge-danger' : 'badge-success' }}">{{ $order->order_status }}</div> --}}
                                <div class="badge {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-danger' }}">{{ $order->payment_status }}</div>
                            </td>
                            <td>QAR {{ $order->total_amount }}</td>
                            <td>
                                <div class="badge {{ in_array($order->order_status, ['placed', 'cancelled']) ? 'badge-danger' : 'badge-success' }}">{{ strtoupper($order->order_status) }}</div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark">Info</button>
                                    <button type="button" class="btn btn-success dropdown-toggle"
                                        data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{route('admin.guestOrdersDetails',[encrypt($order->id)])}}"
                                                class="dropdown-item">View</a></li>
                                        @if($order->order_status == 'placed')

                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'confirmed'])}}"
                                                class="dropdown-item">Confirm</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item">Cancel</a></li>
                                        @elseif($order->order_status == 'confirmed')
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'shipped'])}}"
                                                class="dropdown-item">Shipped</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item">Concel</a></li>
                                        @elseif($order->order_status == 'shipped')
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'delivered'])}}"
                                                class="dropdown-item">Delivered</a></li>
                                        <li><a href="{{route('admin.changeOrderStatus', ['order_id' => $order->id, 'status' => 'cancelled'])}}"
                                                class="dropdown-item">Concel</a></li>
                                        @endif
                                        {{-- @if($order->status==1)

                                        <li><a href="{{route('admin.confirmGuestOrders',[encrypt($order->id)])}}"
                                                class="dropdown-item">Confirm</a></li>
                                        <li><a href="{{route('admin.cancelledGuestOrders',[encrypt($order->id)])}}"
                                                class="dropdown-item">Concel</a></li>
                                        @elseif($order->status==2)
                                        <li><a href="{{route('admin.shippedGuestOrders',[encrypt($order->id)])}}"
                                                class="dropdown-item">Shipped</a></li>
                                        <li><a href="{{route('admin.cancelledGuestOrders',[encrypt($order->id)])}}"
                                                class="dropdown-item">Concel</a></li>
                                        @elseif($order->status==3)
                                        <li><a href="{{route('admin.deliveredGuestOrders',[encrypt($order->id)])}}"
                                                class="dropdown-item">Delivered</a></li>
                                        <li><a href="{{route('admin.cancelledGuestOrders',[encrypt($order->id)])}}"
                                                class="dropdown-item">Concel</a></li>
                                        @elseif($order->status==4)
                                        <li><a href="javascript:void(0)" class="dropdown-item">Concelled</a></li>
                                        @elseif($order->status==5)
                                        <li><a href="javascript:void(0)" class="dropdown-item">Delivered</a></li>
                                        @endif --}}
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