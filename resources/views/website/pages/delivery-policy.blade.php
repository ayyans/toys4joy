@extends('website.layouts.master')
@section('content')
<main class="rewards-points">
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
            <div class="t-and-c-text">
                <div class="content">
                    <h4>Delivery Policy</h4>
                    <p>Toys 4 Joy is the only company that make free delivery without any limit amount of purchasing, we're committed to making our delivery process as quick and pleasant as possible, because we know how important it is that your goods arrive on time and in perfect condition.</p>
                    <p>To provide the utmost satisfaction, majority of deliveries are carried by our own fleet and Toys 4 Joy personnel.</p>
                    <p>Free delivery for each order </p>
                    <ul>
                        <li>Free delivery for all orders above 99 QR within 3 hours.</li>
                        <li>Free delivery for all orders below 99 QR within 24 hours.</li>
                        <li>Free delivery and assembling on products that includes assembly requirement within 24 to 48 hours.</li>
                    </ul>
                    <p><strong>Note: All operation in Toys 4 Joy closed before, during, and after one hour of Friday Pray.</strong></p> 

                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection