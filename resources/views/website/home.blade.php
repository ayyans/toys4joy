@extends('website.layouts.master')
@section('content')
<main class="home">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2 col-md-2 col-xl-2 categories-col">
            <div class="d-flex flex-column flex-shrink-0" >
             
                <div class="categories for-desktop">
                    <h2 class="for-desktop">Categories</h2>
                    
                    <ul class="nav nav-pills flex-column mb-auto menu">
                     @include('website.layouts.category_menu')
                      
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 middle-col">
            <div class="">
            @include('website.layouts.user_menu')  
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                
                  <div class="carousel-indicators">
                      @php
                     $i = 0;
                     @endphp
                      @foreach(DB::table('homepagebanners')->where('status' , 2)->get() as $r)
                      @if ($i==0)
                      <button data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                      @else
                      <button data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i}}"></button>
                      @endif 
                      @php 
                      $i++;
                      @endphp
                        @endforeach
                        
                </div>
                  <div class="carousel-inner">
                    @foreach(DB::table('homepagebanners')->where('status' , 2)->get() as $r)
                    
                    <div class="carousel-item @if ($loop->first) active @endif">
                    <a href="{{ url('') }}/{{ $r->url }}">
                    <img src="{{ url('uploads') }}/{{ $r->image }}" class="lazyload img-fluid" data-src="{{ url('uploads') }}/{{ $r->image }}"  style="width: 100%;">
                    </a>
                    </div>
                    
                    @endforeach
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
                <div class="categories for-mobile mt-3">
                    <h2 class="for-desktop">Categories</h2>
                    
                    <ul class="nav nav-pills flex-column mb-auto menu">
                     @include('website.layouts.category_menu')
                      
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="col-sm-2 col-md-2 col-xl-2 right-col">
            <div class="right-sidebar">
            <!--<ul class="product-list">
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
                <li><a href="{{ route('website.brands') }}">Brands</a></li>
                <li><a href="{{ route('website.bestsellers') }}">Best Sellers</a></li>
                <li><a href="{{ route('website.newarrivals') }}">New Arrivals</a></li>
            </ul>-->
                <h1 class="for-mobile age-range-title">Select Age Range</h1>
            <div class="age-range">
              <form id="filter" action="{{ route('website.products-filter') }}">
                <h1 class="for-desktop">Age Range</h1>
                <ul>
                    <li>
                        <input type="checkbox" id="24months" name="24months">
                        <label for="24months">Birth to 24 Months</label>
                    </li>
                    <li>
                        <input type="checkbox" id="2-4years" name="2_4years">
                        <label for="2-4years">02 to 04 Years</label>
                    </li>
                    <li>
                        <input type="checkbox" id="5-7years" name="5_7years">
                        <label for="5-7years">05 to 07 Years</label>
                    </li>
                    <li>
                        <input type="checkbox" id="8-13years" name="8_13years">
                        <label for="8-13years">08 to 13 Years</label>
                    </li>
                    <li>
                        <input type="checkbox" id="14years" name="14years">
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
                    <div class="caption-btn"><button class="go" id="filter-go">G0</button></div>
                  </div>
                  <input type="hidden" name="min_value" id="filter-min-value">
                  <input type="hidden" name="max_value" id="filter-max-value">
                </div>
              </form>
            </div>
            
        </div>
        </div>
    </div>
    <!--new section-->
<section class="row mt-3">
<div class="col-sm-2 col-md-2 col-xl-2 mb-5">
<div class="row">
<div class="owl-carousel-single-picture owl-carousel owl-theme mt-3" style="height: fit-content;">
<div class="item "><img class="img-widget img-animate" src="{{asset('uploads/ad-1.png')}}"></div>
<div class="item "><img class="img-widget img-animate" src="{{asset('uploads/ad-3.png')}}"></div>
<div class="item "><img class="img-widget img-animate" src="{{asset('uploads/ad-4.png')}}"></div>
<div class="item "><img class="img-widget img-animate" src="{{asset('uploads/ad-5.png')}}"></div>
</div>
</div>
</div>
<div class="col-md-8 middle-col mt-3">
  <!--seection-->
<div class="section-title"><h3>Best Sellers</h3></div>
<div class="row">
<div class="owl-carousel-features owl-carousel owl-theme">
@foreach($bestsellers as $product)
  <div class="item single single-home-card">
      @if($product->qty == 0)
      <div class="availbility"><span>Out of Stock</span></div>
      @elseif($product->discount)
      @php
        $percent = (($product->unit_price - $product->discount)*100) /$product->unit_price ;
      @endphp
      <div class="availbility"><span>{{ number_format((float)$percent, 2, '.', '') }}% OFF </span></div>
      @endif
      <div class="img-block"><a href="{{ url('product') }}/{{ $product->url }}"><img src="{{asset('products/'.$product->featured_img)}}" class="lazyload" data-src="{{asset('products/'.$product->featured_img)}}"/></a></div>
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
            <i class="fa fa-solid @if(DB::table('wishlists')->where('cust_id' , Auth::user()->id)->where('prod_id' , $product->id)->count() > 0) fa-heart @else fa-heart-o @endif" id="addwishlist" onclick="addtowishlist({{$product->id}})"></i>
            @else
            <a href="{{ url('login') }}">
            <i class="fa fa-heart"></i>
           </a>
           @endif
            </span>
            
          </div>
      </div>
  </div>
  @endforeach
</div>
</div>
<div class="container">
  <div class="row">
    <div class="col text-center">
      <a href="{{ route('website.bestsellers') }}" class="btn btn-outline-primary outlined">View more</a>
    </div>
  </div>
</div>
<!--section-->

<!--section-->
<div class="section-title"><h3>New arrivals</h3></div>
<div class="row">
<div class="owl-carousel-features owl-carousel owl-theme">
@foreach($newarrivals as $product)
  <div class="item single single-home-card">
      @if($product->qty == 0)
      <div class="availbility"><span>Out of Stock</span></div>
      @elseif($product->discount)
      @php
        $percent = (($product->unit_price - $product->discount)*100) /$product->unit_price ;
      @endphp
      <div class="availbility"><span>{{ number_format((float)$percent, 2, '.', '') }}% OFF </span></div>
      @endif
      <div class="img-block"><a href="{{ url('product') }}/{{ $product->url }}"><img src="{{asset('products/'.$product->featured_img)}}" class="lazyload" data-src="{{asset('products/'.$product->featured_img)}}"/></a></div>
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
            <i class="fa fa-solid @if(DB::table('wishlists')->where('cust_id' , Auth::user()->id)->where('prod_id' , $product->id)->count() > 0) fa-heart @else fa-heart-o @endif" id="addwishlist" onclick="addtowishlist({{$product->id}})"></i>
            @else
            <a href="{{ url('login') }}">
            <i class="fa fa-heart"></i>
           </a>
           @endif
            </span>
            
          </div>
      </div>
  </div>
  @endforeach
</div>
</div>
<div class="container">
  <div class="row">
    <div class="col text-center">
      <a href="{{ route('website.newarrivals') }}" class="btn btn-outline-primary outlined">View more</a>
    </div>
  </div>
</div>
<!--section-->
 <!--seection-->
 <div class="section-title"><h3>Our Brands</h3></div>
<div class="row">
<div class="owl-carousel-brands owl-carousel owl-theme">
@foreach(DB::table('brands')->where('status' , 2)->limit(10)->get() as $r)
<div class="single">
    <a style="color: black;text-decoration: none;" href="{{ url('brand') }}/{{ $r->brand_name }}">
        @if($r->logo)
        <div class="img-block">
            <img src="{{ url('uploads') }}/{{ $r->logo }}" class="lazyload" data-src="{{ url('uploads') }}/{{ $r->logo }}"/>
        </div>
        @else
        <div class="img-block">
            <h2 style="font-size: 20px;">{{ $r->brand_name }}</h2>
        </div>
        @endif
    </a>
</div>
@endforeach
</div>
</div>
<div class="container">
  <div class="row">
    <div class="col text-center">
      <a href="{{ route('website.brands') }}" class="btn btn-outline-primary outlined">View more</a>
    </div>
  </div>
</div>
<!--section-->

<!--banner-->
<div class="row">
  <div class="banner-desktop">
  <div class="owl-carousel-single-banner owl-carousel owl-theme ">
<div class="item single"><img class="img-widget lazyload" style="height: fit-content;;" src="{{asset('uploads/banner1-01.png')}}" data-src="{{asset('uploads/banner1-01.png')}}"></div>
  </div>

  </div>

</div>
<!--banner-->  
</div>
<div class="col-sm-2 col-md-2 col-xl-2 right-col">
<div class="right-sidebar">
<div class="upload-img">
                <div class="tooltip">
                    <a href="#" class="share-price-button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <button type="button" class="btn btn-primary modal-toggle share-price-button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <img src="{{asset('website/img/upload-image.png')}}" class="img-fluid">
                        </button>    
                        <span class="row tooltiptext_fixed">Share products & prices you wish</span>
                    </a>
                </div>
                
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Please Fill out the Form Below</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form enctype="multipart/form-data" method="POST" action="{{ route('website.submitformlookingfor') }}">
                            @csrf
                          <div class="mb-3">
                            <label for="exampleInputName1" class="form-label">Your Name</label>
                            <input type="text" required class="form-control" name="name" aria-describedby="nameHelp">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" required class="form-control" name="email" aria-describedby="emailHelp">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputPhone1" class="form-label">Phone Number</label>
                            <input type="tel" required class="form-control" name="phonenumber">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputMessage1" class="form-label">Your Message</label>
                              <textarea class="form-control" name="message"></textarea>
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputUpload1" class="form-label">Upload Image</label>
                            <input required type="file" class="form-control" name="image">
                          </div>
                          <button type="submit" class="btn btn-primary guest">Submit</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal -->
</div>

</div>

</div>



</section>

    <!--end section-->
  
</div>
<img src="{{asset('website/img/animation.gif')}}" class="bg-startup-animation" style="display:none;">
</main>
@endsection

@push('otherscript')
  <script>
    $(function() {
      // filter
      $('#filter-go').on('click', function() {
        $('#filter').submit();
      });

      // hide 4th product on big screens
      const hideLastProduct = () => {
        const width = $(window).width();
        if (width >= 480) {
          $('.single').last().hide();
        } else {
          $('.single').last().show();
        }
      };
      hideLastProduct();
      $(window).on('resize', function() {
        hideLastProduct();
      })
      //the timer for the starting animation
      setTimeout(function() {
        $('.bg-startup-animation').css('display','none');
    }, 4000);
    });
  </script>
@endpush
