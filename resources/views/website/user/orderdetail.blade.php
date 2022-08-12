@extends('website.layouts.master')
@section('content')

{{-- @php
  $singleorder = DB::table('orders')->where('orderid' , $orderid)->get();
  $customer = DB::table('users')->where('id' , $singleorder->first()->cust_id)->get()->first();
  $customer_addresses = DB::table('customer_addresses')->where('cust_id' , $singleorder->first()->cust_id)->get()->first();
@endphp --}}
<main id="products-ranking" class="order-history order-detail">
<div class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="text-center order-summary">
                <h5>Order Summary</h5>
                <p>Order Number: {{ $order->order_number }}</p>
                <p>Total Price: {{ $order->total_amount }} QAR</p>
            </div>
        </div>
    	<div class="col-8">
            <div class="order-status">
              <div class="odr-btn complete"><a class="{{ $order->order_status == 'delivered' ? 'green-bg' : 'pink-bg' }}" href="javascript:void()">Order {{ ucfirst($order->order_status) }}</a></div>
            	{{-- @if($singleorder->first()->status == 5)
                <div class="odr-btn complete"><a class="green-bg" href="javascript:void()">Order Completed</a></div>
                @elseif($singleorder->first()->status == 4)
                <div class="odr-btn complete"><a class="pink-bg" href="javascript:void()">Order Cancelled</a></div>
                @elseif($singleorder->first()->status == 3)
                <div class="odr-btn complete"><a class="pink-bg" href="javascript:void()">Order Shipped</a></div>
                @elseif($singleorder->first()->status == 2)
                <div class="odr-btn complete"><a class="pink-bg" href="javascript:void()">Order Confirm</a></div>
                @elseif($singleorder->first()->status == 1)
                <div class="odr-btn complete"><a class="pink-bg" href="javascript:void()">Order Pending</a></div>
                @endif --}}
            </div>
            
            <table class="table pro-detail">
              <thead>
                <tr>
                  <th>Product Details:</th>
                </tr>
              </thead>
              <tbody>
              	{{-- @foreach($orders as $order)
                @php
                if($order->discount)
                {
                  $price = $order->discount;
                }else{
                  $price = $order->unit_price;
                }
                @endphp --}}
                @foreach ($order->items as $item)
                <tr>
                  <td>
                      <div class="d-flex product-rank">
                          <div class="img-box"><img src="{{asset('products/'.$item->product->featured_img)}}"/></div>
                          <div class="detail">
                              <p>{{$item->product->title}}</p>
                              <div><span>Price: {{ $item->total_amount }} QAR</span></div>
                              <p>QTY: {{$item->quantity}}</p>
                          </div>
                      </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            
            <table class="table customer">
              <thead>
                <tr>
                  <th>Customer Details:</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                      <div class="d-flex product-rank">
                          <div class="detail">
                              <p>Shipped to: <span>{{ $order->user->name }}</span></p>
                              <p>Address: <span> {{$order->address->unit_no}},{{$order->address->building_no}},{{$order->address->zone}},{{$order->address->street}}</span></p>
                              <p>Contact No: <span>{{ $order->user->mobile }}</span></p>
                          </div>
                      </div>
                  </td>
                </tr>
              </tbody>
            </table>

        </div>
    </div>
</div>

</main>
@endsection