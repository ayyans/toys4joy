@extends('website.layouts.master')
@section('content')

<main id="your-points">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center gap-5">
                <a href="#" class="mascot"><img style="max-width: 200px" src="{{asset('website/img/mascot-only.png')}}"></a>
                <h5 class="fw-bold">3,250</h5>
            </div>
        </div>
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
                      <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"><span>1,750 points left</span></div>
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
                <div class="col-6 left-col">
                    <div class="content-box">
                        <p>Gain 5,000 Points by spending 5,000 QR and get Free Part. The cost of this party is 2,700 QR, that means you saved 54% of your total purchases</p>
                    </div>
                </div>
                <div class="col-6 right-col">
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
                </div>
            </div>  


        </div>
    </div>
</div>

</main>

@stop