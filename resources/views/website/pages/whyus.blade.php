@extends('website.layouts.master')
@section('content')
<main id="why-us">
<div class="container-fluid">
    <div class="row">
        <h1 class="text-center">Why US?</h1>
    	<div class="col-6">
            <div class="content-block">
			<div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/mission.png') }}"/></div>
                    <a href="https://talent-house.online/toy4joy/terms-and-conditions.html"><h4>Our Mission, Vission and Values</h4></a>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/shopping-bags.png') }}"/></div>
                    <h4>Smooth online shopping with easy checkout</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/best-price.png') }}"/></div>
                    <h4>Everyday best price</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/free-delivery.png') }}"/></div>
                    <h4>Free & Fast delivery</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/cash.png') }}"/></div>
                    <h4>Cash or credit card on delivery</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/environment-friendly.png') }}"/></div>
                    <h4>Using Environmental Friendly Bags Non-Woven and oxo-biodegradable.</h4>
                </div>    
            </div>
        </div>
    	<div class="col-6">
            <div class="content-block">
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/points-program.png') }}"/></div>
                    <h4>Points program, free VIP kids party (2,700QR- 54% OFF)</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/wishlist-cart.png') }}"/></div>
                    <h4>Add your favorite toys to your Whislist, and share it with the one you loved to help them buy your favorite gifts</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/gift-card.png') }}"/></div>
                    <h4>E-Gift cards to the ones you loved</h4>
                </div>
				<div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/gold_membership.png') }}"/></div>
                    <h4>Golden Member Ship Card</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/brand.png') }}"/></div>
                    <h4>Brand, high quality and safe products for our lovely children</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/easy-return.png') }}"/></div>
                    <h4>Easy return</h4>
                </div>    
            </div>
        </div>
    </div>
</div>

</main>
@endsection