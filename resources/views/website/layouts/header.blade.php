<header>
<div class="container-fluid">
	<div class="row">
    	<div class="col-2">
            <div class="logo-here">
                <a href="{{route('website.home')}}"><img src="{{asset('website/img/logo-t4j.png')}}"></a>
            </div>
    	</div>
        <div class="col-5 search-col"><div class="search"><input type="text" class="form-control" placeholder="Search store for fun..."> <button class="btn btn-primary"><i class="fa fa-search"></i></button> </div>
        </div>
        <div class="col-3 d-flex heades-images">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                EN
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">AR</a></li>
              </ul>
            </div>
            <img src="{{asset('website/img/location.png')}}" class="map-pin">
            <div class="cart-icon">
                @if(Auth::guard('cust')->check())
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><span id="cartno">0</span><img src="{{asset('website/img/cart.png')}}" class="cart"></button>
                @else
                <button class="btn btn-primary" type="button" ><span id="">0</span><img src="{{asset('website/img/cart.png')}}" class="cart"></button>
                @endif
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="cart-main-title"><h5 id="offcanvasRightLabel">My Bag</h5></div>
                    	
                        <div id="cartdetailsheader"></div>
                        <!-- <div class="d-flex added-products">
                            <div class="pro-image"><img src="{{asset('website/img/cart-img.png')}}"/></div>
                            <div class="product-detail">
                                <h2 class="title">Maisto 1:18 2016 Chevrolet Camaro SS Sport Model Car</h2>
                                <h4 class="price">QAR 169</h4>
                                <div class="d-flex rmv-or-edit">
                                    <div class="qty"><input type="number" value="1" id="quantity" name="quantity" min="1" max="10"></div>
                                    <div class="remove icon"><a href="#"><img src="{{asset('website/img/delete.png')}}"/></a></div>
                                    <div class="edit icon"><a href="#"><img src="{{asset('website/img/edit.png')}}"/></a></div>
                                </div>
                            </div>
                        </div> -->
                         <hr>
                        <div class="d-flex total-n-shipping">
                            <div class="d-flex subtotal">
                                <h4>Subtotal:</h4>
                                <h5 class="price" id="subtotal_price"></h5>
                            </div>
                            <div class="d-flex shipping">
                                <h4>Shipping:</h4>
                                <p>Taxes & shipping fee will be calculated at checkout.</p>
                            </div>
                        </div>
                        <div class="d-flex btn-area">
                            <div class="checkout btn"><a href="{{route('website.payasmember')}}">Checkout</a></div>
                            <div class="view-cart btn"><a href="{{route('website.cartpage')}}">View Cart</a></div>
                        </div>
                        <!-- <div class="cmplt-your-purchase">
                            <h4>Complete Your Purchase With:</h4>
                            <div class="d-flex purchase-product">
                                <div class="img-block"><img src="{{asset('website/img/purchase-product-img.png')}}"/></div>
                                <div class="detail">
                                    <h4>Maisto 1:18 2016 Chevrolet Camero SS Sport Model Car</h4>
                                    <p class="price">190$</p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            
            </div>
        </div>
        <div class="col-2 account-buttons">
            <div class="navbar-nav for-desktop">
                @if(Auth::guard('cust')->check())
                
                <div class="my-account"><a href="{{route('website.myaccount')}}" class="btn">My Account</a></div>
                @else
                    <div class="login"><a href="{{route('website.login')}}" class="btn">Login | Signup</a></div>
              @endif
            </div>
            
            <!-- MOBILE MENU START -->
            
            <div class="mobile-menu for-mobile">
            <button class="navbar-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu"><span class="navbar-toggler-icon"></span></button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
              <div class="offcanvas-header d-none">
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <div class="text-center logo-here"><a href="#"><img src="{{asset('website/img/logo-t4j.png')}}"></a></div>
                  <div class="mbl-menu-list">
                      <ul style="list-style:none">
                        <li> <a href="#" class="nav-link text-dark"> <img src="{{asset('website/img/best-seller.png')}}"><span class="ms-2">Best Sellers</span> </a> </li>
                        <li> <a href="#" class="nav-link text-dark"> <img src="{{asset('website/img/new-arrivals.png')}}"><span class="ms-2">New Arrivals</span> </a> </li>
                        <li> <a href="#" class="nav-link text-dark"> <img src="{{asset('website/img/brands.png')}}"><span class="ms-2">Brands</span> </a> </li>
                        <li> <a href="#" class="nav-link text-dark"> <img src="{{asset('website/img/my-account.png')}}"><span class="ms-2">My Account</span> </a> </li>
                        <li> <a href="#" class="nav-link text-dark"> <img src="{{asset('website/img/settings.png')}}"><span class="ms-2">Settings</span> </a> </li>
                        <li> <a href="#" class="nav-link text-dark"> <img src="{{asset('website/img/login-register.png')}}"><span class="ms-2">Login/SignUp</span> </a> </li>
                      </ul>
                  </div>
                  <div class="text-center follow-us">
                      <h5>Follow us</h5>
                    <ul class="d-flex social-media">
                        <li><a href="#"><img src="{{asset('website/img/fb.png')}}"></a></li>
                        <li><a href="#"><img src="{{asset('website/img/twitter.png')}}"></a></li>
                        <li><a href="#"><img src="{{asset('website/img/instagram.png')}}"></a></li>
                        <li><a href="#"><img src="{{asset('website/img/linkedin.png')}}"></a></li>
                    </ul>
                  </div>
              </div>
            </div>
            </div>
            
            <!-- MOBILE MENU END -->
            
        </div>
    </div>
</div>
</header>