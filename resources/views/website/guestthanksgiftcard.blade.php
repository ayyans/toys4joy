@extends('website.layouts.master')
@section('content')

<main class="thanks-feedback t-guest">
<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
    	<div class="col-6">
            <div class="text-center thanks-box">
                <h3>{{__('trans.Thanks for Purchasing Gift Card')}}</h3>
                <img src="{{asset('website/img/logo-t4j.png')}}">
                <p>{{__('trans.One of our team member will contact you shortly to get your location & necessary information')}}</p>
                <div class="text-center d-flex print">
                    <img src="{{asset('website/img/printer.png')}}">
                    <h4><a href="{{ url('generateinvoicegiftcard') }}/{{ $order_number }}">Print my Receipt</a></h4>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>

</main>

@stop
