@extends('website.layouts.master')
@section('content')

<main id="otp-form" class="account main-bg">
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
            
            <div class="form-group">
              <p class="text-center prompt">Please verify the OTP code you received by SMS<span>*</span></p>
                <form method="POST" action="{{ url('confermotp') }}" id="confermotpform" class="d-flex digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
                    <input type="text" autofocus id="digit-1" name="otp" data-next="digit-2" />
                </form>
                <button onclick="submitform()" class="vertical-shake">Submit</button>
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