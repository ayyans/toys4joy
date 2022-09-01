<style>
    .cat-title-sidebar{
        -webkit-box-flex: 1;
    display: flex;
    flex: 1 1 50%;
    padding: 0px 20px;
    overflow: hidden;
    }
#cat-sidemenu{
    display: block;
    list-style: none;
    padding: 0px;
    margin: 0px;}
#cat-sidemenu li{
    display: flex;
    flex-wrap: wrap;
    position: relative;
    color: var(--mm-color-text);
    padding: 0px;
    margin: 0px;
    border-color: var(--mm-color-border);
 }   
 #sidebar-cats{
    width: 100%;
 }
 #sidebar-cats li img{
    width: 30px!important;
 }
 /*#sidebar-cats .li{
    padding: 8px;
    width: 100%;
    border-botom: 1px solid grey;
}*/
#offcanvasLeft-cats{
    background-color: #f3f3f3;
}
#sidebar-cats .main-cats{
    /*display: flex;*/
    flex-wrap: wrap;
    position: relative;
    color: var(--mm-color-text);
    padding: 0px;
    margin: 0px;
    border-color: var(--mm-color-border);
}
#sidebar-cats .main-cats a span svg{
    float: right;
}
#sidebar-cat-button{
    width: 1.5em;
    height: auto;
    color: grey;
}
#sidebar-cats .main-cats a[aria-expanded="true"] span svg{
transform: rotate(90deg);
}
#sidebar-cats .main-cats a.collapsed a span svg{
transform: rotate(0deg);
}
    
</style>
<header id="main-header">
<div class="container-fluid">
<div class="sidenenu-display for-mobile">
       
       <!--<a  data-bs-toggle="offcanvas" href="#offcanvasLeft-cats" role="button" aria-controls="offcanvasLeft-cats">
       <svg id="sidebar-cat-button" viewBox="0 0 10 7" xmlns="http://www.w3.org/2000/svg" width="14" height="10" class=""><path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 5.806H0v.944h7.5v-.944zm2.25-2.903H0v.944h9.75v-.944zM0 0h9.75v.944H0V0z" fill="currentColor"></path></svg>
</a>-->
<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasLeft-cats" aria-labelledby="offcanvasLeftLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title cat-title-sidebar" id="offcanvasLeftLabel">Categories</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
  <nav class="navbar navbar-dark accordion" style="width:100%;" >
  <ul class=" navbar-nav flex-column accordion" id="sidebar-cats">
      @php
          $categoriestest = DB::table('categories')->where('status' , 2)->get();
      @endphp
        @foreach($categoriestest as $cat)     
      @php
          $subcategories = DB::table('sub_categories')->where('parent_cat' , $cat->id)->where('status' , 2)->get();
      @endphp
      @if($subcategories->count() == 0)
      <li class="nav-item main-cats"> <a href="{{ url('category') }}/{{ $cat->url }}" class="nav-link text-dark" aria-current="page"> <img src="{{asset('uploads/'.$cat->cat_icon)}}" ><span class="ms-2">{{$cat->category_name}}</span> </a> </li>
      @else
      <li class="nav-item main-cats ">
          {{-- {{ url('category') }}/{{ $cat->url }} --}}
          <a class="nav-link text-dark navbar-collapse" cat-link="{{ url('category') }}/{{ $cat->url }}" data-bs-toggle="collapse" href="#collapse{{$cat->id}}" role="button" data-bs-target="#collapse{{$cat->id}}" aria-expanded="false" aria-controls="collapse{{$cat->id}}"> <img src="{{asset('uploads/'.$cat->cat_icon)}}">
              <span class="ms-2" style="font-size: 20px;font-weight: bold;">{{$cat->category_name}} 
                  <svg xmlns="http://www.w3.org/2000/svg" width="8" height="16" viewBox="0 0 8 16">
                    <path id="Vector_14_" data-name="Vector (14)" d="M8,8,0,0H16Z" transform="translate(0 16) rotate(-90)" fill="#d51965"/>
                  </svg>
              </span>
          </a> 
          <div class="collapse" id="collapse{{$cat->id}}">
          <ul class="navbar-nav" style="margin-left:40px;">
              @foreach($subcategories as $r)
              
              <li class="nav-item"><a href="{{ url('category') }}/{{ $cat->url }}/{{ $r->url }}" class="nav-link text-dark">{{ $r->subcat_name }}</a></li>
              @endforeach
      </ul>
          </div>
      </li>
      
      @endif
      @endforeach
      </ul>
    </nav>
    
  </div>
</div>   

        </div>
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
            <a href="https://www.google.com/maps/place/Toys+4+Joy/@25.2806659,51.5007925,17z/data=!3m1!4b1!4m5!3m4!1s0x3e45db08d1dc918d:0xabe71fea30cd8b5b!8m2!3d25.2806659!4d51.5029812" target="_blank">
                <img src="{{asset('website/img/location.png')}}" class="map-pin">
            </a>
            <div class="cart-icon">
                {{-- <button onclick="showcart()" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><span id="cartno">{{ DB::table('carts')->where('cust_id' , Cmf::ipaddress())->count() }}</span><img src="{{asset('website/img/cart.png')}}" class="cart"></button> --}}
                <button onclick="showcart()" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><span id="cartno">{{ cart()->getContent()->count() }}</span><img src="{{asset('website/img/cart.png')}}" class="cart"></button>
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
