@extends('website.layouts.master')
@section('content')
<main id="otp-form" class="account main-bg">
  <div class="container-fluid">
    <div class="row">
      <div class="col-3 categories-col">
        <div class="d-flex flex-column flex-shrink-0">
          <div class="for-mobile mbl-banner">
            @include('website.layouts.user_menu')
          </div>
          <div class="categories mb-3">
            <h2 class="for-desktop">{{__('trans.Categories')}}</h2>
            @include('website.layouts.category_btn')
            <ul class="nav nav-pills flex-column mb-auto menu for-desktop">
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
          <p class="text-center prompt">{{__('trans.Please verify the OTP code you received by SMS')}}<span>*</span></p>
          <form method="POST" action="{{ url('confermotp') }}" id="confermotpform" class="d-flex digit-group"
            data-group-name="digits" data-autosubmit="false" autocomplete="off">
            <input type="hidden" name="mobile" value="{{ session('mobile') }}">
            <input type="text" autofocus id="digit-1" name="otp" data-next="digit-2" />
          </form>
          <button onclick="submitform()" class="vertical-shake">{{__('trans.Submit')}}</button>
        </div>
      </div>
    </div>
  </div>
</main>
<script type="text/javascript">
  function submitform()
    {
        $('#confermotpform').submit();
    }
</script>

@endsection