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
                        <a class="nav-link" aria-current="page" href="{{ route('website.bestsellers') }}">Best Offers</a>
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
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                      </div>
                      <div class="carousel-inner">
                        @foreach(DB::table('homepagebanners')->where('status' , 2)->get() as $r)
                        <div class="carousel-item @if ($loop->first) active @endif">
                          <img src="{{ url('uploads') }}/{{ $r->image }}" class="img-fluid">
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
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                  </div>
                  <div class="carousel-inner">
                    @foreach(DB::table('homepagebanners')->where('status' , 2)->get() as $r)
                    <div class="carousel-item @if ($loop->first) active @endif">
                      <img src="{{ url('uploads') }}/{{ $r->image }}" class="img-fluid">
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
            </div>    
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
                <li><a href="{{ route('website.brands') }}">Brands</a></li>
                <li><a href="{{ route('website.bestoffers') }}">Best Sellers</a></li>
                <li><a href="{{ route('website.bestsellers') }}">Best Offers</a></li>
            </ul>
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
            <div class="upload-img">
                <div class="tooltip">
                    <a href="#">
                        <button type="button" class="btn btn-primary modal-toggle" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <img src="{{asset('website/img/upload-image.png')}}" class="img-fluid">
                        </button>    
                        <span class="tooltiptext">Upload image of the product you are looking for.</span>
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
    </div>
</div>
</main>
@endsection

@push('otherscript')
  <script>
    $(function() {
      $('#filter-go').on('click', function() {
        $('#filter').submit();
      });
    });
  </script>
@endpush