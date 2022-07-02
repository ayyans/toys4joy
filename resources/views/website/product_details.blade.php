@extends('website.layouts.master')
@section('content')
<main class="product-detail-page">
<div class="container-fluid">
    <div class="row">
    	<div class="col-3 categories-col">
            <div class="d-flex flex-column flex-shrink-0" > 
                <div class="for-mobile mbl-banner">
                    <ul class="nav nav-pills nav-fill">
                      <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Best Offers</a>
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
        <div class="col-9 pro-detail-col">
        <div class="for-desktop">
            @include('website.layouts.user_menu')
        </div>
            <div class="d-flex products-detail">
                <div class="product-gallery">
                    <div class="images p-3">
                        <div class="text-center p-4"> <img id="main-image" src="{{asset('products/'.$products->featured_img)}}"/> </div>
                        <div class="thumbnail text-center">
                            @foreach($gallery as $photos)
                            <img onclick="change_image(this)" src="{{asset('products/'.$photos->gallery_img)}}" width="150">
                           @endforeach
                        </div>
                    </div>
                </div>
                <div class="product-detail">
                    <div class="brand"><h5>Brand : {{$products->brand_name}}</h5></div>
                    <div class="title"><h2>{{$products->title}}</h2></div>
                    @if($products->logo)
                    <div class="nerf-logo"><img src="{{asset('uploads/'.$products->logo)}}"/></div>
                    @endif
                    <div class="reviews">
                        <div class="d-flex stars">
                            <img src="{{asset('website/img/star.png')}}"/>
                            <img src="{{asset('website/img/star.png')}}"/>
                            <img src="{{asset('website/img/star.png')}}"/>
                            <img src="{{asset('website/img/star.png')}}"/>
                            <img src="{{asset('website/img/star.png')}}"/>
                        </div>
                        <p>Be the first one to review this product</p>
                    </div>
                    <h2 class="price"> QAR {{$products->unit_price}}</h2>
                    <div class="earn-points"><h5>Earn Reward Points Worth {{$products->points}} Points<span>(Only for registered users)</span></h5></div>
                    @if(!empty($products->unit))
                    <div class="suitable-age">
                        <img src="{{asset('website/img/boy.svg')}}"/> <span>Recommended Age: {{ $products->recommended_age ? "{$products->recommended_age} Years +" : 'All' }} </span>
                    </div>
                    @endif
                    <p class="product-desc"><span>Description</span> : {!! $products->long_desc !!}</p>
                    @if($products->qty!=0)
                    <div class="d-flex icons-area">
                       
                        <form action="{{route('website.payasguest')}}" method="POST" id="productFRM">
                            @csrf
                            <input type="hidden" name="prod_id" value="{{$products->id}}" id="prod_id" />
                            <input type="hidden" name="amt" value="{{$products->unit_price}}" id="amt" />
                            <div class="qty block">
                                <label for="quantity">Quantity</label>
                                <input type="number" value="1" id="quantity" name="quantity" min="{{$products->min_qty}}" max="{{$products->qty}}">
                            </div>
                        </form>
                       
                        <div class="add-to-cart block">
                            <label>Add to Cart</label>
                            <div class="icon" id="addtocart"><img src="{{asset('website/img/cart-icon.png')}}"/></div>
                        </div>
                        <div class="like block">
                            <label>Like</label>
                            <div class="icon"><img src="{{asset('website/img/thumb-up.svg')}}"/></div>
                        </div>
                        <div class="wishlist block">
                            <label>Wish List</label>
                            <div class="icon" id="addwishlist"><img src="{{asset('website/img/bi_heart.svg')}}"/></div>
                        </div>
                    </div>
                    <div class="d-flex btn-area">
                        @if(!Auth::check())
                        <div class="guest"><a href="javascript:void(0)" id="payasguest"><span>Pay as</span>Guest</a></div>
                        @endif
                        <div class="member"><a href="javascript:void(0)" id="payasmember"><span>Pay as</span>Member</a></div>
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
    $(function(){
        $("#addtocart").click(function(){
            var cust_id = $("#cust_id").val();
            
       if(cust_id==0){
           window.location.href="{{route('website.login')}}";
       }else{
           var form =$("form#productFRM")[0]; 
        var form2 =new FormData(form);
        
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
                    toastr.success('Product added to cart');
                    location.reload();
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
    }
        })
    })
</script>

<script>
    $(function(){
        $("a#payasguest").click(function(e){
            e.preventDefault();
            $("form#productFRM").submit();

        })
    })
</script>

<!-- pay as wishlist -->

<script>
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
</script>

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
@endpush