@extends('website.layouts.master')
@section('content')
<main class="rewards-points">
<div class="container-fluid">
    <div class="row">
        <div class="col-3 categories-col">
            <div class="d-flex flex-column flex-shrink-0" >
                <div class="for-mobile mbl-banner">
                @include('website.layouts.user_menu') 
                    <!--<img src="{{asset('website/img/t1.png')}}" class="img-fluid">-->
                </div>
                <div class="categories mb-3">
                    <h2 class="for-desktop">{{__('trans.Categories')}}</h2>
                    @include('website.layouts.category_btn')
                    <ul class="nav nav-pills flex-column mb-auto menu for-desktop">
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
            <div class="text-box vision">
                <h4>{{__('policies.Vision')}}</h4>
                <p>{{__('policies.Number one Toys E-Commerce by providing best smooth shopping experience with easy checkout, free and fastest delivery, and unique online shopping features such as Loyalty Program, Wish List, and E-Gift Cards')}} </p>    
            </div>
            <div class="text-box mission">
                <h4>{{__('policies.Mission')}}</h4>
                <p>{{__("policies.To create the happiness in the heart of our lovely children and the smile on the face of their parents by providing branded high quality safe and innovative toys, with fastest &amp; free delivery service, with always best price")}}</p>    
            </div>
            <div class="text-box values">
                <h4>{{__('policies.Values')}}</h4>
                <ul>
                    <li>{{__('policies.Providing very special price for the kids who has Cancer, Autism, and all any other critical disease')}}</li>
                    <li>{{__('policies.Always provide the safe branding products for our lovely children')}}</li>
                    <li>{{__('policies.Use only environmental friendly bags non-Woven and oxo-biodegradable Bags')}}</li>
                </ul>    
            </div>
        </div>
        </div>
    </div>
</div>
</main>
@endsection
