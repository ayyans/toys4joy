@extends('website.layouts.master')
@section('content')
<main>
<div class="container-fluid">
    <div class="row">
    	<div class="col-3 categories-col">
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
        <div class="col-9">
            <div class="for-desktop">
            @include('website.layouts.user_menu')  
            </div>
            <div class="d-flex products-list">
              @foreach($products as $product)
                <div class="single"> 
                    <div class="availbility"><span>{{ $product->qty }}</span></div>
                    <div class="img-block"><a href="{{ url('product') }}/{{ $product->url }}"><img src="{{asset('products/'.$product->featured_img)}}"/></a></div>
                    <div class="text-center content-block">
                        <h3>{{$product->title}}</h3>
                        <div class="d-flex price-cart"><span class="price">QAR {{$product->unit_price}}</span><i class="fa fa-shopping-cart" onclick="addtocart({{$product->id}},1,{{$product->unit_price}})"></i></div>
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