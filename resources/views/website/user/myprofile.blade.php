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
                        <div class="outline-box">DD</div>
                        <div class="outline-box">MM</div>
                        <div class="outline-box">YY</div>
                    </div>
                    <div class="d-flex date-numbering">
                        <div class="d-flex day">
                            <div class="green-bg num">
                                <span>
                                    <select>
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                </span>
                            </div>
                            <div class="green-bg num">
                                <span>
                                    <select>
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex month">
                            <div class="pink-bg num">
                                <span>
                                    <select>
                                        <option>0</option>
                                        <option>1</option>
                                    </select>
                                </span>
                            </div>
                            <div class="pink-bg num">
                                <span>
                                    <select>
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex year">
                            <div class="yellow-bg num">
                                <span>
                                    <select>
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                    </select>
                                </span>
                            </div>
                            <div class="yellow-bg num">
                                <span>
                                    <select>
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
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