@extends('website.layouts.master')
@section('content')
<form id="formsubmitprofile" method="POST" action="{{ route('website.submituserprofile') }}">
<main id="my-siblings" class="my-profile">
<div class="container-fluid">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10 content-block">
            <div class="d-flex welcome-block">
                <img src="{{asset('website/img/user-pic.png')}}"/>
                <h2>Welcome Back Dear {{Auth::user()->name;}}</h2>
            </div>
            <div class="main-content-box">
            <div class="row birthday">
                <div class="col-6">
                    <div class="outline-box gender">{{__('trans.My Birthday')}}</div>
                </div>

                <div class="col-6">
                    
                    <div class="d-flex date">
                        <div class="outline-box">{{__('trans.Day')}}</div>
                        <div class="outline-box">{{__('trans.Month')}}</div>
                        <div class="outline-box">{{__('trans.Year')}}</div>
                    </div>
                    <div class="d-flex date-numbering">
                        <div class="d-flex day">
                            <div class="green-bg num">
                                <span>
                                    <select name="day">
                                        @for($i=1; $i < 32; $i++)
                                           <option @if(Auth::user()->day == $i) selected @endif value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex month">
                            <div class="pink-bg num">
                                <span>
                                    <select name="month">
                                        @for($i=1; $i < 13; $i++)
                                           <option @if(Auth::user()->month == $i) selected @endif value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex year">
                            <div class="yellow-bg num">
                                <span>
                                    <select name="year">
                                        @for($i=1960; $i < 2022; $i++)
                                           <option @if(Auth::user()->year == $i) selected @endif value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <style type="text/css">
                .activemaleinput::before{
                    transform: scale(1) !important;
                }
            </style>
            <div class="row gender">
                <div class="col-6">
                    <div class="outline-box gender">{{__('trans.My Points')}}</div>
                </div>
                <div class="col-6">
                    <div class="d-flex select-gender">
                        <input type="radio" @if(Auth::user()->gender == 1) class="activemaleinput"  @endif value="1" name="radio" id="female">
                        <label for="female"><img src="{{asset('website/img/sisters.png')}}"/></label>
                        <input value="2" @if(Auth::user()->gender == 2) class="activemaleinput"  @endif  type="radio" name="radio" id="male">
                        <label for="male" class="selected"><img src="{{asset('website/img/brothers.png')}}"/></label>
                    </div>
                </div>
            </div>
            </div>    
            <div class="btn add-more">
                <a class="vertical-shake" onclick="formsubmitprofile()" href="#">{{__('trans.Submit')}}</a>
            </div>
        </div>
        <div class="col-1"></div>
  </div>      
</div>
</main>
</form>
<script type="text/javascript">
    function formsubmitprofile()
    {
        $('#formsubmitprofile').submit();
    }
</script>
@stop
