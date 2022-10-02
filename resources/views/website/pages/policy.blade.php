@extends('website.layouts.master')
@section('content')
<main id="company-policy">
<div class="container-fluid">
    <div class="row">
        <div class="col-2 text-center for-mobile">
            <div class="com-policy-col">
                <h2>{{__('trans.Company Policy')}}</h2>
            	<img src="{{ url('website/img/cartoon.png') }}"/>
            </div>
        </div>
    	<div class="col-5">
            <a href="{{ url('return-policy') }}">
                <div class="vertical-shake text-center icon-block">
                    <div class="icon"><img src="{{ url('website/img/return-money.png') }}"/></div>
                    <h2>{{__('trans.Return and Exchange')}}</h2>
                </div>
            </a>
            <a href="{{ url('rewards-policy') }}">
                <div class="vertical-shake text-center icon-block">
                    <div class="icon"><img src="{{ url('website/img/reward-poiints.png') }}"/></div>
                    <h2>{{__('trans.Rewards Points Policy')}}</h2>
                </div>
            </a>
        </div>
        <div class="col-2 text-center for-desktop">
            <div class="com-policy-col">
                <h2>{{__('trans.Company Policy')}}</h2>
            	<img src="{{ url('website/img/cartoon.png') }}"/>
            </div>
        </div>
    	<div class="col-5">
            <a href="{{ url('delivery-policy') }}">
            <div class="vertical-shake text-center icon-block">
                <div class="icon"><img src="{{ url('website/img/truck.png') }}"/></div>
                <h2>{{__('trans.Delivery Policy')}}</h2>
            </div>
            </a>
            <a href="{{ url('privacy-policy') }}">

            <div class="vertical-shake text-center icon-block">
                <div class="icon">
                    <img src="{{ url('website/img/privacy-policy.png') }}"/>
                </div>
                <h2>{{__('trans.privacy Policy')}}</h2>
            </div>
            </a>
        </div>
    </div>
</div>
</main>
@endsection
