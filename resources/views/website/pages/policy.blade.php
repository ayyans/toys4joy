@extends('website.layouts.master')
@section('content')
<main id="company-policy">
<div class="container-fluid">
    <div class="row">
        <div class="col-2 text-center for-mobile">
            <div class="com-policy-col">
                <h2>Company Policy</h2>
            	<img src="{{ url('website/img/cartoon.png') }}"/>
            </div>
        </div>
    	<div class="col-5">
            <div class="vertical-shake text-center icon-block">
                <div class="icon"><img src="{{ url('website/img/return-money.png') }}"/></div>
                <h2>Return and Exchange</h2>
            </div>
            <div class="vertical-shake text-center icon-block">
                <div class="icon"><img src="{{ url('website/img/reward-poiints.png') }}"/></div>
                <h2>Rewards Points Policy</h2>
            </div>
        </div>
        <div class="col-2 text-center for-desktop">
            <div class="com-policy-col">
                <h2>Company Policy</h2>
            	<img src="{{ url('website/img/cartoon.png') }}"/>
            </div>
        </div>
    	<div class="col-5">
            <div class="vertical-shake text-center icon-block">
                <div class="icon"><img src="{{ url('website/img/truck.png') }}"/></div>
                <h2>Delivery Policy</h2>
            </div>
            <div class="vertical-shake text-center icon-block">
                <div class="icon"><img src="{{ url('website/img/privacy-policy.png') }}"/></div>
                <h2>Privacy Policy</h2>
            </div>
        </div>
<!--        <div class="back-arrow"><a href="#"><img src="{{ url('website/img/back-arrow.png') }}"/><span>Back</span></a></div>-->
    </div>
</div>

</main>

@endsection