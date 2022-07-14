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
                @foreach($orders as $order)
                <tr>
                  <td>
                      <div class="d-flex product-rank">
                          <div class="img-box"><img src="{{asset('products/'.$order->featured_img)}}"/></div>
                          <div class="detail">
                              <a href="{{ url('orderdetail') }}/{{ $order->ordernumber }}" class="order-id">Order# {{$order->ordernumber}}</a>
                              <p>{{$order->title}}</p>
                              <div class="price-qty"><span class="qty">{{$order->OrderQty}}</span><span>{{$order->orderAmt}} QAR</span></div>
                              <div class="shiping"><span>Ship to: {{Auth::user()->name}}</span></div>
                              
                              <!-- <a href="javascript:void(0)" class="order-again green-text">Order Again</a> -->
                          </div>
                      </div>
                  </td>
                  <td class="order-status">
                    @if($order->orderStatus==5)
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
                      @endif
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