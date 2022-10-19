@extends('website.layouts.master')
@section('content')

<main class="thanks-feedback t-guest">
<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
    	<div class="col-6">
            <div class="text-center thanks-box">
                <div class="d-flex reg"><img src="{{asset('website/img/green-check.png')}}"><h3>{{__('trans.Thanks for registering with')}}</h3></div>
                <img src="{{asset('website/img/logo-t4j.png')}}">
                <p>{{__('trans.You will receive an email shortly to confirm this registration')}}</p>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>

</main>

@stop
