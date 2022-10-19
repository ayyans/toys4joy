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
                <div class="content">
                    <h4>{{__('policies.Rewards Points')}}</h4>
                    <p>{{__('policies.Toys 4 Joy offer unique Reward points in a great way to treat yourself!')}}</p>
                    <p>{{__('policies.Our point system is easy!')}}</p>
                    <p>{{__('policies.1 QR = 2 Points.')}}</p>
                    <p>{{__('policies.2500 QR = 5000 Points.')}}</p>
                    <p>{{__('policies.When you reach 5000 Points you gain E Gift card in amount of 100 QR')}}</p>
                    
                    <p>{{__('policies.Start your purchase and earn reward points now!')}}</p> 

                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
