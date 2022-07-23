@extends('website.layouts.master')
@section('content')
<main>
<div class="container-fluid">
    <div class="row">
    	<div class="col-2 categories-col">
            <div class="d-flex flex-column flex-shrink-0" >
                <div class="for-mobile mbl-banner">
                @include('website.layouts.user_menu')
                </div>
                <div class="categories">
                    <h2 class="for-desktop">Categories</h2>
                    <h2 class="for-mobile">Select Category</h2>
                    <ul class="nav nav-pills flex-column mb-auto menu">
                    @include('website.layouts.category_menu')
                      
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-sm-12">
            <div class="for-desktop">
            @include('website.layouts.user_menu')  
            </div>
            <div class="d-flex products-list">
              @foreach($products as $product)
                <div class="single">
                    @if($product->qty == 0)
                    <div class="availbility"><span>Out of Stock</span></div>
                    @elseif($product->discount)
                    @php
                      $percent = (($product->unit_price - $product->discount)*100) /$product->unit_price ;
                    @endphp
                    <div class="availbility"><span>{{ number_format((float)$percent, 2, '.', '') }}% OFF </span></div>
                    @endif
                    <div class="img-block"><a href="{{ url('product') }}/{{ $product->url }}"><img src="{{asset('products/'.$product->featured_img)}}"/></a></div>
                    <div class="text-center content-block">
                        <h3>{{$product->title}}</h3>
                        <div class="d-flex price-cart">
                              @if($product->discount)
                              <span class="price">QAR {{$product->discount}}</span>
                              <del class="price">QAR {{$product->unit_price}}</del>
                              @else
                              <span class="price">QAR {{$product->unit_price}}</span>
                              @endif
                              <span class="card-action d-flex mr-1">
                          <i class="fa fa-shopping-cart" onclick="addtocart({{$product->id}},1,{{$product->unit_price}})"></i>
                          @if(Auth::check())
                          <i class="fa @if(DB::table('wishlists')->where('cust_id' , Auth::user()->id)->where('prod_id' , $product->id)->count() > 0) fa-heart @else fa-heart-o @endif wishlist-list addtowishlist{{ $product->id }}" id="addwishlist" onclick="addtowishlist({{$product->id}})"></i>
                          @else
                          <a href="{{ url('login') }}">
                          <i class="fa fa-heart-o wishlist-list"></i>
                         </a>
                         @endif
                          </span>
                            <!--<i class="fa fa-shopping-cart" onclick="addtocart({{$product->id}},1,{{$product->unit_price}})"></i>-->

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {!! $products->links('website.pagination') !!}
        </div>
    </div>
</div>

</main>
@stop
