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
            <div class="yellow r-btn">
                <input type="radio" id="100QR" name="radio" value="option1">
                <label for="100QR" class="yellow-text">100 QR</label>
            </div>
            <div class="blue r-btn">
                <input type="radio" id="200QR" name="radio" value="option2">
                <label for="200QR" class="blue-text">200 QR</label>
            </div>
            <div class="green r-btn">
                <input type="radio" id="250QR" name="radio" value="option3">
                <label for="250QR" class="green-text">250 QR</label>
            </div>
            <div class="pink r-btn">
                <input type="radio" id="500QR" name="radio" value="option4">
                <label for="500QR" class="pink-text">500 QR</label>
            </div>
            <div class="gray r-btn">
                <input type="radio" id="other" name="radio" value="option5">
                <label for="other" class="gray-text">Other</label>
                <input type="text">
            </div>
        </form>    
        </div>
        
        <div class="col-4 text-center">
            <div class="input-security">
            	<h2>Security Code</h2>
				<div class="d-flex">               
                	<input type="text">
                	<img src="{{asset('website/img/cvv.png')}}"/>
                </div>
                <label>Enter the security code</label>
            </div>
            <div class="pay-as-member">
                <div class="text-center">
                    <div class="member">
                        <a href="#">Pay as Member</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
</div>
@stop