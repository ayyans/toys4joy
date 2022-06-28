@extends('website.layouts.master')
@section('content')
<main class="home">
<div class="container-fluid">
    <div class="row">
    	<div class="col-3 categories-col">
            <div class="d-flex flex-column flex-shrink-0" >
                <div class="for-mobile mbl-banner">
                    <ul class="nav nav-pills nav-fill">
                      <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Best Offers</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Wish List</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">E-Gift Cards</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link">Your Points</a>
                      </li>
                    </ul>    
                    <img src="{{asset('website/img/t1.png')}}" class="img-fluid">
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
        <div class="col-6 middle-col">
            <div class="for-desktop">
            @include('website.layouts.user_menu')  
                <img src="{{asset('website/img/t1.png')}}" class="img-fluid">
            </div>    
            <!-- <div class="book-your-event">
            	<h1 class="text-center">BOOK YOUR EVENT NOW</h1>
                <div class="d-flex">
                	<div class="booking-cal d-flex justify-content-between">
                        <div class="day"><h2>Day</h2>
                            <div class="day-block digits"><h3><span>2</span></h3><h3><span>8</span></h3></div>
                        </div>
                        <div class="month"><h2>Month</h2>
                            <div class="month-block digits"><h3><span>1</span></h3><h3><span>1</span></h3></div>
                        </div>
                        <div class="year"><h2>Year</h2>
                            <div class="year-block digits"><h3><span>2</span></h3><h3><span>2</span></h3></div>
                        </div>
                        <div class="time"><h2>Time</h2><div><span>1 - 3</span><span>3 - 5</span></div><div><span>5 - 7</span><span>7 - 9</span></div></div>
                    </div>
                    <div class="book-now">
                        <img src="{{asset('website/img/balloons_birthday.png')}}" class="img-fluid">
                        <a href="#">Book Now</a>
                    </div>
                </div>
            </div> -->
            <div class="d-flex home-prod products-list">
                @foreach($products as $product)
                <div class="single">
                    @if($product->qty == 0)
                    <div class="availbility"><span>Out of Stock</span></div>
                    @endif

                    <div class="img-block"><a href="{{ url('product') }}/{{ $product->url }}"><img src="{{asset('products/'.$product->featured_img)}}"/></a></div>
                    <div class="text-center content-block">
                        <h3>{{$product->title}}</h3>
                        <div class="d-flex price-cart"><span class="price">QAR {{$product->unit_price}}</span><i class="fa fa-shopping-cart" onclick="addtocart({{$product->id}},1,{{$product->unit_price}})"></i></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-3 right-col">
            <div class="right-sidebar">
            <ul class="product-list">
                <li>
                    <a href="#" class="active">Top
                    <div class="content-box">
                        <div class="button1b">
                          <img src="{{asset('website/img/like.png')}}">
                          <div class="button1b-content">Like</div>
                        </div>
                    </div>
                    </a>
                </li>
                <li><a href="#">Brands</a></li>
                <li><a href="{{ route('website.products', 'best-seller') }}">Best Sellers</a></li>
                <li><a href="{{ route('website.products', 'new-arrival') }}">New Arrival</a></li>
                <li><a href="#">Best Offers</a></li>
            </ul>
                <h1 class="for-mobile age-range-title">Select Age Range</h1>
            <div class="age-range">
                <h1 class="for-desktop">Age Range</h1>
                <ul>
                    <li>
                        <input type="checkbox" id="24months">
                        <label for="24months">Birth to 24 Months</label>
                    </li>
                    <li>
                        <input type="checkbox" id="2-4years">
                        <label for="2-4years">02 to 04 Years</label>
                    </li>
                    <li>
                        <input type="checkbox" id="5-7years">
                        <label for="5-7years">05 to 07 Years</label>
                    </li>
                    <li>
                        <input type="checkbox" id="8-13years">
                        <label for="8-13years">08 to 13 Years</label>
                    </li>
                    <li>
                        <input type="checkbox" id="14years">
                        <label for="14years">14 Years & Up</label>
                    </li>
                </ul>
                <div class="price-range">
                  <h1>Select Price</h1>
                  <div id="slider-range"></div>
                  <div class="slider-labels">
                    <div class="caption">
                      <span id="slider-range-value1"></span>
                    </div>
                    <div class="caption">
                      <span id="slider-range-value2"></span>
                    </div>
                    <div class="caption-btn"><button class="go">G0</button></div>
                  </div>
                 
                      <form>
                        <input type="hidden" name="min-value" value="">
                        <input type="hidden" name="max-value" value="">
                      </form>
                   
                </div>
                    
            </div>
            <div class="upload-img">
                <div class="tooltip">
                    <a href="#">
                        <img src="{{asset('website/img/upload-image.png')}}" class="img-fluid">
                        <span class="tooltiptext">Upload image of the product you are looking for.</span>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</main>
@stop