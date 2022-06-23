@extends('website.layouts.master')
@section('content')

<main id="my-account" >
<div class="container-fluid">
    <div class="row">
        <div class="col-2"></div>
    	<div class="col-8 content-block">
            <div class="d-flex welcome-block">
                <img src="{{asset('website/img/user-pic.png')}}"/>
                <h2>Welcome Back Dear {{Auth::user()->name}}</h2>
            </div>

                <div class="ac-btn row">
                    <div class="col-4">
                        <div class="ac-button"><a href="{{route('website.addAddressInfo')}}">Add/Change Address</a></div>
                        <div class="ac-button"><a href="{{route('website.addCardInfo')}}">Add/Change Credit Card Information</a></div>
                        <div class="ac-button"><a href="{{route('website.changepassword')}}">Change Password</a></div>
                        <div class="ac-button"><a href="#">Change Mobile Number</a></div>
                    </div>
                    <div class="col-4">
                        <div class="ac-button my-profile"><a href="{{route('website.myprofile')}}">My Profile</a></div>
                        <div class="ac-button siblings"><a href="#">My Siblings</a></div>
                    </div>

                    <div class="col-4">
                        <div class="ac-button"><a href="{{route('website.orderhistory')}}">My Order's History</a></div>
                        <div class="ac-button"><a href="#">My Points</a></div>
                        <div class="ac-button"><a href="{{route('website.mywishlist',[encrypt(Auth::user()->id)])}}">My Wish List</a></div>
                        <div class="ac-button"><a href="#">Request Return Items</a></div>
                        <div class="ac-button"><a  href="{{ route('website.logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"role="button">Log out</a>
                                                     <form id="logout-form" action="{{ route('website.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                                     </div>
                    </div>
                </div>
            </div>
            
    
        <div class="col-2"></div>
  </div>      
</div>

</main>

@stop