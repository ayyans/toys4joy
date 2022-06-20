@extends('website.layouts.master')
@section('content')

<main id="products-ranking" class="my-basket">
<div class="container-fluid">
    <div class="row">
    	<div class="col-12">
            <div class="d-flex main-title">
                <div class="title">My Basket</div>
                <div class="icon">
                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><img src="{{asset('website/img/cart.png')}}" class="cart"></button>
                </div>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th class="first">Qty</th>
                  <th>Name</th>
                  <th>Images</th>
                  <th>Prices</th>
                  <th class="last"></th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                  $total_price = 0;
                  ?>
                  @foreach($carts as $cart)
                  <?php 
                  $total_price+=$cart->unit_price*$cart->cartQty;
                   ?>
                <tr>
                    <td class="qty"><input type="number" value="{{$cart->cartQty}}" id="quantity" name="quantity" min="1" max="{{$cart->qty}}" onchange="updateQty({{$cart->crtid}},this.value)"></td>
                    <td class="title">
                      <div class="d-flex product-rank">
                          <div class="detail"><p>{{$cart->title}}</p></div>
                      </div>
                    </td>
                    <td><div class="img-box"><img src="{{asset('products/'.$cart->featured_img)}}"/></div></td>
                    <td class="price"><span>{{$cart->unit_price}}</span></td>
                    <td class="delete"><div class="rmv-icon"><a href="javascript:void(0)" onclick="removecart({{$cart->crtid}})"><img src="{{asset('website/img/delete-product.png')}}"/></a></div></td>
                </tr>
                @endforeach
               

              </tbody>
              <tfoot>
                <tr>
                    <td colspan="2">Total Price</td>
                    <td></td>
                    <td>{{$total_price}}</td>
                    <td></td>
                </tr>
              </tfoot>    
            </table>
            
            <div class="d-flex ftr-btn-area">
                <div class="vertical-shake continue-shopping"><a href="javascript:void(0)">Continue Shopping</a></div>
                <div class="d-flex pay-as">
                    <div class="member"><a href="{{route('website.payasmember')}}">Proceed to checkout</a></div>
                    <!-- <div class="guest"><a href="javascript:void(0)">Pay as Guest</a></div> -->
                </div>
            </div>

        </div>
    </div>
</div>

</main>

@stop