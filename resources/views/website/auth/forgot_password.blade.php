@extends('website.layouts.master')
@section('content')
<main id="login-form" class="account main-bg">
<div class="container-fluid">
    <div class="row">
        <div class="col-3 categories-col">
            <div class="d-flex flex-column flex-shrink-0" > 
                <div class="for-mobile mbl-banner">
                    <@include('website.layouts.user_menu') 
                    <!--<img src="{{asset('website/img/t1.png')}}" class="img-fluid">-->
                </div>
                <div class="categories">
                    <h2 class="for-desktop">Categories</h2>
                    <ul class="nav nav-pills flex-column mb-auto menu">
                    @include('website.layouts.category_menu')
                                 
                    </ul>
                </div>
            </div>
        </div>
    	<div class="col-9 form-col">
            <div class="for-desktop">
                @include('website.layouts.user_menu') 
            </div>
            
            <div class="form-group">
                <div class="form-inner">
                    <h3 class="text-center">Forgot password?</h3>
                    <p class="text-center fs-6">Enter the email address associated with your account and we'll send you a link to reset your password.</p>
                    <form action="{{route('website.send_forgot_password')}}" method="POST" id="PwdRstFrmH">
                        @csrf
                        <input type="email" name="email" placeholder="Email" class="logininp @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <button class="loginbtn">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
@stop

@push('otherscript')
<script>
  $(function(){
    $("button.loginbtn").click(function(e){
            e.preventDefault();
            var isValid = true;
        $('input.logininp').each(function() {
            if ($.trim($(this).val()) == '') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });      
       

        if (isValid == false){ 
            e.preventDefault();
        }
        else {
            $('form#PwdRstFrmH').submit();
        }
    });
  })
</script>
@endpush
