<ul class="nav nav-pills nav-fill treat-wrapper">
  <li class="nav-item">
    <?php //{{ route('website.newarrivals') }} ?>
    <a class="nav-link btn-red treat-button" aria-current="page" href="{{ route('website.bestoffers') }}">Special Prices</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-green treat-button" href="@if(Auth::check())  {{route('website.mywishlist',[encrypt(Auth::user()->id)])}} @else {{ url('login') }} @endif">Wish List</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-yellow treat-button" href="{{route('website.giftcard')}}">E-Gift Cards</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-blue treat-button" href="{{route('website.yourpoints')}}">Your Points</a>
  </li>
</ul> 
