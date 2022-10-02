@extends('website.layouts.master')
@section('content')
<main id="login-form" class="account main-bg">
<div class="container-fluid">
    <div class="row">
        <div class="col-3 categories-col">
            <div class="d-flex flex-column flex-shrink-0" > 
                <div class="for-mobile mbl-banner">
                    <@include('website.layouts.user_menu') 
                    
                </div>
                <div class="categories">
                    <h2 class="for-desktop">{{__('trans.Categories')}}</h2>
                    
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
              <h3 class="text-center">Reset Password!</h3>
              <p class="text-center">Please enter your new password.</p>
              <form action="{{route('website.set_reset_password')}}" method="POST" id="loginFrmH">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="password" name="password" placeholder="Password" class="logininp @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input type="password" name="password_confirmation" placeholder="Repeat Password" class="logininp @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" required>
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              <button class="loginbtn">Reset Password</button>
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
            $('form#loginFrmH').submit();
        }
    });
  })
</script>
@endpush
