@extends('website.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ url('website/phone/css/intlTelInput.css') }}">
<style type="text/css">
    .iti{
        width: 100%;
    }
</style>
<main id="change-mob-num">
<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
    	<div class="col-6">
            <div class="discount-block">
                <h4>Change your mobile number</h4>
                <div class="mb-3">
                    <form id="updatemobileform" method="POST" action="{{ url('updatemobilenumber') }}">
                	   <label>New Mobile Number <span style="color:#ff0000">*</span></label>
                	   <input id="phone" class="customerReg" name="phone" type="tel">
                        <input type="hidden" name="mobilenumber" id="mobilenumber">
                    </form>
                </div>
                <div class="btn pinkbg-img"><a onclick="submitformmobilenumber()">Update</a></div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
</main>
<script type="text/javascript">
    function submitformmobilenumber()
    {
        var txt = $('.iti__selected-dial-code').text();
        var phone = $('#phone').val();
        $('#mobilenumber').val(txt+phone);

        $('#updatemobileform').submit();
    }
</script>
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
@endsection