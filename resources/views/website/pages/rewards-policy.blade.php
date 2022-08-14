@extends('website.layouts.master')
@section('content')
<main class="rewards-points">
<div class="container-fluid">
    <div class="row">
        <div class="col-3 categories-col">
            <div class="d-flex flex-column flex-shrink-0" >
                <div class="for-mobile mbl-banner">
                @include('website.layouts.user_menu')    
                </div>
                <div class="categories">
                    <h2 class="for-desktop">Categories</h2>
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
                    <p>Our point system is easy!</p>
                    <p>Gain 5,000 points and get free 100 QR e-gift voucher.</p>
                    <p>100 QR spent is equivalent to 2 points.</p>
                    <!--<p>The party include the following:</p>
                    <ul>
                        <li>Magician</li>
                        <li>Mascot of your choice</li>
                        <li>Cake with your photo</li>
                        <li>Led Smoke Machine with Laser Stage light</li>
                        <li>Select your favourite game for activities</li>
                        <li>Balloons’ decoration of your favourite theme</li>
                    </ul>-->
                    <p>Start your purchase and earn reward points now!</p> 

                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
