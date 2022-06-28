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
          style="margin-top:20px; max-width:600px; box-shadow: 0 0 20px rgb(0 0 0 / 10%);">
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
                    <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">{{ $data['title'] }}</h2>
                  </td>
                </tr>
                <tr>
                  <td align="center"
                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                    <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777; text-align-center">{{ $data['description'] }}</p>
                  </td>
                </tr>
                <tr>
                  <td align="left" style="padding-top: 20px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom:20px">
                      <tr>
                        <td width="75%" align="left" bgcolor="#eeeeee"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                          Order ID # </td>
                        <td width="25%" align="left" bgcolor="#eeeeee"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                          {{ $data['order_number'] }} </td>
                      </tr>
                      <tr>
                        <td width="75%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                          From </td>
                        <td width="25%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                          Toys4joy </td>
                      </tr>
                      <tr>
                        <td width="75%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                          To</td>
                        <td width="25%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                          {{ $data['to'] }} </td>
                      </tr>
                      <tr>
                        <td width="75%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                          Date Added</td>
                        <td width="25%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                          {{ $data['date'] }} </td>
                      </tr>
                      <tr>
                        <td width="75%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                          Order Status </td>
                        <td width="25%" align="left"
                          style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                          {{ $data['status'] }} </td>
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