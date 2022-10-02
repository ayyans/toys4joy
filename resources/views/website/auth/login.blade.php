@extends('website.layouts.master')
@section('content')
<main id="login-form" class="account main-bg">
<div class="container-fluid">
    <div class="row">
        <div class="col-3 categories-col for-desktop">
            <div class="d-flex flex-column flex-shrink-0" > 
                <div class="for-mobile mbl-banner">
                   
                    @include('website.layouts.user_menu')
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
              <h3 class="text-center">{{__('trans.Joy is yet to begin!')}} </h3>
              <p class="text-center">{{__('trans.Enter your username & password to enjoy the bunch of awesome benefits!')}}</p>
              <form action="{{route('website.login_process')}}" method="POST" id="loginFrmH">
                @csrf
                <input type="text" name="email" placeholder="{{__('trans.Username')}}" class="logininp @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                <input type="password" name="password" placeholder="{{__('trans.Password')}}" class="logininp @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                <div class="forgot-password"><a href="{{ route('website.forgot_password') }}">{{__('trans.Forgot Password?')}}</a></div>
              <button class="loginbtn">{{__("trans.Login")}}</button>
            </form>
            <div class="dnt-account"><span>{{__("trans.Don't have an account?") }} <a href="{{route('website.register')}}">{{__('trans.Register Now.') }}</a></span></div>
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
            $('form#loginFrmH').submit();
        }
    });
  })
</script>
@endpush
