@extends('website.layouts.master')
@section('content')

<main id="your-points">
    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="row progres-bar gap-4 gap-md-0">
                    <div class="col-md-2">
                        <div class="your-points">
                            <span>Your Points</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="progress">
                            <a href="#" class="ballons"><img src="{{asset('website/img/party-ballons.png')}}"></a>
                            <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70"
                                aria-valuemin="0" aria-valuemax="100"><span>{{ number_format($points, 0) }} Points</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center free">
                            <h4 class="text-center pink-text">Free</h4>
                            <img src="{{asset('website/img/like-emoji.png')}}">
                        </div>
                    </div>
                </div>
                <div class="row party-includes">
                    <div class="col-xl-12 col-sm-12 col-md-6 left-col">
                        <div class="content-box">
                            <p>Gain 5,000 points and get free 100 QR e-gift voucher, 100 QR spent is equivalent to 2
                                points.</p>
                        </div>
                    </div>
                    <!--<div class="col-6 right-col">
                    <div class="content-box">
                        <h4 class="text-center pink-text">Other special needs?</h4>
                        <div class="d-flex list">
                            <ul>
                                <li>Magician</li>
                                <li>Mascot of your choice</li>
                                <li>Cake with your photo</li>
                            </ul>
                            <ul>
                                <li>Smoke machine with laser stage light</li>
                                <li>Select your favourite game for the activites</li>
                                <li>Balloon's Frame</li>
                            </ul>
                        </div>
                    </div>
                </div>-->
                </div>


            </div>
        </div>
    </div>

</main>

@stop