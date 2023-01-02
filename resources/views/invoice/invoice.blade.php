<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Order Invoice {{ $order->order_number }}</title>

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

    .text-green {
      color: green;
    }

    .text-red {
      color: red;
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
                <img src="{{ public_path('website/img/logo-t4j.jpg') }}" alt="toys4joy"
                  style="width: 100%; max-width: 80px" />
              </td>

              <td>
                Order ID #: {{ $order->order_number }}<br />
                Order Date: {{ $order->created_at->format('M d, Y') }}<br />
                Invoice Status: <b class="{{ ($order->payment_status == 'paid' || $order->order_type == 'cod') ? 'text-green' : 'text-red' }}">{{ $order->order_type == 'cod' ? 'COD' : strtoupper($order->payment_status) }}</b>
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
              @php
              $name = $order->user_id ? $order->user->name : $order->additional_details['name'];
              $mobile = $order->user_id ? $order->user->mobile : $order->additional_details['mobile'];
              $email = $order->user_id ? $order->user->email : $order->additional_details['email'];
              @endphp
              <td colspan="2">
                {{ $name ?? null }}.<br />
                {{ $mobile ?? null }}<br />
                {{ $email ?? null }}<br>
                {{ $order->user_id ? $order->address->fullAddress : $order->fullAddress }}
              </td>
            </tr>
          </table>
        </td>
      </tr>
      @if ($order->remarks)
      <tr>
        <td colspan="4">
          <b>Remarks: </b><span>{{ $order->remarks }}</span>
        </td>
      </tr>
      @endif
      <tr class="heading">
        <td>Item</td>
        <td style="text-align:center">Item SKU</td>
        <td style="text-align:center">Price</td>
        <td style="text-align:center">Quatity</td>
        <td style="text-align:right">Subtotal</td>
      </tr>
      @foreach($order->items as $item)
      <tr class="item">
        <td>{{ $item->product->title }}</td>
        <td style="text-align:center">{{ $item->product->sku }}</td>
        <td style="text-align:center">QAR {{ $item->price }}</td>
        <td style="text-align:center">{{ $item->quantity }}</td>
        <td style="text-align:right">QAR {{ $item->total_amount }}</td>
      </tr>
      @endforeach

      <tr class="total">
        <td colspan="2"></td>
        <td colspan="3">Total Quantity: {{ $order->items->sum('quantity') }}</td>
      </tr>
      <tr class="total">
        <td colspan="2"></td>
        <td colspan="3">Sub Total: QAR {{ $order->subtotal }}</td>
      </tr>
      @php $giftcardTotal = $order->giftcards ? $order->giftcards->sum('price') : 0 @endphp
      @if($giftcardTotal)  
        <tr class="total">
          <td colspan="2"></td>
          <td colspan="3">Discount Gift Card: QAR {{ $giftcardTotal }}</td>
        </tr>
      @endif
      @php $couponPercentage = $order->coupon ? $order->coupon->offer : 0 @endphp
      @if($couponPercentage)
        <tr class="total">
          <td colspan="2"></td>
          <td colspan="3">Discount Coupon: {{ $couponPercentage }}%</td>
        </tr>
      @endif

      <tr class="total">
        <td colspan="2"></td>
        <td colspan="3">Total Discount: QAR {{ $order->discount }}</td>
      </tr>

      <tr class="total">
        <td colspan="2"></td>
        <td colspan="3">Total Amount: QAR {{ $order->total_amount }}</td>
      </tr>
    </table>
    <br><br>
    <p>Thank you again, it is really awesome to have you as one of our paid users. We hope that you will be happy with
      toys4joy, if you ever have any questions, suggestions or concerns please do not hesitate to contact us.</p>
    <br>
    <b> Email: info@toys4joy.com | Website: toys4joy.com.</b>
    <br>
  </div>
</body>

</html>