<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <title>Toys4joy Forgot Password</title><!-- Designed by https://github.com/kaytcat -->
  <!-- Robot header image designed by Freepik.com -->
  <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Nunito);

    /* Take care of image borders and formatting */

    img {
      max-width: 600px;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    html {
      margin: 0;
      padding: 0;
    }

    a {
      text-decoration: none;
      border: 0;
      outline: none;
      color: #bbbbbb;
    }

    a img {
      border: none;
    }

    /* General styling */

    td,
    h1,
    h2,
    h3 {
      font-family: Helvetica, Arial, sans-serif;
      font-weight: 400;
    }

    td {
      text-align: center;
    }

    body {
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: none;
      width: 100%;
      height: 100%;
      color: #666;
      background: #fff;
      font-size: 16px;
      height: 100vh;
      width: 100%;
      padding: 0px;
      margin: 0px;
    }

    table {
      border-collapse: collapse !important;
    }

    .headline {
      color: #444;
      font-size: 36px;
    }

    .force-full-width {
      width: 100% !important;
    }
  </style>
  <style media="screen" type="text/css">
    @media screen {

      td,
      h1,
      h2,
      h3 {
        font-family: 'Nunito', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
      }
    }
  </style>
  <style media="only screen and (max-width: 480px)" type="text/css">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {

      table[class="w320"] {
        width: 320px !important;
      }
    }
  </style>
  <style type="text/css"></style>

</head>

<body bgcolor="#fff" class="body" style="margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none">
  <table align="center" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tbody>
      <tr>
        <td align="center" bgcolor="#fff" class="" valign="top" width="100%">
          <center class="">
            <table cellpadding="0" cellspacing="0" class="w320"
              style="margin: 50px auto 0; box-shadow: 0 0 20px rgb(0 0 0 / 10%);" width="600">
              <tbody>
                <tr>
                  <td align="center" class="" valign="top">
                    <table cellpadding="0" cellspacing="0" style="margin: 0 auto;" width="100%">
                    </table>
                    <table bgcolor="#fff" cellpadding="0" cellspacing="0" class=""
                      style="margin: 10px auto; width: 100%; margin-top: 50px;">
                      <tbody style="margin-top: 15px;">
                        <tr class="">
                          <td class="">
                            <img alt="robot picture" class="" height="auto"
                              src="http://phplaravel-788354-2698725.cloudwaysapps.com/website/img/logo-t4j.png"
                              width="100">
                          </td>
                        </tr>
                        <tr class="">
                          <td class="headline">Password Reset</td>
                        </tr>
                        <tr>
                          <td>
                            <center class="">
                              <table cellpadding="0" cellspacing="0" class="" style="margin: 0 auto;" width="75%">
                                <tbody class="">
                                  <tr class="">
                                    <td class="" style="color:#444; font-weight: 400;"><br><br>
                                      If you've lost your password or wish to reset it,<br>
                                      use the link below to get started.
                                      <br><br>
                                      <br>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td class="">
                            <div class="">
                              <a style="background-color:#2972bc;border-radius:4px;color:#fff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:normal;line-height:50px;text-align:center;text-decoration:none;width:350px;-webkit-text-size-adjust:none;"
                                href="{{ route('website.reset_password', ['email' => $data['email'], 'token' => $data['token']]) }}">Reset Your Password</a>
                            </div>
                            <br>
                          </td>
                        </tr>
                      </tbody>

                    </table>

                    <table bgcolor="#fff" cellpadding="0" cellspacing="0" class="force-full-width"
                      style="margin: 0 auto; margin-bottom: 20px;">
                      <tbody>
                        <tr>
                          <td class="" style="color:#444;
                    ">
                            <p>If you did not request a password reset, you can safely ignore this email.<br> Only a
                              person with access to your email can reset your account password.</p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </center>
        </td>
      </tr>
    </tbody>
  </table>
</body>

</html>