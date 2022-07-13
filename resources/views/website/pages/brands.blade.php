@extends('website.layouts.master')
@section('content')
	<main class="our-brands">
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
        <div class="col-9">
            <div class="for-desktop">
            @include('website.layouts.user_menu')  
            </div>
            <div class="d-flex brands-logo">
            	@foreach(DB::table('brands')->where('status' , 2)->get() as $r)
                <div class="single">
                    <a style="color: black;text-decoration: none;" href="{{ url('brand') }}/{{ $r->brand_name }}">
                        @if($r->logo)
                        <div class="img-block">
                            <img src="{{ url('uploads') }}/{{ $r->logo }}"/>
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
    </div>
</div>

</main>
@endsection