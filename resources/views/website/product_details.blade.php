@extends('website.layouts.master')
@section('content')
<style>
  .xzoom-source img,
  .xzoom-preview img,
  .xzoom-lens img {
    display: block;
    max-width: none;
    max-height: none;
    -webkit-transition: none;
    -moz-transition: none;
    -o-transition: none;
    transition: none;
  }
</style>
<main class="product-detail-page">
  <div class="container-fluid">
    <div class="row">
      <div class="col-3 categories-col">
        <div class="d-flex flex-column flex-shrink-0">
          <div class="for-mobile mbl-banner">
            @include('website.layouts.user_menu')
          </div>
          <div class="categories">
            <h2 class="for-desktop">Categories</h2>
            <ul class="nav nav-pills flex-column mb-auto menu">
              @include('website.layouts.category_menu')
            </ul>
          </div>
        </div>
      </div>
      <div class="col-9 pro-detail-col">
        <div class="for-desktop">
          @include('website.layouts.user_menu')
        </div>
        <div class="d-flex products-detail">
          <div class="product-gallery">
            <div class="images p-3">
              <div class="text-center p-4">
                <img id="main-image" class="" src="{{asset('products/'.$products->featured_img)}}"
                  xoriginal="{{asset('products/'.$products->featured_img)}}" />
              </div>
              <div class="thumbnail text-center xzoom-thumbs">
                @foreach($gallery as $photos)
                <img class="xzoom-gallery" onclick="change_image(this)"
                  src="{{asset('products/'.$photos->gallery_img)}}" width="150"
                  xpreview="{{asset('products/'.$photos->gallery_img)}}">
                @endforeach
              </div>
            </div>
          </div>
          <div class="product-detail">
            <div class="brand">
              <h5>Brand : {{$products->brand_name}}</h5>
            </div>
            <div class="title">
              <h2>{{$products->title}}</h2>
            </div>
            @if($products->logo)
            <div class="nerf-logo"><img src="{{asset('uploads/'.$products->logo)}}" /></div>
            @endif
            <!--<div class="reviews">
                        <div class="d-flex stars">
                            <img src="{{asset('website/img/star.png')}}"/>
                            <img src="{{asset('website/img/star.png')}}"/>
                            <img src="{{asset('website/img/star.png')}}"/>
                            <img src="{{asset('website/img/star.png')}}"/>
                            <img src="{{asset('website/img/star.png')}}"/>
                        </div>
                        <p>Be the first one to review this product</p>
                    </div>-->
            @if($products->discount)
            <del class="price"> QR {{$products->unit_price}}</del>
            <h2 class="price"> QR {{$products->discount}}</h2>

            @else
            <h2 class="price"> QR {{$products->unit_price}}</h2>
            @endif

            <div class="earn-points">
              <h5>Earn Reward Points Worth {{$products->rewardPoints}} Points<span>(Only for registered users)</span>
              </h5>
            </div>
            @if(!empty($products->unit))
            <div class="suitable-age">
              <img src="{{asset('website/img/boy.svg')}}" /> <span>Recommended Age: {{ $products->recommended_age !==
                null ? "{$products->formatRecommendedAge($products->recommended_age)} +" : 'All' }} </span>
            </div>
            @endif
            <p class="product-desc"><span>Description</span> : {!! $products->long_desc !!}</p>
            <p class="product-desc"><span>Shipping Time</span> : {!! $products->shiping_time ?? '24-48 Hours' !!}</p>
            @if($products->qty!=0)
            <div class="d-flex icons-area">

              <form action="{{route('website.payasguest')}}" method="POST" id="productFRM">
                @csrf
                <input type="hidden" name="product_id" value="{{$products->id}}" id="prod_id" />
                <div class="qty block">
                  <label for="quantity">Quantity</label>
                  <input type="number" value="1" id="quantity" name="quantity" min="{{$products->min_qty}}"
                    max="{{$products->qty}}">
                </div>
              </form>

              <!-- <div class="add-to-cart block">
                            <label>Add to Cart</label>
                            <div class="icon" id="addtocart"><img src="{{asset('website/img/cart-icon.png')}}"/></div>
                        </div> -->
              <!--<div class="like block">
                            <label>Like</label>
                            <div class="icon"><img src="{{asset('website/img/thumb-up.svg')}}"/></div>
                        </div>-->
              @if(Auth::check())
              <div class="wishlist block">
                <label>Wish List</label>
                <div class="icon" id="addwishlist"><img src="{{asset('website/img/bi_heart.svg')}}" /></div>
              </div>
              @else
              <a href="{{ url('login') }}">
                <div class="wishlist block">
                  <label>Wish List</label>
                  <div class="icon"><img src="{{asset('website/img/bi_heart.svg')}}" /></div>
                </div>
              </a>
              @endif
            </div>
            <div class="d-flex btn-area">
              <div class="guest"><a href="javascript:void(0)" id="checkoutaddtocart"><span>Checkout</span></a></div>
              <div class="member"><a href="javascript:void(0)" id="addtocart"><span>Add to Cart</span></a></div>
            </div>
            @else
            <p style="color:red"><strong>Out of stock</strong></p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
@stop

@push('otherscript')
<script>
  $(function() {
    $("#addtocart").click(function() {
      const url = "{{route('website.addTocart')}}";
      const form = $('form#productFRM')[0];
      const data = new FormData(form);
      $("#cover-spin").show();
      fetch(url, {
        method: 'POST',
        body: data
      })
      .then(res => res.json())
      .then(res => {
        $("#cover-spin").hide();
        if (res.status) {
            toastr.success(res.message);
            headercart();
        } else {
            toastr.error(res.message)
        }
      })
      .catch(err => console.log(err));

        // var form =$("form#productFRM")[0]; 
        // var form2 =new FormData(form);
        // console.log(form2);
        // $("#cover-spin").show();
        // $.ajax({
        //     url:"{{route('website.addTocart')}}",
        //     type:"POST",
        //     data:form2,
        //     cache:false,
        //     contentType:false,
        //     processData:false,
        //     success:function(res){
        //         $("#cover-spin").hide();
        //         var js_data = JSON.parse(JSON.stringify(res));
        //         if(js_data.status==200){
        //             toastr.success('Product added to cart');
        //             location.reload();
        //         }else if(js_data.msg=='3'){
        //             toastr.error('product out of stock! please check product stock');
        //             return false; 
        //         }
        //         else{
        //             toastr.error('something went wrong');
        //             return false; 
        //         }
        //     }
        // })
    });
  });
</script>

<script>
  $(function(){
    $("a#checkoutaddtocart").on('click', function(e) {
      e.preventDefault();

      const url = "{{route('website.addTocart')}}";
      const form = $('form#productFRM')[0];
      const data = new FormData(form);
      $("#cover-spin").show();
      fetch(url, {
        method: 'POST',
        body: data
      })
      .then(res => res.json())
      .then(res => {
        $("#cover-spin").hide();
        if (res.status) {
          window.location.href="{{route('website.cartpage')}}";
        } else {
          toastr.error(res.message)
        }
      })
      .catch(err => console.log(err));

            // var form =$("form#productFRM")[0]; 
            // var form2 =new FormData(form);
            // $("#cover-spin").show();
            // $.ajax({
            //     url:"{{route('website.addTocart')}}",
            //     type:"POST",
            //     data:form2,
            //     cache:false,
            //     contentType:false,
            //     processData:false,
            //     success:function(res){
            //         window.location.href="{{route('website.cartpage')}}";
            //     }
            // })
    })
  })
</script>

<!-- pay as wishlist -->

{{-- <script>
  $("#payasmember").click(function(e){
        e.preventDefault();
        var form = $("form#productFRM")[0];
        var form2 = new FormData(form);       
        $("#cover-spin").show();
        $.ajax({
            url:"{{route('website.addTocart')}}",
            type:"POST",
            data:form2,
            cache:false,
            contentType:false,
            processData:false,
            success:function(res){
                $("#cover-spin").hide();
                var js_data = JSON.parse(JSON.stringify(res));
                if(js_data.status==200){
                   window.location.href="{{route('website.payasmember')}}";
                }else if(js_data.msg=='3'){
                    toastr.error('product out of stock! please check product stock');
                    return false; 
                }
                else{
                    toastr.error('something went wrong');
                    return false; 
                }
            }
        })
    })
</script> --}}

<script>
  $("#addwishlist").click(function(){
    var form =$("form#productFRM")[0]; 
    var form2 =new FormData(form);
    $("#cover-spin").show();
    $.ajax({
        url:"{{route('website.addWishlist')}}",
        type:"POST",
        data:form2,
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){
            $("#cover-spin").hide();
            var js_data = JSON.parse(JSON.stringify(res));
            if(js_data.status==200){
                toastr.success('Product added to wishlist');
                location.reload();
            }else if(js_data.msg=='3'){
                toastr.error('product already added in wishlist');
                return false; 
            }
            else{
                toastr.error('something went wrong');
                return false; 
            }
        }
    })    
})
</script>

<script id="rendered-js">
  (function ($) {
  $(document).ready(function () {
    $('.xzoom, .xzoom-gallery').xzoom({  title: true, tint: '#333', Xoffset: 15, lensShape: "circle",defaultScale:-1 });
    /*$('.xzoom2, .xzoom-gallery2').xzoom({ position: '#xzoom2-id', tint: '#ffa200' });
    $('.xzoom3, .xzoom-gallery3').xzoom({ position: 'lens', lensShape: 'circle', sourceClass: 'xzoom-hidden' });
    $('.xzoom4, .xzoom-gallery4').xzoom({ tint: '#006699', Xoffset: 15 });
    $('.xzoom5, .xzoom-gallery5').xzoom({ tint: '#006699', Xoffset: 15 });*/

    //Integration with hammer.js
    var isTouchSupported = ('ontouchstart' in window);

    if (isTouchSupported) {
      //If touch device
      $('.xzoom, .xzoom2, .xzoom3, .xzoom4, .xzoom5').each(function () {
        var xzoom = $(this).data('xzoom');
        xzoom.eventunbind();
      });

      $('.xzoom, .xzoom2, .xzoom3').each(function () {
        var xzoom = $(this).data('xzoom');
        $(this).hammer().on("tap", function (event) {
          event.pageX = event.gesture.center.pageX;
          event.pageY = event.gesture.center.pageY;
          var s = 1,ls;

          xzoom.eventmove = function (element) {
            element.hammer().on('drag', function (event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              xzoom.movezoom(event);
              event.gesture.preventDefault();
            });
          };

          xzoom.eventleave = function (element) {
            element.hammer().on('tap', function (event) {
              xzoom.closezoom();
            });
          };
          xzoom.openzoom(event);
        });
      });

      $('.xzoom4').each(function () {
        var xzoom = $(this).data('xzoom');
        $(this).hammer().on("tap", function (event) {
          event.pageX = event.gesture.center.pageX;
          event.pageY = event.gesture.center.pageY;
          var s = 1,ls;

          xzoom.eventmove = function (element) {
            element.hammer().on('drag', function (event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              xzoom.movezoom(event);
              event.gesture.preventDefault();
            });
          };

          var counter = 0;
          xzoom.eventclick = function (element) {
            element.hammer().on('tap', function () {
              counter++;
              if (counter == 1) setTimeout(openfancy, 300);
              event.gesture.preventDefault();
            });
          };

          function openfancy() {
            if (counter == 2) {
              xzoom.closezoom();
              $.fancybox.open(xzoom.gallery().cgallery);
            } else {
              xzoom.closezoom();
            }
            counter = 0;
          }
          xzoom.openzoom(event);
        });
      });

      $('.xzoom5').each(function () {
        var xzoom = $(this).data('xzoom');
        $(this).hammer().on("tap", function (event) {
          event.pageX = event.gesture.center.pageX;
          event.pageY = event.gesture.center.pageY;
          var s = 1,ls;

          xzoom.eventmove = function (element) {
            element.hammer().on('drag', function (event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              xzoom.movezoom(event);
              event.gesture.preventDefault();
            });
          };

          var counter = 0;
          xzoom.eventclick = function (element) {
            element.hammer().on('tap', function () {
              counter++;
              if (counter == 1) setTimeout(openmagnific, 300);
              event.gesture.preventDefault();
            });
          };
          
          function openmagnific() {
            if (counter == 2) {
              xzoom.closezoom();
              var gallery = xzoom.gallery().cgallery;
              var i,images = new Array();
              for (i in gallery) {
                images[i] = { src: gallery[i] };
              }
              $.magnificPopup.open({ items: images, type: 'image', gallery: { enabled: true } });
            } else {
              xzoom.closezoom();
            }
            counter = 0;
          }
          xzoom.openzoom(event);
        });
      });

    } else {
      //If not touch device

      //Integration with fancybox plugin
      $('#xzoom-fancy').bind('click', function (event) {
        var xzoom = $(this).data('xzoom');
        xzoom.closezoom();
        $.fancybox.open(xzoom.gallery().cgallery, { padding: 0, helpers: { overlay: { locked: false } } });
        event.preventDefault();
      });

      //Integration with magnific popup plugin
      $('#xzoom-magnific').bind('click', function (event) {
        var xzoom = $(this).data('xzoom');
        xzoom.closezoom();
        var gallery = xzoom.gallery().cgallery;
        var i,images = new Array();
        for (i in gallery) {
          images[i] = { src: gallery[i] };
        }
        $.magnificPopup.open({ items: images, type: 'image', gallery: { enabled: true } });
        event.preventDefault();
      });
    }
  });
})(jQuery);
//# sourceURL=pen.js
</script>

@endpush