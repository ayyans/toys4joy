@extends('admin.layouts.master')
@section('content')


@php


// DB::table('guest_orders')->where('order_id' , $orders->order_id)->update(['newstatus'=>0]);

@endphp

<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Guest Orders Details</h6>

        </div>
        <div class="card-body">
            <table style="width:100% ;margin-bottom:20px;">
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <input type="hidden" name="orderid" id="orderid" value="{{$order->id}}" />
                        <label>Delivery Status</label>
                        {{-- @if($orders->status==4 || $orders->status==5 )
                        <select class="form-control" readonly>
                            <option value="1">Pending</option>
                            <option value="2">Confirm</option>
                            <option value="3">Shipped</option>
                            <option value="4">Cancel</option>
                            <option value="5">Delivered</option>
                        </select>
                        @else --}}
                        <select class="form-control" id="orderStatus">
                            <option @if($order->order_status == 'placed') selected @endif value="placed">Placed</option>
                            <option @if($order->order_status == 'confirmed') selected @endif value="confirmed">Confirmed</option>
                            <option @if($order->order_status == 'shipped') selected @endif value="shipped">Shipped</option>
                            <option @if($order->order_status == 'cancelled') selected @endif value="cancelled">Cancelled</option>
                            <option @if($order->order_status == 'delivered') selected @endif value="delivered">Delivered</option>
                        </select>
                        {{-- @endif --}}
                        <a href="{{ url('generateinvoice') }}/{{ $order->order_number }}">Download Invoice</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h1>toy4joy</h1><br /><br />
                    </td>

                </tr>
                <tr>
                    <td colspan="1" style="max-width: 250px">
                        <strong>{{ $order->additional_details['name'] ?? null }}</strong><br />
                        <strong> {{ $order->additional_details['email'] ?? null }}</strong><br />
                        <strong>{{ $order->additional_details['mobile'] ?? null }}</strong><br />
                        <strong>{{ $order->fullAddress ?? null }}</strong><br />
                    </td>
                    <td style="text-align:justify">
                        <strong>Order Id:{{ $order->order_number }}</strong><br />
                        <strong>Order status:</strong> {{ $order->order_status }}
                        <br />
                        <strong>Order date:</strong> {{ $order->created_at->format('d M Y') }} <br />
                        <strong>Order Time:</strong> {{ $order->created_at->format('h:i:s A') }} <br />
                        <strong>Payment Mode</strong>: {{ $order->order_type }}
                        </b>
                        <br />
                    </td>
                </tr>
            </table>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>sl.no</th>
                            <th>product</th>
                            <th>image</th>
                            <th>Qty</th>
                            <th>Total Amount (in QAR)</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($order->items as $index => $item)
                        {{-- @php
                        $product = DB::table('products')->where('id' , $r->product_id)->get()->first();
                        @endphp --}}
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->title }}</td>
                            <td><img src="{{ asset('products/'.$item->product->featured_img) }}" style="width:100px" />
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>QAR {{ $item->total_amount }}</td>
                        </tr>
                        @endforeach
                        {{-- @php

                        $totalammount = 0;

                        @endphp
                        @foreach(DB::table('guest_orders')->where('order_id' , $orders->order_id)->get() as $r)
                        @php
                        $product = DB::table('products')->where('id' , $r->prod_id)->get()->first();

                        if($product->discount)
                        {
                        $price = $product->discount;
                        }else{
                        $price = $product->unit_price;
                        }
                        @endphp
                        <tr>
                            <td>{{ $product->title }}</td>
                            <td><img src="{{asset('products/'.$product->featured_img)}}" style="width:100px" /></td>
                            <td>{{$r->qty}}</td>
                            <td>QAR {{$price*$r->qty}}</td>
                        </tr>
                        @php
                        $totalammount += $price*$r->qty;
                        @endphp
                        @endforeach --}}


                        {{--
                        <!-- <tr>
                    <td>1</td>
                    <td>{{$orders->productName}}</td>
                    <td><img src="{{asset('products/'.$orders->featured_img)}}" style="width:100px"/></td>
                    <td>{{$orders->qty}}</td>
                    <td>{{$orders->prod_price*$orders->qty}}</td>
                   
                </tr> --> --}}


                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right"><strong>Total</strong></td>
                            <td>QAR {{$order->total_amount}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@stop


@push('otherscript')
<script>
    $(function(){
        $("#orderStatus").change(function(){
            var status = $(this).val();
            if (['cancelled', 'delivered'].includes("{{ $order->order_status }}")) return;
            var orderid = $("#orderid").val();
            var form = new FormData();
            form.append('status',status);
            form.append('id',orderid);
            $.ajax({
                url:"{{route('admin.orderStatus')}}",
                type:"POST",
                data:form,
                cache:false,
                contentType:false,
                processData:false,
                success:function(res){
                    var js_data = JSON.parse(res);
                    if(js_data==1){
                        toastr.success('order status changed successfull!');
                                    location.reload();
                    }else{
                        toastr.error('something went wrong');
                                    return false;
                    }
                }
            })
        })
    })
</script>
@endpush