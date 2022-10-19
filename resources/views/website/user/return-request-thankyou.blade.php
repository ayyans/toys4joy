@extends('website.layouts.master')
@section('content')
<main class="thanks-feedback t-guest">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="text-center thanks-box">
                    <h3>{{__('trans.Thanks You!')}}</h3>
                    <img src="{{asset('website/img/logo-t4j.png')}}">
                    <p>{{__('trans.Thank you for submitting the request one of our team members will get back to you shortly')}}</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
