<footer class="for-desktop">
<div class="container-fluid">
    <div class="footer">
        <div class="elements">
            <div class="d-flex why-us">
                <a href="{{ route('website.whyus') }}">
                    <img src="{{asset('website/img/why-us.png')}}" class="why-text">
                    <img src="{{asset('website/img/logo-t4j.png')}}" class="why-logo">
                </a>
                <div class="company-policy">
                    <a href="{{ route('website.policy') }}">
                        <img src="{{asset('website/img/2__4_-removebg-preview.png')}}">
                        <span>COMPANY POLICY</span>
                    </a>
                </div>    
            </div>
        </div>
        <div class="d-flex elements app-s-media">
            <div class="google-play">
                <a href="#"><img src="{{asset('website/img/ios.png')}}" class="app-store"></a>
                <a href="#"><img src="{{asset('website/img/android.png')}}" class="g-play-store"></a>
            </div>
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
        <div class="elements">
            <div class="toll-free">
                <a href="{{ route('website.contact') }}"><img src="{{asset('website/img/phone-character.png')}}"><span>Contact us</span></a>
            </div>
        </div>
        <div class="elements">
            <div class="d-flex why-us">
                <a href="https://api.whatsapp.com/send?phone=97460005970&text=Welcome%20to%20Toys4joy" target="_blank" class="whatsapp-icon">
                    <img src="{{asset('website/img/whatsapp.png')}}" class="whatsapp">
                </a>
            </div>
        </div>
    </div>
</div> 
</footer>




    
<footer class="for-mobile">
<div class="container-fluid">
    <div class="text-center footer">
        <div class="col-3">
            <div class="why-us">
                <a href="{{ route('website.whyus') }}">
                    <img src="{{asset('website/img/why-us.png')}}" class="why-text">
                    <img src="img/logo-t4j.png" class="why-logo">
                    <p>Why Choose us</p>
                </a>    
            </div>
        </div>
        <div class="col-3">
            <div class="company-policy">
                <a href="{{ route('website.policy') }}">
                    <img src="{{asset('website/img/2__4_-removebg-preview.png')}}"><p>Company Policy</p>
                </a>    
            </div>
        </div>
        <div class="col-6">
            <div class="get-in-touch">
                
                <div class="toll-free">
                <a href="{{ route('website.contact') }}"><img src="{{asset('website/img/phone-character.png')}}"><span>Contact us</span></a>
                </div>
                
                <div class="google-play">
                    <a href="#"><img src="{{asset('website/img/ios.png')}}" class="app-store"></a>
                    <a href="#"><img src="{{asset('website/img/android.png')}}" class="g-play-store"></a>
                </div>
                
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
            <div class="elements">
                <div class="d-flex why-us">
                    <a href="https://api.whatsapp.com/send?phone=97460005370&text=Welcome%20to%20Toys4joy" target="_blank" class="whatsapp-icon">
                        <img src="{{asset('website/img/whatsapp.png')}}" class="whatsapp mobile">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> 
</footer>
<input type="hidden" name="cust_id" value="{{ Cmf::ipaddress() }}" id="cust_id" />
@include('website.layouts.loader')
@push('otherscript')
<script>
   function addtocart(prod_id,qty,amt){
        var form =new FormData();
        form.append('prod_id',prod_id);
        form.append('quantity',qty);
        form.append('amt',amt);
        $("#cover-spin").show();
        $.ajax({
            url:"{{route('website.addTocart')}}",
            type:"POST",
            data:form,
            cache:false,
            contentType:false,
            processData:false,
            success:function(res){
                $("#cover-spin").hide();
                var js_data = JSON.parse(JSON.stringify(res));
                if(js_data.status==200){
                    toastr.success('Product added to cart');
                    headercart();
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
                    var cartsize = js_data.msg.length;
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
    function removecart(cartid){
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