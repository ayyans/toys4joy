@extends('website.layouts.master')
@section('content')

<main id="pay-as-member">
<div class="container-fluid">
    <div class="row">
       
    	<div class="col-6 member-col left">
        <form action="#" id="checkoutFrm">
            <?php $total_price = 0; ?>
            @foreach($products as $product)
            <?php $total_price+=$product->unit_price*$product->cartQty; ?>
            <input type="hidden" id="prod_id" value="{{$product->id}}" name="prodid[]" />
            <input type="hidden" id="cart_qty" value="{{$product->cartQty}}" name="cartQty[]" />
            <input type="hidden" id="cart_amount" value="{{$product->unit_price}}" name="cart_amount[]" />
            <div class="d-flex cart-products">
                <div class="cart-image"><img src="{{asset('products/'.$product->featured_img)}}"/></div>
                <div class="product-detail">
                    <h2 class="title">{{$product->title}}</h2>
                    <h4 class="price">AED {{$product->unit_price}}</h4>
                    <div class="qty">Quantity : {{$product->cartQty}}</div>
                    <div class="d-flex rmv-or-edit">
                        <div class="remove icon"><a href="javascript:void(0)" onclick="removecart({{$product->crtid}})"><img src="{{asset('website/img/delete.png')}}"/></a></div>
                        <!-- <div class="edit icon"><a href="#"><img src="{{asset('website/img/edit.png')}}"/></a></div> -->
                    </div>
                </div>
            </div>
            @endforeach
            </form>
            <div class="discount-block">
            	<div class="mb-3">
                	<label>Discount Code</label>
                	<input type="text" id="discount_coupon">
                	<button class="btn btn-primary discountBtn">Enter</button>
                </div>
                <div class="mb-3">
                	<label>Gift-Card Code</label>
                	<input type="text" id="giftcard_coupon">
                	<button class="btn btn-primary giftBtn">Enter</button>
                </div>
            </div>
            <div class="code-block">
            	<div class="mb-3">
                	<label>Corporate Code</label>
                	<input type="text" id="corporate_code">
                	<button class="btn btn-primary corporateBtn">Enter</button>
                </div>
                <div class="mb-3">
                	<label>Verify the OTP Code</label>
                	<input type="text" id="verifyotp">
                	<button class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        <div class="col-6 member-col right text-center">
            <div class="final-price">Your Final Price : <span id="total_offer_amt">{{$total_price}}</span> AED</div>
            <input type="hidden" id="total_amt" value="{{$total_price}}" />
            <input type="hidden" id="prev_amt" value="{{$total_price}}"/>
            <div class="input-security">
            	<h2>Security Code</h2>
				<div class="d-flex">               
                	<input type="text">
                	<img src="{{asset('website/img/cvv.png')}}"/>
                </div>
                <label>Enter the security code</label>
            </div>
            <button>Pay as Member</button>
            <div class="yellowbg-img cash-on-delivery">
            	<img src="{{asset('website/img/cash-on-delievery.png')}}"/>
                <a href="javascript:void(0)" id="cashOnD">Cash or Credit<br>on Delivery</a>
            </div>
        </div>
    </div>
</div>

</main>
    

@stop


@push('otherscript')
<script>
    $(function(){
        $("button.discountBtn").click(function(e){
            e.preventDefault();
            var total_amt3 = $("#prev_amt").val();
            $("#total_offer_amt").text(total_amt3);
            $("#total_amt").val(total_amt3);  
            var discount_coupon = $("#discount_coupon").val();
            if(discount_coupon==''){
                return false;
            }else{
                $("#cover-spin").show();
                var form = new FormData();
                form.append('discount_coupon',discount_coupon);
                $.ajax({
                    url:"{{route('website.discount_coupon')}}",
                    type:"POST",
                    data:form,
                    cache:false,
                    contentType:false,
                    processData:false,
                    success:function(res){
                        $("#cover-spin").hide();
                        var js_data = JSON.parse(JSON.stringify(res));
                        if(js_data.status==200){
                            var total_amt = $("#total_amt").val();
                            var total_amt2 = parseInt(total_amt);
                            var discount_offer = total_amt2*parseInt(js_data.msg.offer)/100;
                            var total_amt_with_dis = total_amt2-parseInt(discount_offer);
                            $("#total_offer_amt").text(total_amt_with_dis);
                            $("#total_amt").val(total_amt_with_dis);

                        }else{
                            var total_amt = $("#prev_amt").val();
                           $("#total_offer_amt").text(total_amt);
                           $("#total_amt").val(total_amt);     
                        }

                    }
                })
            }
        });

        // gift card counpon 


        $("button.giftBtn").click(function(e){
            e.preventDefault();
            var total_amt3 = $("#prev_amt").val();
            $("#total_offer_amt").text(total_amt3);
            $("#total_amt").val(total_amt3);  
            var discount_coupon = $("#giftcard_coupon").val();
            if(discount_coupon==''){
                return false;
            }else{
                $("#cover-spin").show();
                var form = new FormData();
                form.append('discount_coupon',discount_coupon);
                $.ajax({
                    url:"{{route('website.giftcard_coupon')}}",
                    type:"POST",
                    data:form,
                    cache:false,
                    contentType:false,
                    processData:false,
                    success:function(res){
                        $("#cover-spin").hide();
                        var js_data = JSON.parse(JSON.stringify(res));
                        if(js_data.status==200){
                            var total_amt = $("#total_amt").val();
                            var total_amt2 = parseInt(total_amt);
                            var discount_offer = total_amt2*parseInt(js_data.msg.offer)/100;
                            var total_amt_with_dis = total_amt2-parseInt(discount_offer);
                            $("#total_offer_amt").text(total_amt_with_dis);
                            $("#total_amt").val(total_amt_with_dis);

                        }else{
                            var total_amt = $("#prev_amt").val();
                           $("#total_offer_amt").text(total_amt);
                           $("#total_amt").val(total_amt);     
                        }

                    }
                })
            }
        })

        // corporate coupon code

        

        $("button.corporateBtn").click(function(e){
            e.preventDefault();
            var total_amt3 = $("#prev_amt").val();
            $("#total_offer_amt").text(total_amt3);
            $("#total_amt").val(total_amt3);  
            var discount_coupon = $("#corporate_code").val();
            if(discount_coupon==''){
                return false;
            }else{
                $("#cover-spin").show();
                var form = new FormData();
                form.append('discount_coupon',discount_coupon);
                $.ajax({
                    url:"{{route('website.corporate_coupon')}}",
                    type:"POST",
                    data:form,
                    cache:false,
                    contentType:false,
                    processData:false,
                    success:function(res){
                        $("#cover-spin").hide();
                        var js_data = JSON.parse(JSON.stringify(res));
                        if(js_data.status==200){
                            var total_amt = $("#total_amt").val();
                            var total_amt2 = parseInt(total_amt);
                            var discount_offer = total_amt2*parseInt(js_data.msg.offer)/100;
                            var total_amt_with_dis = total_amt2-parseInt(discount_offer);
                            $("#total_offer_amt").text(total_amt_with_dis);
                            $("#total_amt").val(total_amt_with_dis);

                        }else{
                            var total_amt = $("#prev_amt").val();
                           $("#total_offer_amt").text(total_amt);
                           $("#total_amt").val(total_amt);     
                        }

                    }
                })
            }
        })



    })
</script>

<script>
    $("#cashOnD").click(function(e){
        e.preventDefault();
        var total_amt = $("#total_amt").val();
        var form = $("form#checkoutFrm")[0];
        var form2 = new FormData(form);
        form2.append('amount',total_amt);
        form2.append('mode','1')
        $("#cover-spin").show();
        $.ajax({
            url:"{{route('website.placeorder')}}",
            type:"POST",
            data:form2,
            cache:false,
            contentType:false,
            processData:false,
            success:function(res){
                $("#cover-spin").hide();
                var js_data = JSON.parse(JSON.stringify(res));
                if(js_data.status==200){
                    window.location.href="{{route('website.guestthank')}}"
                }else{
                    return false;
                }
            }
        })

    })
</script>

@endpush