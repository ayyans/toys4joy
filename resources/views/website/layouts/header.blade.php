<header id="main-header">
<div class="container-fluid">
    <div class="row">
        <div class="col-2 logo-col">
            <div class="logo-here">
                <a href="{{route('website.home')}}"><img src="{{asset('website/img/logo-t4j.png')}}"></a>
            </div>
        </div>
        <div class="col-5 search-col">
            <div class="search">
                <form action="{{ route('website.products-filter') }}" method="get">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search store for fun..." autocomplete="off" data-url="{{ route('website.search') }}">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div id="search-dropdown" class="search-dropdown position-absolute w-100 bg-white mt-1 rounded-3 border d-none">
                <div class="d-flex flex-wrap gap-2 p-1" id="categories-container">
                    {{-- <a href="#" class="badge bg-light text-dark text-decoration-none fw-light">Light</a> --}}
                </div>
                <div class="d-flex flex-column" id="search-container">
                    {{-- <div class="border d-flex align-items-center gap-2 p-2">
                        <div>
                            <a href="#">
                                <img src="http://toysforjoy.local/website/img/logo-t4j.png" alt="img-thumbnail rounded" width="70">
                            </a>
                        </div>
                        <div class="flex-fill">
                            <p class="mb-0 lead">
                                <a href="#" class="text-decoration-none text-reset">
                                    Hello Kitty Drift Nissan Skyline GTR
                                </a>
                            </p>
                            <small class="fst-italic"><a href="#" class="text-decoration-none text-reset">Outdoor</a> > <a href="#" class="text-decoration-none text-reset">Pools and Simms</a></small>
                            <p class="mb-0 fw-bold">QAR 529</p>
                        </div>
                    </div> --}}
                </div>
            </div>
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
            <a href="https://www.google.com/maps/place/Toys+4+joy/@25.280667,51.503014,18z/data=!4m5!3m4!1s0x0:0xf23502d4ac817c93!8m2!3d25.2806672!4d51.5030136?ll=25.280667,51.503014&z=18&t=m&hl=en&gl=US&mapclient=embed&cid=17452859043394714771&shorturl=1" target="_blank">
                <img src="{{asset('website/img/location.png')}}" class="map-pin">
            </a>
            <div class="cart-icon">
                <button onclick="showcart()" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><span id="cartno">{{ DB::table('carts')->where('cust_id' , Cmf::ipaddress())->count() }}</span><img src="{{asset('website/img/cart.png')}}" class="cart"></button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                    </div>
                    <div class="offcanvas-body showcart">
                       
                    </div>
                </div>
            
            </div>
        </div>
        <div class="col-2 account-buttons">
            <div class="navbar-nav for-desktop">
                @if(Auth::check())
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
                        <li> <a href="{{ route('website.bestsellers') }}" class="nav-link text-dark">
                            <img src="{{asset('website/img/best-seller.png')}}"><span class="ms-2">Best Sellers</span>
                            </a>
                        </li>
                        <li> <a href="{{ route('website.newarrivals') }}" class="nav-link text-dark">
                            <img src="{{asset('website/img/new-arrivals.png')}}"><span class="ms-2">New Arrivals</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('website.brands') }}" class="nav-link text-dark">
                                <img src="{{asset('website/img/brands.png')}}"><span class="ms-2">Brands</span>
                            </a>
                        </li>
                        @auth
                        <li>
                            <a href="{{ route('website.myaccount') }}" class="nav-link text-dark">
                                <img src="{{asset('website/img/my-account.png')}}"><span class="ms-2">My Account</span>
                            </a>
                        </li>
                        @endauth
<!--
                        <li>
                            <a href="#" class="nav-link text-dark">
                                <img src="{{asset('website/img/settings.png')}}"><span class="ms-2">Settings</span>
                            </a>
                        </li>
-->
                        @guest
                        <li>
                            <a href="{{route('website.login')}}" class="nav-link text-dark">
                                <img src="{{asset('website/img/login-register.png')}}"><span class="ms-2">Login/SignUp</span>
                            </a>
                        </li>
                        @endguest

                        @auth
                        <li>
                            <a href="{{ route('website.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link text-dark">
                                <img src="{{asset('website/img/logout.png')}}"><span class="ms-2">Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('website.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        @endauth
                      </ul>
                  </div>
                  <div class="text-center follow-us">
                    <h5>Follow us</h5>
                    <ul class="d-flex social-media">
                        <li><a href="https://www.facebook.com/Toys4joyqatar/" target="_blank">
                            <img src="{{asset('website/img/fb.png')}}">
                            </a></li>
                        <li>
                            <a href="https://twitter.com/Toys4joy3" target="_blank">
                            <img src="{{asset('website/img/twitter.png')}}"></a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/toys4joyqatar/" target="_blank">
                                <img src="{{asset('website/img/instagram.png')}}"></a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/channel/UCMK_gmojd4eBvMTHN1vD9Aw" target="_blank">
                                <img src="{{asset('website/img/linkedin.png')}}"></a>
                        </li>
                        <li>
                            <a href="https://www.tiktok.com/@toys4joyqatar" target="_blank">
                                <img src="{{asset('website/img/tiktok.png')}}"></a>
                        </li>
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