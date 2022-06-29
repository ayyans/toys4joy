@extends('website.layouts.master')
@section('content')

<main>
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
        <div class="col-9 contact-col">
            <div class="for-desktop">
            @include('website.layouts.user_menu')  
            </div>
            <div class="d-flex contact-info">
                    <div class="content-block detail">
                        <h3>Contact Detail</h3>
                        <ul>
                            <li><strong>What'sapp Number:</strong> +974 600 05370</li>
                            <li><strong>Customer Service:</strong> +974 600 05970</li>
                            <li><strong>Customer Service:</strong> +974 600 05870</li>
                            <li><strong>Land Line:</strong> +974 444 14215</li>
                            <li><strong>Email ID:</strong>
                                marketing@toys4joy.com
                                <span>operation@toys4joy.com</span>
                                <span>info@toys4joy.com</span>
                            </li>
                            <li><strong>Address:</strong> Toys 4 joy, 7GJ3+766, Doha, Qatar</li>
                        </ul>
                    </div>
                <div class="content-block map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d901.9250610719338!2d51.5024664!3d25.2806672!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e45db773e60e063%3A0xf23502d4ac817c93!2sToys%204%20joy!5e0!3m2!1sen!2s!4v1655554050638!5m2!1sen!2s" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
@endsection