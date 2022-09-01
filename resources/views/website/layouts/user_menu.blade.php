<ul class="nav nav-pills nav-fill treat-wrapper">
  <li class="nav-item">
    <?php //{{ route('website.newarrivals') }} ?>
    <!--<a class="nav-link active" aria-current="page" href="{{ route('website.bestoffers') }}">Special Prices</a>-->
   
    <!--<a href="{{ url('contact-us') }}" class="pushable pushable-contact">
          <span class="shadow"></span>
          <span class="edge"></span>
           <span class="front front-menu">
           Special Prices
           </span>
</a>--> 
<a href="{{ route('website.bestoffers') }}" class="btn-red treat-button">Special prices</a>
  </li>
  <li class="nav-item">
    <!--<a class="nav-link" href="@if(Auth::check())  {{route('website.mywishlist',[encrypt(Auth::user()->id)])}} @else {{ url('login') }} @endif">Wish List</a>-->
    <!--<a href="@if(Auth::check())  {{route('website.mywishlist',[encrypt(Auth::user()->id)])}} @else {{ url('login') }} @endif" class="pushable pushable-contact">
          <span class="shadow"></span>
          <span class="edge"></span>
           <span class="front front-menu">
          Wish list
           </span>
</a>--> 
<a href="@if(Auth::check())  {{route('website.mywishlist',[encrypt(Auth::user()->id)])}} @else {{ url('login') }} @endif" class="btn-green treat-button">Wish list</a>
  </li>
  <li class="nav-item">
    <!--<a class="nav-link" href="{{route('website.giftcard')}}">E-Gift Cards</a>-->
    <!--<a href="@if(Auth::check())  {{route('website.mywishlist',[encrypt(Auth::user()->id)])}} @else {{ url('login') }} @endif" class="pushable pushable-contact">
          <span class="shadow"></span>
          <span class="edge"></span>
           <span class="front front-menu">
           E-Gift Cards
           </span>
</a>--> 
<a href="{{route('website.giftcard')}}" class="btn-yellow treat-button">E-Gifts Card</a>
  </li>
  <li class="nav-item">
    <!--<a class="nav-link" href="{{route('website.yourpoints')}}">Your Points</a>-->
    <!--<a href="@if(Auth::check())  {{route('website.mywishlist',[encrypt(Auth::user()->id)])}} @else {{ url('login') }} @endif" class="pushable pushable-contact">
          <span class="shadow"></span>
          <span class="edge"></span>
           <span class="front front-menu">
           Your Points
           </span>
</a>--> 
<a href="{{route('website.yourpoints')}}" class="btn-blue treat-button">My points</a>
  </li>
</ul> 
