<!DOCTYPE html>
<html>

<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <style type="text/css">
    body,
    table,
    td,
    a {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }

    table,
    td {
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    img {
      -ms-interpolation-mode: bicubic;
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
    }

    table {
      border-collapse: collapse !important;
    }

    body {
      height: 100% !important;
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;
    }

    a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: 'Nunito', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    @media screen and (max-width: 480px) {
      .mobile-hide {
        display: none !important;
      }

      .mobile-center {
        text-align: center !important;
      }
    }

    div[style*="margin: 16px 0;"] {
      margin: 0 !important;
    }
  </style>

<body style="margin: 0 !important; padding: 0 !important; background-color: #fff;" bgcolor="#fff">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td align="center" style="background-color: #fff;" bgcolor="#fff">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
          style="max-width:600px;box-shadow: 0 0 20px rgb(0 0 0 / 10%);">
          <tr>
            <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                <tr class="logo" style="text-align:center;">
                  <td class="">
                    <img alt="robot picture" class="" height="auto"
                      src="http://phplaravel-788354-2698725.cloudwaysapps.com/website/img/logo-t4j.png" width="100">
                  </td>
                </tr>
                <tr>
                  <td align="center"
                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                    <br>
                    <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;"> Thank
                      You For Your Order! </h2>
                  </td>
                </tr>
                <tr>
                  <td align="left"
                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                    <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;"> Your order has
                      been received and is now being processed. Your order details are shown below for your reference:
                    </p>
                  </td>
                </tr>
                <tr>
                  <td align="left" style="padding-top: 20px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td width="75%" align="left" bgcolor="#eeeeee"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                          Order Confirmation # </td>
                        <td width="25%" align="left" bgcolor="#eeeeee"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                          {{ $data['order_number'] }} </td>
                      </tr>
                      @foreach ($data['products'] as $index => $name )

                      @php

                        $product = DB::table('products')->where('title' , $name)->get()->first();

                      @endphp
                      <tr> 
                        <td width="65%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                          {{ $name }} ({{ $data['quantity'][$index] }}) </td>
                          <td width="75%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                          {{ $product->sku }}</td>
                        <td width="25%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                          {{ 'QAR ' . $data['amount'][$index] }} </td>
                      </tr>
                      @endforeach
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="left" style="padding-top: 20px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td width="75%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                          TOTAL </td>
                        <td width="25%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                          {{ 'QAR ' . number_format($data['total'], 2) }} </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center" height="100%" valign="top" width="100%"
              style="padding: 0 35px 35px 35px; background-color: #ffffff;" bgcolor="#ffffff">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
                <tr>
                  <td align="center" valign="top" style="font-size:0;">
                    <div style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;">
                      <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"
                        style="max-width:300px;">
                        <tr>
                          <td align="left" valign="top"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                            <p style="font-weight: 800;">Delivery Address</p>
                            <p>{{ $data['address'] }}</p>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;">
                      <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"
                        style="max-width:300px;">
                        <tr>
                          <td align="left" valign="top"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                            <p style="font-weight: 800;">Estimated Delivery Time</p>
                            <p>3 to 5 working days</p>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center" style=" padding: 10px; background-color: #2972bc;" bgcolor="#2972bc">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                <tr>
                  <td align="center"
                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                    <h2 style="font-size: 24px; font-weight: 800; line-height: 30px; color: #ffffff; margin: 0;"> Get
                      30% off your next order. </h2>
                  </td>
                </tr>
                <tr>
                  <td align="center" style="padding: 25px 0 15px 0;">
                    <table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" style="border-radius: 5px;" bgcolor="#2972bc"> <a href="{{ route('website.home') }}" target="_blank"
                            style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #26a557; padding: 15px 30px; border: 1px solid #26a557; display: block;">Shop
                            Again</a> </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>