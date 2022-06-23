<footer class="for-desktop">
<div class="container-fluid">
    <div class="footer">
        <div class="elements">
            <div class="d-flex why-us">
                <a href="#">
                    <img src="{{asset('website/img/why-us.png')}}" class="why-text">
                    <img src="{{asset('website/img/logo-t4j.png')}}" class="why-logo">
                </a>
                <div class="company-policy">
                    <a href="#">
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
                <li><a href="#"><img src="{{asset('website/img/fb.png')}}"></a></li>
                <li><a href="#"><img src="{{asset('website/img/twitter.png')}}"></a></li>
                <li><a href="#"><img src="{{asset('website/img/instagram.png')}}"></a></li>
                <li><a href="#"><img src="{{asset('website/img/linkedin.png')}}"></a></li>
                <li><a href="#"><img src="{{asset('website/img/tiktok.png')}}"></a></li>
            </ul>
            
        </div>
        <div class="elements">
            <div class="toll-free">
                <a href="#"><img src="{{asset('website/img/phone-character.png')}}"><span>Contact us</span></a>
            </div>
        </div>
        <div class="elements">
            <div class="d-flex why-us">
                <a href="#" class="whatsapp-icon"><img src="{{asset('website/img/whatsapp.png')}}" class="whatsapp"></a>
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
                <a href="#">
                    <img src="{{asset('website/img/why-us.png')}}" class="why-text">
                    <img src="img/logo-t4j.png" class="why-logo">
                    <p>Why Choose us</p>
                </a>    
            </div>
        </div>
        <div class="col-3">
            <div class="company-policy">
                <a href="#"><img src="{{asset('website/img/2__4_-removebg-preview.png')}}"><p>Company Policy</p></a>    
            </div>
        </div>
        <div class="col-6">
            <div class="get-in-touch">
                
                <div class="toll-free">
                <a href="#"><img src="{{asset('website/img/picture9-removebg-preview.png')}}"><span>44414215</span></a>
                </div>
                
                <div class="google-play">
                    <a href="#"><img src="{{asset('website/img/google-play-store-icon.png')}}" class="app-store"></a>
                    <a href="#"><img src="{{asset('website/img/google-play-badge.png')}}" class="g-play-store"></a>
                </div>
                
                <ul class="d-flex social-media">
            	<li><a href="#"><img src="{{asset('website/img/fb.png')}}"></a></li>
                <li><a href="#"><img src="{{asset('website/img/twitter.png')}}"></a></li>
                <li><a href="#"><img src="{{asset('website/img/instagram.png')}}"></a></li>
                <li><a href="#"><img src="{{asset('website/img/linkedin.png')}}"></a></li>
                </ul>
                
            </div>
        </div>
    </div>
</div> 
</footer>
<input type="hidden" name="cust_id" value="{{ Session::get('cart_random_id') }}" id="cust_id" />
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
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
</script>

<script>
        $(function(){
           
            var cust_id = $("#cust_id").val();
            if(cust_id==null ||cust_id=='0'){
                return false;
            }else{
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
                                var  total_price = 0;
                                var cartsize = js_data.msg.length;
                              $.each(js_data.msg,function(a,v){
                                total_price += parseInt(v.cartQty)*parseInt(v.unit_price);
                                    $("#cartdetailsheader").append('<div class="d-flex added-products"> <div class="pro-image"><img src="{{asset("products")}}/'+v.featured_img+'"/></div><div class="product-detail"> <h2 class="title">'+v.title+'</h2> <h4 class="price">QAR '+v.unit_price+'</h4> <div class="d-flex rmv-or-edit"> <div class="qty"><input type="number" value="'+v.cartQty+'" id="quantity" name="quantity" min="1" max="'+v.qty+'" onchange="updateQty('+v.crtid+',this.value)"></div><div class="remove icon"><a href="javascript:void(0)" onclick="removecart('+v.crtid+')"><img src="{{asset("website/img/delete.png")}}"/></a></div></div></div></div>')    
                              })
                              $("#subtotal_price").text(total_price+' QAR'); 
                             var cnt = $("#cartdetailsheader").size;
                              $("#cartno").text(cartsize);   
                        }else{
                            $("#cartdetailsheader").append('<p>No products in cart</p>') 
                            $("#cartno").text(0);   
                        }


                    }
                })
            }
        })
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
                        location.reload();
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
                        location.reload();
                    }else{
                        toastr.error('something went wrong');
                        return false;
                    }
            }
        })
    }
</script>



@endpush