@extends('website.layouts.master')
@section('content')

<main id="change-mob-num" class="change-pswrd">
<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
    	<div class="col-6">
             @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('errorsecurity'))
                <div class="alert alert-danger alert-dismissible">
                    {{ session()->get('errorsecurity') }}
                </div>
            @endif
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
              </div><br />
            @endif
            <form id="passwordchange" action="{{ route('website.updateusersecurity') }}" method="POST">
            <div class="discount-block">
                <h4>Change your password</h4>
                <div class="mb-3">
                	<label>Old Password <span style="color:#ff0000">*</span></label>
                	<div class="d-flex phone-dropdown">
                        <div class="col-2">
                            <div class="lock"><img src="{{asset('website/img/lock.png')}}"></div>
                        </div>
                        <div class="col-10 pswrd-input"><input name="oldpassword" type="password"><img src="{{asset('website/img/eye.png')}}"></div>
                    </div>
                </div>
                <div class="mb-3">
                	<label>New Password <span style="color:#ff0000">*</span></label>
                	<div class="d-flex phone-dropdown">
                        <div class="col-2">
                            <div class="lock"><img src="{{asset('website/img/lock.png')}}"></div>
                        </div>
                        <div class="col-10 pswrd-input"><input name="newpassword" type="password"><img src="{{asset('website/img/eye.png')}}"></div>
                    </div>
                </div>
                <div class="mb-3">
                	<label>Confirm Password <span style="color:#ff0000">*</span></label>
                	<div class="d-flex phone-dropdown">
                        <div class="col-2">
                            <div class="lock"><img src="{{asset('website/img/lock.png')}}"></div>
                        </div>
                        <div class="col-10 pswrd-input"><input name="password_confirmed" type="password"><img src="{{asset('website/img/eye.png')}}"></div>
                    </div>
                </div>
                <div class="btn pinkbg-img"><a onclick="passwordchange()"  href="javascript:void(0)">Update</a></div>
            </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>
</main>
<script type="text/javascript">
    function passwordchange()
    {
        $('#passwordchange').submit();
    }
</script>
@stop