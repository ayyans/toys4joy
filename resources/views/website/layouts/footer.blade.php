<!--test footer-->
<!--footer start-->
<footer>
  <div class="footer-wrap">
  <div class="container first_class">
      <div class="row">
        <div class="col-md-4 col-sm-6">
          <h3>{{__('trans.BE THE FIRST TO KNOW')}}</h3>
          <p>{{__('trans.Get all the latest information on Triedge Services, Events, Jobs and Fairs. Sign up for our newsletter today.')}}</p>
        </div>
        <div class="col-md-4 col-sm-6">
        <form class="newsletter">
            <div class="input-group">
            <input type="text" placeholder="{{__('trans.Email Address')}}"> 
                <button class="newsletter_submit_btn" type="submit"><i class="fa fa-paper-plane"></i></button> 
            </div>
            
        </form>
        
        </div>
        <div class="col-md-4 col-sm-6 mt-2">
        <div class="col-md-12">
          <div class="standard_social_links">
        <div>
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
          <div class="clearfix"></div>
        <div class="col-md-12 for-desktop"><h3 style="text-align: right;">{{__('trans.STAY CONNECTED')}}</h3></div>
        </div>
      </div>
  </div>
    <div class="second_class">
      <div class="container second_class_bdr">
      <div class="row">
        <div class="col-md-4 col-sm-6">

          <div class="footer-logo why-us">
            <a href="{{ route('website.whyus') }}">
                        <img src="{{asset('website/img/why-us.png')}}" class="why-text">
                        <img src="{{asset('website/img/logowhiteline.png')}}" class="why-logo">
            </a>
          </div>
          <p>{{__('trans.Number one Toys E-Commerce by providing best smooth shopping experience with easy checkout, free and fastest delivery, and unique online shopping features such as Loyalty Program, Wish List, and E-Gift Cards.')}}</p>
        </div>
        <div class="col-md-2 col-sm-6">
          <h3>{{__('trans.sitemap')}}</h3>
          <ul class="footer-links">
            <li><a href="/">{{__('trans.Home')}}</a>
            </li>
            <li><a href="{{ route('website.bestoffers') }}">{{__('trans.Special Prices')}}</a>
            </li>
            <li><a href="@if(Auth::check())  {{route('website.mywishlist',[encrypt(Auth::user()->id)])}} @else {{ url('login') }} @endif">{{__('trans.Wish List')}}</a>
            </li>
            <li><a href="{{route('website.giftcard')}}">{{__('trans.E-Gift Cards')}}</a>
            </li>
            <li><a href="{{route('website.yourpoints')}}">{{__('trans.Your Points')}}</a>
            </li>
          </ul>
        </div>
        <div class="col-md-3 col-sm-6">
          <h3>{{__('trans.policy')}}</h3>
          <ul class="footer-category">
            <li><a href="{{ route('website.policy') }}">{{__('trans.Browse Our Policies')}}</a>
            </li>
            <li><a href="{{ url('return-policy') }}">{{__('trans.Return Policy')}}</a>
            </li>
            <li><a href="{{ url('rewards-policy') }}">{{__('trans.Rewards Policy')}}</a>
            </li>
            <li><a href="{{ url('delivery-policy') }}">{{__('trans.Delivery Policy')}}</a>
            </li>
            <li><a href="{{ url('privacy-policy') }}">{{__('trans.privacy Policy')}}</a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-3 col-sm-6">
          <h3>{{__('trans.contact_us')}}</h3>
          
          <ul class="footer-contact footer-links">
            <li><a href="mailto:info@toys4joy.com"><i class="fa fa-envelope"></i> <strong>info@toys4joy.com</strong></a></li>
            <li><a href="whatsapp:+974 6000 5970"><i class="fa fa-whatsapp"></i> <strong>{{__('trans.Whatsapp Number')}}:</strong> <span style="direction:ltr!important;display:inline-block"> +974 6000 5970</span></a></li>
            <li><a href="tel:+974 6000 5370"><i class="fa fa-phone"></i> <strong>{{__('trans.Customer Service')}}:</strong><span style="direction:ltr!important;display:inline-block"> +974 6000 5370</span></a></li>
            <li><a href="tel:+974 4441 4215"><i class="fa fa-phone"></i> <strong>{{__('trans.Land Line')}}:</strong><span style="direction:ltr!important;display:inline-block"> +974 4441 4215</span></a></li>
          </ul>
          
          <a href="{{ url('contact-us') }}" class="pushable pushable-contact">
          <span class="shadow"></span>
          <span class="edge"></span>
           <span class="front front-contact">
           {{__('trans.More Info')}}
           </span>
</a>
          <!--<div class="google-play" >
                    <a href="#"><img src="{{asset('website/img/ios.png')}}" class="app-store" style="width: 150px;"></a>
                    <a href="#"><img src="{{asset('website/img/android.png')}}" class="g-play-store" style="width: 150px;"></a>
                </div>-->
        </div>
      </div>
      
    </div>
    </div>
    
    <div class="row">
      
      <div class="container-fluid">
      <div class="copyright">{{__('trans.Copyright 2022 | All Rights Reserved by Toys4joy.com.')}}</div>
      </div>
      
    </div>
  </div>
  <div class="elements">
                    <div class="d-flex why-us">
                        <a href="https://api.whatsapp.com/send?phone=97460005970&text=Welcome%20to%20Toys4joy"
                            target="_blank" class="whatsapp-icon">
                            <img src="{{asset('website/img/whatsapp-icon.png')}}" class="whatsapp">
                        </a>
                    </div>
                </div>
  </footer>

<!--footer end-->

<input type="hidden" name="cust_id" value="{{ Cmf::ipaddress() }}" id="cust_id" />
@include('website.layouts.loader')
@push('otherscript')
<script>
    function addtowishlist(id)
    {
        $("#cover-spin").show();
        var form = new FormData();
        form.append('product_id',id);
        $.ajax({
            url:"{{route('website.addWishlist')}}", 
            type:"POST",
            data:form,
            cache:false,
            contentType:false,
            processData:false,
            success:function(res){
                $("#cover-spin").hide();
                var js_data = JSON.parse(JSON.stringify(res));
                if(js_data.status==200){
                    toastr.success('Product added to wishlist');
                    $('.addtowishlist'+id).removeClass('fa-heart-o');
                    $('.addtowishlist'+id).addClass('fa-heart');
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
    }

    function addtocart(product_id, quantity) {

        const url = "{{route('website.addTocart')}}";
        const data = {product_id, quantity};

        $("#cover-spin").show();
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
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
        // var form =new FormData();
        // form.append('prod_id',prod_id);
        // form.append('quantity',qty);
        // form.append('amt',amt);
        // $("#cover-spin").show();
        // $.ajax({
        //     url:"{{route('website.addTocart')}}",
        //     type:"POST",
        //     data:form,
        //     cache:false,
        //     contentType:false,
        //     processData:false,
        //     success:function(res){
        //         $("#cover-spin").hide();
        //         var js_data = JSON.parse(JSON.stringify(res));
        //         if(js_data.status==200){
        //             toastr.success('Product added to cart');
        //             headercart();
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
    }
</script>

<script>
    function showcart()
    {
        $("#cover-spin").show();
        $.ajax({
            url:"{{url('showcart')}}",
            type:"get",
            success:function(res){
                $("#cover-spin").hide();
                $(".showcart").html(res);
            }
        })
    }
    function headercart()
     {
        var cust_id = $("#cust_id").val();
       var form = new FormData();
        form.append('cust_id',cust_id);
        $.ajax({
            url:"{{route('website.headerCart')}}",
            type:"POST",
            data:form,
            cache:false,
            contentType:false,
            processData:false,
            success:function(res){
                var js_data = JSON.parse(JSON.stringify(res));
                if(js_data.status==200){
                    var cartsize = js_data.count;
                    $("#cartno").text(cartsize);
                }else{
                    $("#cartdetailsheader").append('<p>No products in cart</p>') 
                    $("#cartno").text(0);   
                }


            }
        })
     }
</script>

<script>
    function removecart(cartid, refresh = false){
        $("#cover-spin").show();
        var form = new FormData();
        form.append('cartid',cartid);
        $.ajax({
            url:"{{route('website.removedcartProd')}}",
            type:"POST",
            data:form,
            cache:false,
            contentType:false,
            processData:false,
            success:function(res){
                var js_data = JSON.parse(JSON.stringify(res));
                $("#cover-spin").hide();
                if(js_data.status==200){
                    toastr.success('Product removed from cart');
                    if (refresh) window.location.reload();
                    headercart();
                    showcart();
                }else{
                    toastr.error('something went wrong');
                    return false;
                }
            }
        })
    }
</script>

<script>
    function updateQty(cartid,qty){        
        $("#cover-spin").show();
        var form = new FormData();
        form.append('cartid',cartid);
        form.append('qty',qty);
        $.ajax({
            url:"{{route('website.updateQTY')}}",
            type:"POST",
            data:form,
            cache:false,
            contentType:false,
            processData:false,
            success:function(res){
                var js_data = JSON.parse(JSON.stringify(res));
                $("#cover-spin").hide();
                if(js_data.status==200){
                    toastr.success('cart updated successfull!');
                    showcart();
                }else{
                    toastr.error('something went wrong');
                    return false;
                }
            }
        })
    }
</script>



@endpush
