<ul class="nav nav-pills nav-fill">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Best Offers</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="@if(Auth::check())  {{route('website.mywishlist',[encrypt(Auth::guard('cust')->user()->id)])}} @else {{ url('login') }} @endif">Wish List</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('website.giftcard')}}">E-Gift Cards</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('website.yourpoints')}}">Your Points</a>
  </li>
</ul> 