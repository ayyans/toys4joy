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
                    <h4>Privacy Policy</h4>
                    <p>Toys 4 Joy is always making sure that all customers’ data and personal information is secured and protection.  We use the best commercial efforts to ensure your Personal Information is kept confidential and secure. We have SSL certificate to make sure all data transactions are secured and protect in highest level of security systems. Also we Sadad Service for online payment which is considered very secured and authorized party for this payment services and they are provide many different option of payment such as:</p>
                    <ul>
                        <li>Credit Car Visa – Mastered Card – American Express</li>
                        <li>Debit Card</li>
                        <li>Pay with Sadad</li>
                        <li>Pay through G Google Pay</li>
                    </ul>
                    
                    <p>All credit/debit cards’ details and personally identifiable information will NOT be stored, sold, shared, rented or leased to any third parties. Toys 4 Joy will not pass any debit/credit card details to third parties.</p>
                    
                    <p>We collect personal information about you to deliver the products and services you request and to help improve your shopping experience.</p> 
                    
                    <p>Personal information is information that identifies you or is reasonably linked to you. The personal information we collect may include contact and payment information like your name, email and physical addresses, phone numbers, and credit and debit card information. When you ask us to ship an order, we may collect information you provide us such as the name, address, and phone number of recipients. For certain transactions, we may be required to collect.</p>  
                    
                    <p>We will use our best commercial efforts to ensure your Personal Information is kept confidential and secure.  All credit/debit cards’ details and personally identifiable information will NOT be stored, sold, shared, rented or leased to any third parties. Toys 4 Joy will not pass any debit/credit card details to third parties.</p>  
                    
                    <p>Toys 4 Joy takes appropriate steps to ensure data privacy and security including through various hardware and software methodologies. However, (Toys 4 Joy) cannot guarantee the security of any information that is disclosed online</p>  
                    
                    <p>To protect the security, integrity, and privacy of your personal information, we only gather it when it is deemed necessary to further our legitimate business objectives. We also employ industry-standard security technology. Nevertheless, we disclaim all liability and responsibility for any security breach involving your personal data or for any acts taken by third parties who may have gotten your personal data from us, our website, or the Content.</p>  
                    
                    <p>You always have the right to access your personal information, to have it corrected or completed if it is inaccurate or incomplete. </p>   
                    
                    <p>You can, at any time, request us to delete your personal data that are stored in our website. To do this, you can send an email to<br>
                    <a href="mailto:operations@toys4joy.com">operations@toys4joy.com</a></p>
                    
                    <p>or call us at + 974 4441 4215. We are available from 9am to 6pm, 7 days a week.</p>

                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection