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
                    <h4>Rewards Points</h4>
                    <p>Toys 4 Joy offer unique Reward points in a great way to treat yourself!</p>
                    <p>Gain 5,000 Points by spending 5,000 QR and get Free Party for your birthday or any other your own celebration</p>
                    <p>The Cost of this party is 2,700 QR</p>
                    <p>That means you Saved 54% of your total purchase amount.</p>
                    <p>The party include the following:</p>
                    <ul>
                        <li>Magician</li>
                        <li>Mascot of your choice</li>
                        <li>Cake with your photo</li>
                        <li>Led Smoke Machine with Laser Stage light</li>
                        <li>Select your favourite game for activities</li>
                        <li>Balloons’ decoration of your favourite theme</li>
                    </ul>
                    <p>Start your purchase and earn reward points now!</p> 

                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection