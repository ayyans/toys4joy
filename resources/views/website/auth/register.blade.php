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
                    <ul class="nav nav-pills nav-fill">
                      <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Best Offers</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Wish List</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">E-Gift Cards</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link">Your Points</a>
                      </li>
                    </ul>
                </div>
                <div class="categories">
                    <h2 class="for-desktop">Categories</h2>
                    <h2 class="for-mobile">Select Category</h2>
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
              <h3 class="text-center">Register Now!</h3>
                <div class="row">
                    <div class="col-12">
                        <label>Name<span>*</span></label>
                        <input type="text" name="name" placeholder="Write name here" class="customerReg">
                    </div>
                    <div class="col-12">
                        <label>Email<span>*</span></label>
                        <input type="email" name="email" placeholder="Write email here" class="customerReg">
                    </div>
                    <div class="col-12">
                        <label style="margin-bottom: 5px;">Phone<span>*</span></label>
                        <input id="phone" class="customerReg" name="phone" type="tel">


                        <input type="hidden" name="mobilenumber" id="mobilenumber">
                    </div>
                    <div class="col-12">
                        <label>Password<span>*</span></label>
                        <input type="password" name="password" placeholder="Password" class="customerReg" id="password">
                    </div>
                    <div class="col-12">
                        <label>Confirm Password<span>*</span></label>
                        <input type="password" name="cnfpassword" placeholder="Password" class="customerReg" id="cnfpassword">
                        <div id="wrngpsw"></div>
                    </div>
                </div>
                
              <button  class="registerbtn">Register</button>
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
    window.intlTelInput(input, {
      // allowDropdown: false,
       autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      formatOnDisplay: true,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      hiddenInput: "full_phone",
      // initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      placeholderNumberType: "MOBILE",
      preferredCountries: ['qa'],
      separateDialCode: true,
      utilsScript: "{{ url('website/phone/js/utils.js') }}?1638200991544",
    });
  </script>
@stop


@push('otherscript')
<script>
  $(function(){
    $("button.registerbtn").click(function(e){
        var txt = $('.iti__selected-dial-code').text();
        var phone = $('#phone').val();


        $('#mobilenumber').val(txt+phone);
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