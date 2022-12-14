@extends('website.layouts.master')
@section('content')

<main class="thanks-feedback t-guest">
<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
    	<div class="col-6">
            <div class="text-center thanks-box">
                <h3>Thanks for shopping with</h3>
                <img src="{{asset('website/img/logo-t4j.png')}}">
                <p>One of our team member will contact you shortly to get your location & necessary information</p>
                <div class="text-center d-flex print">
                    <img src="{{asset('website/img/printer.png')}}">
                    <h4><a href="{{ url('generateinvoice') }}/{{ $orderid }}">Print my Receipt</a></h4>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>

</main>

@stop