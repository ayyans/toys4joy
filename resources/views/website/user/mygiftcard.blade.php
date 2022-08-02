@extends('website.layouts.master')
@section('content')
<main id="products-ranking" class="order-history">
<div class="container-fluid">
    <div class="row">
    	<div class="col-12">
            <h2 class="text-center">My Gift Cards</h2>
            <table class="table">
              <thead>
                <tr>
                  <th>Card Name</th>
                  <th>Card Code</th>
                  <th>Remaining Balance</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $r)
                @php
                    $giftcard = DB::table('giftcards')->where('id' , $r->gift_card_id)->get()->first();
                @endphp
                <tr>
                  <td style=" text-align: center; padding: 25px; font-size: 30px; ">E-Gift Card ({{ $giftcard->price }})</td>
                  <td style=" text-align: center; padding: 25px; font-size: 30px; ">{{ $giftcard->code }}</td>
                  <td style=" text-align: center; padding: 25px; font-size: 30px; ">{{ $r->remaining_ammount }}</td>
              </tr>
               
             @endforeach
              </tbody>
            </table>

        </div>
    </div>
</div>

</main>

@stop