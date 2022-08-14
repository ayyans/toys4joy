@extends('website.layouts.master')
@section('content')

<main>
<div class="container-fluid">
    <div class="row">
    	<div class="col-3 categories-col">
            <div class="d-flex flex-column flex-shrink-0" >
                <div class="for-mobile mbl-banner">
                @include('website.layouts.user_menu') 
                    <!--<img src="{{asset('website/img/t1.png')}}" class="img-fluid">-->
                </div>
                <div class="categories">
                    <h2 class="for-desktop">Categories</h2>
                    <ul class="nav nav-pills flex-column mb-auto menu">
                     @include('website.layouts.category_menu')
                      
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-9 contact-col">
            <div class="for-desktop">
            @include('website.layouts.user_menu')  
            </div>
            <div class="row contact-info">
                    <div class="col-md-8 col-sm-12 content-block detail">
                        <h3>Contact Detail</h3>
                        <ul>
                            <li><strong>What'sapp Number:</strong> +974 600 05970</li>
                            <li><strong>Customer Service:</strong> +974 600 05370</li>
                            <li><strong>Customer Service:</strong> +974 600 05870</li>
                            <li><strong>Land Line:</strong> +974 444 14215</li>
                            <li><strong>Email ID:</strong>
                                marketing@toys4joy.com
                                <span>operation@toys4joy.com</span>
                                <span>info@toys4joy.com</span>
                            </li>
                            <li><strong>coordinations:</strong> Toys 4 joy, 7GJ3+766, Doha, Qatar</li>
                            <li><strong>Address:</strong> Building 25, zone 39, street 343, 4th floor, office 31, P.O 13920, Doha</li>
                            
                        </ul>
                    </div>
                <div class="col-md-4 col-sm-12 content-block map"> 
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3607.70028342721!2d51.50079251496338!3d25.28066588385736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e45db08d1dc918d%3A0xabe71fea30cd8b5b!2sToys%204%20Joy!5e0!3m2!1sen!2sqa!4v1660379606706!5m2!1sen!2sqa" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>   
                </div>
            </div>
        </div>
    </div>
</div>

</main>
@endsection
