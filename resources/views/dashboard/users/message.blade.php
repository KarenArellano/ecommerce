<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{!! $email->subject !!}</title>
</head>

<body>

    <head>
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="x-apple-disable-message-reformatting">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css" data-premailer="ignore">
        </style>
    </head>

    <body style="background-color: {!! $email->background_color !!};
        padding: 30px;
        text-align: center;color: #000000;">

        <table width="95%" cellpadding="0" cellspacing="0" align="center" style="min-width: 50%;" role="presentation">
            <tbody>
                <tr>
                    <th data-id="store-info" style="mso-line-height-rule: exactly;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <!-- Store Website : BEGIN -->
                            <tbody style="background-color: #ffffff;">
                                <tr>
                                    <th>
                                        <h3>HOLA, {!! $user->name !!}</h3>

                                        <h2 cols="30" rows="10">{!! $email->message !!}</h2>
                                    </th>
                                </tr>
                                @if($email->image)
                                <tr>
                                    <th>

                                        <img src="{{ $email->image->public_url }}" alt="no image" style="vertical-align:middle;text-align:center;width:140px;max-width:140px;height:auto!important;border-radius:1px;padding:0px">
                                    </th>
                                </tr>
                                @endif
                                <tr>
                                    <th class="column_shop_block1 " width="100%" style="mso-line-height-rule: exactly; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Arial,'Karla'; font-size: 14px; line-height: 24px; font-weight: 400; color: #a3a1a1; text-transform: none; padding-bottom: 13px; padding-top: 26px;" align="center">
                                        <a href="{{ url('/') }}" target="_blank" data-key="section_shop_block1" style="text-decoration: none !important; text-underline: none; font-size: 14px; font-weight: 400; text-transform: none; color: #000000">
                                            © {{ date('Y') }} {{ config('app.name') }} <br>
                                        </a>
                                        @lang('All rights reserved.')
                                    </th>
                                </tr>
                                <!-- Store Website : END -->
                            </tbody>
                        </table>
                    </th>
                </tr>
            </tbody>
        </table>
    </body>

</html>