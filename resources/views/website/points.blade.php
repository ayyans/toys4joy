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
                            
                            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="70"
                                aria-valuemin="0" aria-valuemax="100"><span>{{ number_format($points, 0) }}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row party-includes">
                    <div class="col-xl-12 col-sm-12 col-md-6 left-col">
                        <div class="content-box">
                           <p>1 QR = 2 Points.</p>
                          <p>2500 QR = 5000 Points.</p>
                          <p>When you reach 5000 Points you gain E Gift card in amount of 100 QR</p>
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
