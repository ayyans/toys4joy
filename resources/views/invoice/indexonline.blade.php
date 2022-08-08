@php
  $order = DB::table('orders')->where('orderid' , $ordernumber)->get();
  $customer = DB::table('users')->where('id' , $order->first()->cust_id)->get()->first();
  $customer_addresses = DB::table('customer_addresses')->where('cust_id' , $order->first()->cust_id)->get()->first();
@endphp
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Order Invoice {{ $ordernumber }}</title>

    <!-- Favicon -->
    <link rel="icon" href="https://www.toys4joy.com/website/img/logo-t4j.png" type="image/x-icon" />

    <!-- Invoice styling -->
    <style>
      body {
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        text-align: center;
        color: #777;
      }

      body h1 {
        font-weight: 300;
        margin-bottom: 0px;
        padding-bottom: 0px;
        color: #000;
      }

      body h3 {
        font-weight: 300;
        margin-top: 10px;
        margin-bottom: 20px;
        font-style: italic;
        color: #555;
      }

      body a {
        color: #06f;
      }

      .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
      }

      .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        border-collapse: collapse;
      }

      .invoice-box table td {
        padding: 5px;
        vertical-align: top;
      }

      .invoice-box table tr td:nth-child(2) {
        text-align: right;
      }

      .invoice-box table tr.top table td {
        padding-bottom: 20px;
      }

      .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
      }

      .invoice-box table tr.information table td {
        padding-bottom: 40px;
      }

      .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
      }

      .invoice-box table tr.details td {
        padding-bottom: 20px;
      }

      .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
      }

      .invoice-box table tr.item.last td {
        border-bottom: none;
      }

      .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
      }

      @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
          width: 100%;
          display: block;
          text-align: center;
        }

        .invoice-box table tr.information table td {
          width: 100%;
          display: block;
          text-align: center;
        }
      }
    </style>
  </head>

  <body>
    <div class="invoice-box">
        
      <table>
        <tr class="top">
          <td colspan="4">
            <table>
              <tr>
                <td class="title">
                  <img src="{{ public_path('website/img/logo-t4j.jpg') }}" alt="toys4joy" style="width: 100%; max-width: 80px" />
                </td>
                <?php $total_price = 0; ?>
                @foreach($order as $r)
                @php
                  $product = DB::table('products')->where('id' , $r->prod_id)->get()->first();
                  if($product->discount)
                  {
                      $price = $product->discount;
                  }else{
                      $price = $product->unit_price;
                  }

                @endphp
                <?php $total_price+=$price*$r->qty; ?>
                @endforeach
                @if($order->first()->giftcode)
                @php
                  $usergiftcard = DB::table('usergiftcards')->where('code' , $order->first()->giftcode)->get()->first();
                  $giftcard = DB::table('giftcards')->where('id' , $usergiftcard->gift_card_id)->get()->first();

                  $giftcardprice = $total_price-$giftcard->price;

                  if($giftcardprice < 0)
                  {
                    $total_price = 0;
                  }else{
                    $total_price = $giftcardprice;
                  }

                @endphp
                
                @endif

                <td>
                  Order ID #: {{ $ordernumber }}<br />
                  Order Date: {{ date('M d, Y', strtotime($order->first()->created_at)) }}<br />
                  Invoice Status: <b style="color: green;">
                    @if($total_price == 0)

                    PAID

                    @else

                    @if($order->first()->mode == 2)
                  PAID
                  @else 

                  COD

                  @endif

                  @endif
                </b>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr class="information">
          <td colspan="4">
            <table>
              <tr>
                <td colspan="2">
                  Toys4joy.<br />
                  7GJ3+766,Doha, Qatar.<br />
                  Email: operation@toys4joy.com
                </td>

                <td colspan="2">
                  {{ $customer->name }}.<br />
                  {{ $customer->mobile }}<br />
                  {{ $customer->email }}<br>
                  {{$customer_addresses->unit_no}},{{$customer_addresses->building_no}},{{$customer_addresses->zone}},{{$customer_addresses->street}}
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr class="heading">
          <td>Item</td>
          <td style="text-align:center">Item SKU</td> 
          <td style="text-align:center">Price</td>
          <td style="text-align:center">Quatity</td>
          <td style="text-align:right">Subtotal</td>
        </tr>
        <?php $total_price = 0; ?>
        @foreach($order as $r)
        @php
          $product = DB::table('products')->where('id' , $r->prod_id)->get()->first();
          if($product->discount)
          {
              $price = $product->discount;
          }else{
              $price = $product->unit_price;
          }

        @endphp
        <?php $total_price+=$price*$r->qty; ?>
        <tr class="item">
          <td>{{ $product->title }}</td>
          <td style="text-align:center">{{ $product->sku }}</td>
          <td style="text-align:center">QAR {{ $price }}</td>
          <td style="text-align:center">{{ $r->qty }}</td>
          <td style="text-align:right">QAR {{ $price*$r->qty }}</td>
        </tr>
        @endforeach

        <tr class="total">
          <td colspan="2"></td>
          <td colspan="3">Sub Total: QAR {{ $total_price }}</td>
        </tr>
        @if($order->first()->giftcode)
        
        @php
          $usergiftcard = DB::table('usergiftcards')->where('code' , $order->first()->giftcode)->get()->first();
          $giftcard = DB::table('giftcards')->where('id' , $usergiftcard->gift_card_id)->get()->first();

          $giftcardprice = $total_price-$giftcard->price;

          if($giftcardprice < 0)
          {
            $total_price = 0;
          }else{
            $total_price = $giftcardprice;
          }

        @endphp
        <tr class="total">
          <td colspan="2"></td>
          <td colspan="3">Discount Gift Card: QAR {{ $giftcard->price }}</td>
        </tr>
        @endif

        <tr class="total">
          <td colspan="2"></td>
          <td colspan="3">Total: QAR {{ $total_price }}</td>
        </tr>
      </table> 
        <br><br>
        <p>Thank you again, it is really awesome to have you as one of our paid users. We hope that you will be happy with toys4joy, if you ever have any questions, suggestions or concerns please do not hesitate to contact us.</p>
        <br>
       <b> Email: info@toys4joy.com | Website: toys4joy.com.</b>
        <br>
    </div>
  </body>
</html>