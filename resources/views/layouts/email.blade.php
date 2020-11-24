
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Rajdhani|Roboto');

        @media only screen and (max-width: 480px){
            .device-width {width:380px !important;height:auto !important;min-width:380px !important;}
            .device-width-inner {width:310px !important; height: auto !important;float:left !important;}
            .mobile-hide {display:none !important;}
            .mobile-nav {padding:10px 20px !important; height:auto !important;display:table-row !important;width:100% !important;}
            .mobile-center {text-align:center !important;}
            .mobile-small-text {font-size:18px !important;}
            .mobile-center-table {float:none !important;margin:0 auto !important;}
            .text-center {text-align:center !important;}
            .padding-top {padding-top:20px !important;}
            .center-image {margin:0 auto !important;}
            .logo-small {width:200px !important; height:auto !important;}
            .full-width-image-container img {width:100% !important; height:auto !important;}

        }
    </style>
    <!--[if mso]>
    <style>
        span, td, table, div {
        }
    </style>
    <![endif]-->
    <title></title>
</head>
<body style="background-color:#f6f6f6;">
<table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100% !important;">
    <tr>
        <td>
            <table align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" width="650" style="margin:0 auto !important;" class="device-width">
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%" style="width:90% !important;margin:0 auto !important;">
                            <tr>
                                <td style="padding-top:20px;" class="text-center">
                                    <div class="mktEditable" id="logo">
                                        <a href="{{ config('basics.site_link') }}"><img src="{{ url('extra-resources/logo.png') }}" alt="" width="200" height="61"></a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                {{--<tr>--}}
                    {{--<td height="15"></td>--}}
                {{--</tr>--}}
                <tr>
                    <td>
                        <table bgcolor="#F5F5F5" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100% !important;">
                            <tr>
                                <td height="15"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                {{--<tr>--}}
                    {{--<td height="35"></td>--}}
                {{--</tr>--}}
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%" style="width:90% !important;margin:0 auto !important;">
                            <tr>
                                <td>
                                    <div class="mktEditable" id="section-1">
                                        <h3 style="font-family: 'Rajdhani', sans-serif; color: #333333;">@yield('greeting')</h3>
                                        <span style="font-family: 'Roboto', sans-serif;color:#848484;font-size:14px;line-height:22px;">
                                            @yield('message')
                                        </span>

                                        @yield('buttons')

                                        <div style="margin-top: 30px;">
                                            <hr style="height: 2px; background: #66CC99; border:none;">
                                            <p style="font-family: 'Roboto', sans-serif;color:#848484;font-size:12px;">{!! trans('email.basics.bye') !!}</p>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td>
                        <table bgcolor="#F5F5F5" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100% !important;">
                            <tr>
                                <td height="15"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%" style="width:90% !important;margin:0 auto !important;">
                            <tr>
                                <td height="20"></td>
                            </tr>
                            <tr>
                                <td>
                                    <!--[if (gte mso 9)|(IE)]>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td>
                                    <![endif]-->
                                    <div class="mktEditable" id="social-1">
                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="292.5" class="device-width-inner mobile-center-table">
                                            <tr>
                                                <td>
                                                    <a href="{{ config('basics.facebook_link') }}" style="text-decoration:none" target="_blank"><img alt="Facebook" height="40" src="{{ url('extra-resources/icon-facebook.png') }}" title="Facebook" width="40" style="margin:0;border:0;"></a>
                                                </td>
                                                <td style="font-size:12px;font-family: 'Roboto', sans-serif;color:#666666;line-height:18px;padding-left:10px">
                                                    <a href="{{ config('basics.facebook_link') }}" style="text-decoration:none;color:#848484" target="_blank">Volg ons op Facebook</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    <td>
                                    <![endif]-->
                                    <div class="mktEditable" id="social-2">
                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="292.5" class="device-width-inner mobile-center-table padding-top">
                                            <tr>
                                                <td>
                                                    <a href="{{ config('basics.linkedin_link') }}" style="text-decoration:none" target="_blank"><img alt="Linkedin" height="40" src="{{ url('extra-resources/icon-linkedin.png') }}" title="Linkedin" width="40" style="margin:0;border:0;"></a>
                                                </td>
                                                <td style="font-size:12px;font-family: 'Roboto', sans-serif;color:#666666;line-height:18px;padding-left:10px">
                                                    <a href="{{ config('basics.linkedin_link') }}" style="text-decoration:none;color:#848484" target="_blank">Volg ons op Linkedin</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="20"></td>
                </tr>

            </table>
        </td>
    </tr>
    <tr>
        <td height="15"></td>
    </tr>
    <tr>
        <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="650" class="device-width" style="margin:0 auto !important;text-align:center;">
                <tbody>
                <tr>
                    <td style="padding-bottom:20px;padding-right:20px;padding-left:20px" valign="top">
                        <div class="mktEditable" id="footer">
                                	<span style="font-size:11px;line-height:16px;font-family: 'Roboto', sans-serif;color:#666666;">
                                     {{ trans('email.basics.footer_text', ['year' => date('Y')]) }} <bn /><a href="{{ config('basics.site_link') }}" style="color:#666666;font-family: 'Roboto', sans-serif;" target="_blank"><br>
                                    {{ config('app.name') }}</a></span></div>
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>
        </td>
    </tr>
</table>
</body>
</html>