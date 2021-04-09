<!-- / Full width container -->
<!DOCTYPE html>
<htmL>
<head>
</head>
<body>
<table class="full-width-container" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"
       bgcolor="#eeeeee"
       style="width: 100%; height: 100%; padding: 30px 0 30px 0; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
    <tr>
        <td align="center" valign="top">
            <!-- / 700px container -->
            <table class="container" border="0" cellpadding="0" cellspacing="0" width="720" bgcolor="#ffffff"
                   style="width: 720px;">
                <tr>
                    <td align="center" valign="top">
                        <!-- / Header -->
                        <table class="container header" border="0" cellpadding="10" cellspacing="10" width="720"
                               style="background: #1A2155; ">
                            <tr>
                                <td align="left">
                                    @if($company->logo!="")
                                        <img src="{{ $company->logo }}" width="100" height="50"
                                             alt="{{ $company->name }}"/>
                                    @else
                                        <h1>{{ $tutorial->name }}</h1>
                                    @endif
                                </td>
                                <td align="right">
                                    <b style="color: #fff; font-size: 18px; text-decoration: none; vertical-align: bottom;">Cooperative
                                        Account Manager</b>
                                </td>

                            </tr>
                        </table>
                        <!-- /// Header -->

                        <!-- / Hero subheader -->
                        <table style="color: #1A2155;" class="container hero-subheader" border="0" cellpadding="0"
                               cellspacing="0" width="640" style="width: 640px;">
                            <tr>
                                <!-- <td class="hero-subheader__title" style="font-size: 43px; font-weight: bold; padding: 80px 0 15px 0;" align="left">Product Design Portfolio</td> -->
                                <td class="hero-subheader__title"
                                    style="font-size:16px; font-weight: 600; padding: 30px 0 15px 0;" align="left">
                                    Dear {{$staff->name}},
                                </td>
                            </tr>

                            <tr>
                                <td class="hero-subheader__content" style="font-size: 16px; line-height: 30px;"
                                    align="left">
                                    We wish to inform you that your <b>{{ $company->name }}</b> cooperative staff
                                    account has
                                    been successfully created and we are pleased to give you online access to your
                                    account.
                                    <br><br>
                                    In order to log in, kindly follow the steps below:
                                    <br> <br>
                                    1. Click on this <a
                                        href="{{ $link = url('password/reset', $token).'?email='.urlencode($staff->user->getEmailForPasswordReset()) }}">link</a>
                                    and
                                    use your
                                    new log-in details below to access your account
                                    <br>
                                    <span
                                        style=" padding-left: 30px;">Email: <b>{{ $staff->email }}</b></span>
                                    <br>

                                    2. Please provide a valid password as this will allow you log into the account.
                                    <br>

                                    3. Remember to sign out when you are done
                                    <br> <br>
                                    Please do not hesitate to contact us via email or a call if you have any questions.
                                    <br>
                                    Thank you for giving us the opportunity to be of service to you and we look forward
                                    to a long and mutually beneficial relationship with you.

                                </td>
                            </tr>
                        </table>
                        <!-- /// Hero subheader -->
                        <br>

                        <table style="color: #1A2155;" class="container hero-subheader" border="0" cellpadding="0"
                               cellspacing="0" width="640" style="width: 640px;">
                            <tr>
                                <td class="hero-subheader__content" style="font-size: 16px; line-height: 30px;"
                                    align="left">
                                    Regards,
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table style="color: #1A2155;" class="container hero-subheader" border="0" cellpadding="0"
                               cellspacing="0" width="640" style="width: 640px;">
                            <tr>
                                <td class="hero-subheader__content" style="font-size: 16px; line-height: 30px;"
                                    align="left">
                                    {{ $company->name }}<br>
                                    {{ $company->address }}<br>
                                    Tel: {{ $company->phone }} <br>
                                    Email: <a href="mailTo:{{ $company->email }}">{{ $company->email }}</a> <br>
                                    Website: <a href="{{ $company->website }}"
                                                target="_blank">{{ $company->website }}</a>
                                    <br>
                                </td>
                            </tr>
                        </table>
                        <!-- /// Title -->
                        <br>
                        <table style="color: dodgerblue;" class="container hero-subheader" border="0" cellpadding="0"
                               cellspacing="0" width="640" style="width: 640px;">
                            <tr>
                                <td class="hero-subheader__content" style="font-size: 14px; line-height: 30px;"
                                    align="left">
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
