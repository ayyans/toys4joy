@extends('website.layouts.master')
@section('content')
<div class="egift-card-guest-page egift-card-member-page">
<main  id="pay-as-guest">
<div class="container-fluid">
    <div class="row">
        <div class="text-center green-text title"><h2>Buy E-Gift Cards to the ones you loved.</h2></div>
    	<div class="col-4">
            <div class="img-box">
                <img src="{{asset('website/img/toy-gift-box.png')}}"/>
            </div>
        </div>
        
        <div class="col-4 text-center">
        <form class="qr-price-select">
            <div class="row">
                @foreach(DB::table('giftcards')->where('status' , 2)->get() as $r) 
                <div class="col-md-6">
                    
                    <div class="green r-btn">
                        <input type="radio" id="card{{  $r->id }}" name="radio" value="option3">
                        <label for="card{{  $r->id }}" class="green-text">{{ $r->price }} QR</label>
                    </div>
                    
                </div>
                @endforeach
                <div class="col-md-12">
                    <div class="gray r-btn">
                        <input type="radio" id="other" name="radio" value="option5">
                        <label for="other" class="gray-text">Other</label>
                        <input type="text">
                    </div>
                </div>
            </div>
        </form>    
        </div>
        
        <div class="col-4 text-center">
            <div class="pay-as-member">
                <div class="text-center">
                    <div class="member">
                        <a href="#">Pay by Debit/Credit Card</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
</div>
@stop