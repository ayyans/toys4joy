@extends('website.layouts.master')
@section('content')
<main class="rewards-points">
<div class="container-fluid">
    <div class="row">
        <div class="col-3 categories-col">
            <div class="d-flex flex-column flex-shrink-0" >
                <div class="for-mobile mbl-banner">
                    <ul class="nav nav-pills nav-fill">
                      <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Best Offers</a>
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
                    <img src="{{asset('website/img/t1.png')}}" class="img-fluid">
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
        <div class="col-9">
            <div class="for-desktop">
            @include('website.layouts.user_menu')  
            </div>
            <div class="t-and-c-text">
                <div class="content">
                    <h4>Return and Exchange</h4>
                    <p>All products purchased from Toys 4 Joy can be returned and exchanged within 7 days from the date of the purchasing as per the below points:</p>
                    <ul>
                        <li>If the product delivered does not match the product mentioned on Toys 4 Joy.</li>
                        <li>If the product delivered has manufacturing defect or damage.</li>
                        <li>If the product is not in its original packaging or does not include all the mentioned accessories.</li>
                        <li>Refunds, returns, or exchanges for faulty electronics or software items are subject to warranty eligibility, supplier’s verification, and discretion.</li>
                    </ul>
                    <p>We usually collect items within 1-2 working days from the date of your feedback.</p> 
                    <p>The delivery of replacement usually takes 2-3 working days from when we have received and evaluated the product.</p>
                    <p>Please note that Toys4joy.com will not be able to accept any returns during busy months and seasons unless the product has a manufacturing defect or missing parts.</p>
                    </p>If you have any further queries regarding our returns policy, please send email to <a href="mailto:operation@toys4joy.com">operation@toys4joy.com</a></p>

                    <p>Regarding the Warranty, we focus to provide extensive assistance claimed under Manufacturer’s limited warranty. 
                    Manufacturer would be happy to replace your defective item under manufacturer’s warranty if all conditions are met.</p> 
                    <p>Manufacturer will determine whether an item is defective or not upon review.  Defective part would be replaced only if determined to be defective.</p> 
                    <p>Copy of the original proof of purchase shall be provided. Any product under coverage and purchased within the Manufacturer’s warranty period if assembly is required, product must have been properly set up according to instruction manual.  Improper set up or improper use or abusive use of the product will not be eligible for replacement no modification or repair of the product has been made all parts of the product must be kept until the claim is resolved. Please note if the exact part is not available for replacement, manufacturer will offer an alternate part.</p>
                    <p>Products excludes warranty – books, edible items, cosmetics, jewelry, video games, DVDs, CDs, beddings, and foam mats.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection