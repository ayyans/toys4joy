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
                    <p>1 QR = 2 Points.</p>
                    <p>2500 QR = 5000 Points.</p>
                    <p>When you reach 5000 Points you gain E Gift card in amount of 100 QR</p>
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
