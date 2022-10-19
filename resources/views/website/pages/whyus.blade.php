@extends('website.layouts.master')
@section('content')
<main id="why-us">
<div class="container-fluid">
    <div class="row">
        <h1 class="text-center">{{__('policies.Why US?')}}</h1>
    	<div class="col-6">
            <div class="content-block">
			<div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/mission.png') }}"/></div>
                    <a href="{{ url('terms-and-conditions') }}"><h4>{{__('policies.Our Mission, Vission and Values')}}</h4></a>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/shopping-bags.png') }}"/></div>
                    <h4>{{__('policies.Smooth online shopping with easy checkout')}}</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/best-price.png') }}"/></div>
                    <h4>{{__('policies.Everyday best price')}}</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/free-delivery.png') }}"/></div>
                    <h4>{{__('policies.Free & Fast delivery')}}</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/cash.png') }}"/></div>
                    <h4>{{__('policies.Cash or credit card on delivery')}}</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/environment-friendly.png') }}"/></div>
                    <h4>{{__('policies.Using Environmental Friendly Bags Non-Woven and oxo-biodegradable.')}}</h4>
                </div>    
            </div>
        </div>
    	<div class="col-6">
            <div class="content-block">
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/points-program.png') }}"/></div>
                    <h4>{{__('policies.1 QR = 2 Points')}}</br>
                    {{__('policies.2500 QR = 5000 Points')}}</br>
                    {{__('policies.When you reach 5000 Points you gain E Gift card in amount of 100 QR')}}</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/wishlist-cart.png') }}"/></div>
                    <h4>{{__('policies.Add your favourite toys to your Wish List, and share it with relatives and friends to help them buy your favourite gifts')}}</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/gift-card.png') }}"/></div>
                    <h4>{{__('policies.E-Gift cards to your loved ones')}}</h4>
                </div>
				<div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/gold_membership.png') }}"/></div>
                    <h4>{{__('policies.Golden Member Ship Card')}}</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/brand.png') }}"/></div>
                    <h4>{{__('policies.Brand, high quality and safe products for our lovely children')}}</h4>
                </div>
                <div class="d-flex list">
                    <div class="icon"><img src="{{ url('website/img/easy-return.png') }}"/></div>
                    <h4>{{__('policies.Easy return')}}</h4>
                </div>    
            </div>
        </div>
    </div>
</div>

</main>
@endsection
