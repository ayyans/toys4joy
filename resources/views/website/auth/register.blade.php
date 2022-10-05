@extends('website.layouts.master')
@section('content')
<style type="text/css">
    .iti{
        width: 100%;
    }
</style>
<link rel="stylesheet" href="{{ url('website/phone/css/intlTelInput.css') }}">
<main id="register-form" class="account main-bg">
<div class="container-fluid">
    <div class="row">
        <div class="col-3 categories-col">
            <div class="d-flex flex-column flex-shrink-0" > 
                <div class="for-mobile mbl-banner">
                @include('website.layouts.user_menu') 
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
            <form action="{{route('website.registerProcess')}}" method="post" id="registerFrm">
              @csrf
            <div class="form-group">
             <div class="form-inner">    
              <h3 class="text-center">{{__("trans.Register Now!")}}</h3>
                <div class="row">
                    <div class="col-12">
                        <label>{{__('trans.Write name here')}}<span>*</span></label>
                        <input type="text" name="name" placeholder="{{__('trans.Write name here')}} " class="customerReg">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label>{{__('trans.Email Address')}}<span>*</span></label>
                        <input type="email" name="email" placeholder="{{__('trans.Email Address')}}" class="customerReg">
                        @if($errors->has('email'))
                        <span style="display: block;text-align: left;" class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-12">
                        <label style="margin-bottom: 5px;">{{__('trans.Phone Number')}}<span>*</span></label>
                        <input id="phone" class="customerReg" name="phone" type="tel">
                        @if($errors->has('mobile'))
                        <span style="display: block;text-align: left;" class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-12">
                        <label>{{__('trans.Password')}}<span>*</span></label>
                        <input type="password" name="password" placeholder="{{__('trans.Password')}}" class="customerReg" id="password">
                    </div>
                    <div class="col-12">
                        <label>{{__('trans.Confirm Password')}}<span>*</span></label>
                        <input type="password" name="cnfpassword" placeholder="{{__('trans.Password')}}" class="customerReg" id="cnfpassword">
                        <div id="wrngpsw"></div>
                    </div>
                </div>
                
              <button  class="registerbtn">{{__('trans.Register')}}</button>
            </div>
            </form>
            </div>    
        </div>
        
    </div>
</div>

</main>
<script src="{{ url('website/phone/js/intlTelInput.js') }}"></script>
<script>
    var input = document.querySelector("#phone");
    const iti = window.intlTelInput(input, {
        autoHideDialCode: true,
        formatOnDisplay: true,
        hiddenInput: "mobile",
        placeholderNumberType: "MOBILE",
        preferredCountries: ['qa'],
        separateDialCode: true,
        utilsScript: "{{ url('website/phone/js/utils.js') }}",
    });
  </script>
@endscript


@push('otherscript')
<script>
  $(function(){
    $("button.registerbtn").click(function(e){
        $('input[name=mobile]').val( iti.getNumber() );
            e.preventDefault();
            var isValid = true;
        $('input.customerReg').each(function() {
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
        
        
      var password = $("#password").val();
      var cnfpassword = $("#cnfpassword").val();
    
      if(password!=cnfpassword){

        $("#cnfpassword").css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
                $("#wrngpsw").append('<p style="color:red">confirm password should be same as password</p>')
                return false;
      }else{
        $("#cnfpassword").css({
                    "border": "",
                    "background": "",
                    
                });
                $("#wrngpsw").remove();
      }
       

        if (isValid == false){ 
            e.preventDefault();
        }
        else {
             $('form#registerFrm').submit();
        }
    });
  })
</script>

<script>
  $("input#cnfpassword").blur(function(){
      var password = $("#password").val();
      var cnfpassword = $(this).val();
    
      if(password!=cnfpassword){

        $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE",
                    
                });
                $("#wrngpsw").html('<p style="color:red">confirm password should be same as password</p>')
                return false;
      }else{
        $(this).css({
                    "border": "",
                    "background": "",
                    
                });
                $("#wrngpsw").remove();
      }
  })
</script>
@endpush
