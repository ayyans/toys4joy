@extends('website.layouts.master')
@section('content')

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
                    <div class="outline-box gender">My Birthday</div>
                </div>

                <div class="col-6">
                    
                    <div class="d-flex date">
                        <div class="outline-box">Day</div>
                        <div class="outline-box">Month</div>
                        <div class="outline-box">Year</div>
                    </div>
                    <div class="d-flex date-numbering">
                        <div class="d-flex day">
                            <div class="green-bg num">
                                <span>
                                    <select>
                                        @for($i=1; $i < 32; $i++)
                                           <option>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex month">
                            <div class="pink-bg num">
                                <span>
                                    <select>
                                        @for($i=1; $i < 13; $i++)
                                           <option>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex year">
                            <div class="yellow-bg num">
                                <span>
                                    <select>
                                        @for($i=1960; $i < 2022; $i++)
                                           <option>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row gender">
                <div class="col-6">
                    <div class="outline-box gender">My Gender</div>
                </div>
                <div class="col-6">
                    <div class="d-flex select-gender">
                        <input type="radio" name="radio" id="female">
                        <label for="female"><img src="{{asset('website/img/sisters.png')}}"/></label>
                        <input type="radio" name="radio" id="male">
                        <label for="male"><img src="{{asset('website/img/brothers.png')}}"/></label>
                    </div>
                </div>
            </div>
            </div>    
            <div class="btn add-more">
                <a class="vertical-shake" href="#">Submit</a>
            </div>
        </div>
        <div class="col-1"></div>
  </div>      
</div>

</main>

@stop