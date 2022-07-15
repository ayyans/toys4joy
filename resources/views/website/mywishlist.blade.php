@extends('website.layouts.master')
@section('content')
<main id="products-ranking" class="my-basket my-wishlist-page">
<div class="container-fluid">
    <div class="row">
    	<div class="col-12">
            <div class="d-flex main-title">
                <div class="title">My Wish List</div>
                <div class="icon">
                    <button class="btn btn-primary" type="button"><img src="{{asset('website/img/wishlist-heart.png')}}" class="wishlist"></button>
                </div>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th class="first"></th>
                  <th>Name</th>
                  <th>Images</th>
                  <th>Prices</th>
                  <th class="last"></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $total_price = 0; ?>
                @foreach($wshlists as $wishlist)
                @php
                if($wishlist->discount)
                {
                    $price = $wishlist->discount;
                }else{
                    $price = $wishlist->unit_price;
                }
                @endphp

                <?php $total_price+=$price; ?>
                <tr>
                    <td class="qty"><input type="number" value="1" id="quantity" name="quantity" min="{{$wishlist->min_qty}}" max="{{$wishlist->qty}}" class="quantity" data="{{$wishlist->id}}"></td>
                    <td class="title">
                      <div class="d-flex product-rank">
                          <div class="detail"><a href="{{route('website.productDetails',[encrypt($wishlist->category_id),encrypt($wishlist->id)])}}" style="text-decoration:none"><p>{{$wishlist->title}}</p></a></div>
                      </div>
                    </td>
                    <td><div class="img-box"><a href="{{route('website.productDetails',[encrypt($wishlist->category_id),encrypt($wishlist->id)])}}"><img src="{{asset('products/'.$wishlist->featured_img)}}"/></a></div></td>
                    <td class="price"><span>{{$price}} QAR</span></td>
                    <td class="delete"><div class="rmv-icon"><a href="{{route('website.removeWishlist',[encrypt($wishlist->wish_id)])}}"><img src="{{asset('website/img/delete-product.png')}}"/></a></div></td>
                    <td><button class="btn btn-success addtocartBtn{{$wishlist->id}}" onclick="addtocart({{$wishlist->id}},1,{{$price}})" >Add to cart</button></td>
                </tr>
                @endforeach
               

              </tbody>
              <tfoot>
                <tr>
                    <td colspan="2">Total Price</td>
                   
                    <td colspan="4">{{$total_price}} QAR</td>
  
                </tr>
              </tfoot>    
            </table>
            
            <div class="d-flex ftr-btn-area">
            <p id="copied"></p>
                <div class="d-flex copy-link">
                   
                    <img src="{{asset('website/img/link.png')}}" onclick="copyToClipboard()">
                   
                    <div>Copy this link, and share it with the ones you love to help them buying your favorite toys.</div>
                </div>
                <div class="d-flex pay-as">
                    <div class="vertical-shake add-more"><a href="{{route('website.home')}}">Add More</a></div>
                </div>
            </div>

        </div>
    </div>
</div>

</main>

@stop

@push('otherscript')

<script>
function copyToClipboard(text) {
var inputc = document.body.appendChild(document.createElement("input"));
inputc.value = "{{route('website.sharewishlist',[Auth::user()->id])}}";
inputc.focus();
inputc.select();
document.execCommand('copy');
inputc.parentNode.removeChild(inputc);
$('#copied').text('copied !!')
}
</script>

<script>
  $("input.quantity").change(function(){
    var id = $(this).attr('data');
    var qty = $(this).val();
    $("button.addtocartBtn"+id).attr('data',qty);
  })
</script>
@endpush