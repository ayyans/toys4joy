@extends('website.layouts.master')
@section('content')

<main id="change-mob-num" class="change-pswrd">
<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
    	<div class="col-6">
            <div class="discount-block">
                <h4>Change your password</h4>
                <div class="mb-3">
                	<label>Old Password <span style="color:#ff0000">*</span></label>
                	<div class="d-flex phone-dropdown">
                        <div class="col-2">
                            <div class="lock"><img src="{{asset('website/img/lock.png')}}"></div>
                        </div>
                        <div class="col-10 pswrd-input"><input type="password"><img src="{{asset('website/img/eye.png')}}"></div>
                    </div>
                </div>
                <div class="mb-3">
                	<label>New Password <span style="color:#ff0000">*</span></label>
                	<div class="d-flex phone-dropdown">
                        <div class="col-2">
                            <div class="lock"><img src="{{asset('website/img/lock.png')}}"></div>
                        </div>
                        <div class="col-10 pswrd-input"><input type="password"><img src="{{asset('website/img/eye.png')}}"></div>
                    </div>
                </div>
                <div class="mb-3">
                	<label>Confirm Password <span style="color:#ff0000">*</span></label>
                	<div class="d-flex phone-dropdown">
                        <div class="col-2">
                            <div class="lock"><img src="{{asset('website/img/lock.png')}}"></div>
                        </div>
                        <div class="col-10 pswrd-input"><input type="password"><img src="{{asset('website/img/eye.png')}}"></div>
                    </div>
                </div>
                <div class="btn pinkbg-img"><a href="#">Update</a></div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
</main>

@stop