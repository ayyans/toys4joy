@extends('website.layouts.master')
@section('content')
<main id="products-ranking" class="order-history">
<div class="container-fluid">
    <div class="row">
    	<div class="col-12">
            <h2 class="text-center">Order History</h2>
            <table class="table">
              <thead>
                <tr>
                  <th>Order Details & Shipping Information</th>
                  <th class="img-col">Order Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $item)
                <tr>
                  <td>
                      <div class="d-flex product-rank">
                          <div class="img-box"><img src="{{asset('products/'.$item->product->featured_img)}}"/></div>
                          <div class="detail">
                              <a href="{{ url('orderdetail') }}/{{ $item->order->order_number }}" class="order-id">Order# {{$item->order->order_number}}</a>
                              <p>{{$item->product->title}}</p>
                              <div class="price-qty"><span class="qty">{{$item->quantity}}</span><span>{{$item->total_amount}} QAR</span></div>
                              <div class="shiping"><span>Ship to: {{auth()->user()->name}}</span></div>
                              
                              <!-- <a href="javascript:void(0)" class="order-again green-text">Order Again</a> -->
                          </div>
                      </div>
                  </td>
                  <td class="order-status">
                    <div class="odr-btn {{ $item->order->order_status == 'delivered' ? 'complete' : 'inprogress' }}"><a class="vertical-shake @if($item->order->order_status == 'delivered') green-bg @endif" href="javascript:void(0)">Order {{ ucwords($item->order->order_status) }}</div>
                    {{-- @if($order->orderStatus==5)
                      <div class="odr-btn complete"><a class="vertical-shake green-bg" href="javascript:void(0)">Order Completed</a></div>
                      <a class="rating">Rate your Product Here</a>
                      @elseif($order->orderStatus==4)
                      <div class="odr-btn inprogress"><a class="vertical-shake" href="javascript:void(0)">Order Cancelled</a></div>
                      @elseif($order->orderStatus==3)
                      <div class="odr-btn inprogress"><a class="vertical-shake" href="javascript:void(0)">Order Shipped</a></div>
                      @elseif($order->orderStatus==2)
                      <div class="odr-btn inprogress"><a class="vertical-shake" href="javascript:void(0)">Order Confirm</a></div>
                      @elseif($order->orderStatus==1)
                      <div class="odr-btn inprogress"><a class="vertical-shake" href="javascript:void(0)">Order Pending</a></div>
                      @endif --}}
                  </td>
                </tr>
               
             @endforeach
              </tbody>
            </table>

        </div>
    </div>
</div>

</main>

@stop