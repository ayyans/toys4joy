<ul class="nav nav-pills nav-fill treat-wrapper" style="padding-right: 0;">
  <li class="nav-item">
    <?php //{{ route('website.newarrivals') }} ?>
    <a class="nav-link btn-red treat-button" aria-current="page" href="{{ route('website.bestoffers') }}">{{ __('Sale up to 60%') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-green treat-button" href="@if(Auth::check())  {{route('website.mywishlist',[encrypt(Auth::user()->id)])}} @else {{ url('login') }} @endif">{{ __('Wish List') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-yellow treat-button" href="{{route('website.giftcard')}}">{{ __('E-Gift Cards') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-blue treat-button" href="{{route('website.yourpoints')}}">{{ __('Your Points') }}</a>
  </li>
</ul> 
