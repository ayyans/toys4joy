@extends('website.layouts.master')
@section('content')
<main id="products-ranking" class="order-history">
<div class="container-fluid">
    <div class="row">
    	<div class="col-12">
            <h2 class="text-center">{{__('trans.Order History')}}</h2>
            <table class="table">
              <thead>
                <tr>
                  <th>{{__('trans.Order Details & Shipping Information')}}</th>
                  <th class="img-col">{{__('trans.Order Status')}}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                <tr>
                  <td>
                      <div class="d-flex product-rank">
                          {{-- <div class="img-box"><img src="{{asset('products/'.$item->product->featured_img)}}"/></div> --}}
                          <div class="detail">
                              <a href="{{ url('orderdetail') }}/{{ $order->order_number }}" class="order-id" style="font-size: 20px !important">Order# {{$order->order_number}}</a>
                              {{-- <p>{{$item->product->title}}</p> --}}
                              <div class="price-qty"><span class="qty">{{$order->items->count()}}</span><span>{{$order->total_amount}} QAR</span></div>
                              <div class="shiping"><span>{{__('trans.Ship to:')}} {{auth()->user()->name}}</span></div>
                              
                              <!-- <a href="javascript:void(0)" class="order-again green-text">Order Again</a> -->
                          </div>
                      </div>
                  </td>
                  <td class="order-status">
                    <div class="odr-btn {{ $order->order_status == 'delivered' ? 'complete' : 'inprogress' }}"><a class="vertical-shake @if($order->order_status == 'delivered') green-bg @endif" href="javascript:void(0)">Order {{ucwords($order->order_status) }} </div>
                    {{-- @if($order->orderStatus==5)
                      <div class="odr-btn complete"><a class="vertical-shake green-bg" href="javascript:void(0)">{{__('trans.Order Completed')}}</a></div>
                      <a class="rating">Rate your Product Here</a>
                      @elseif($order->orderStatus==4)
                      <div class="odr-btn inprogress"><a class="vertical-shake" href="javascript:void(0)">{{__('trans.Order Cancelled')}}</a></div>
                      @elseif($order->orderStatus==3)
                      <div class="odr-btn inprogress"><a class="vertical-shake" href="javascript:void(0)">{{__('trans.Order Shipped')}}</a></div>
                      @elseif($order->orderStatus==2)
                      <div class="odr-btn inprogress"><a class="vertical-shake" href="javascript:void(0)">{{__('trans.Order Confirm')}}</a></div>
                      @elseif($order->orderStatus==1)
                      <div class="odr-btn inprogress"><a class="vertical-shake" href="javascript:void(0)">{{__('trans.Order Pending')}}</a></div>
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
