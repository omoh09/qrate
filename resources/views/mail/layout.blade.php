<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <title>Qrate</title>
    <style>
        @font-face {
            font-family: "graphik";
            src: url("../fonts/GraphikRegular.otf");
            font-style: normal;
        }
        .hero-text {
            font-size: 16px;
            font-weight: normal;
            line-height: 1.4;
            color: #514c4c
        }
        .hero-subtext {
            font-size: 14px;
        }
        .hero-container {
            height: 225px;
        }
        @media only screen and (max-width: 678px) {
            .hero-text {
                font-size: 16px;
            }
            .hero-subtext {
                font-size: 16px;
                line-height: 1.5;
            }
            .hero-container {
                height: 250px;
            }
            .social-media {
                width: 6%;
            }
        }
    </style>
</head>
​
<body>
<table
    cellspacing="0"
    cellpadding="50"
    bgcolor="fffbf7"
    align="center"
    width="100%"
    style="
        background-color: #fffbf7;
        font-family: graphik, Arial, Helvetica, sans-serif;
      "
>
    <tbody>
    <tr>
        <td valign="top">
            <table border="0" cellpadding="0" cellspacing="0" align="center">
                <tbody>
                <tr>
                    <td bgcolor="ffffff" style="background-color: #ffffff">
                        <table
                            bgcolor="rgba(0, 0, 0, 0)"
                            align="center"
                            valign="center"
                            cellpadding="0"
                            cellspacing="0"
                            width="800"
                            style="
                        background-color: transparent;
                        border: 1px solid #f0f2f5;
                        border-top: 3px solid transparent;
                        border-radius: 5px;
                        font-family: graphik, Arial, Helvetica, sans-serif;
                        max-width: 800px;
                      "
                        >
                            <tbody>
                            @yield('content')
                            </tbody>
                        </table>
                    </td>
                </tr>

                <!-- copyright Section -->
                <tr>
                    <td bgcolor="transparent" style="background-color: transparent">
                        <table
                            bgcolor="rgba(0, 0, 0, 0)"
                            align="center"
                            valign="center"
                            cellpadding="0"
                            cellspacing="0"
                            width="600"
                            style="
                        background-color: transparent;
                        border: 1px solid transparent;
                        border-top: none;
                        border-radius: 5px;
                        font-family: graphik, Arial, Helvetica, sans-serif;
                      "
                        >
                            <tbody>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #dedada">&nbsp;</td>
                            </tr>
                            <tr>
                                <td
                                    align="center"
                                    style="
                              background-position: left top;
                              background-color: transparent;
                            "
                                >
                                    <table
                                        cellpadding="20"
                                        cellspacing="0"
                                        width="100%"
                                    >
                                        <tbody>
                                        <tr>
                                            <td width="480" align="center" valign="top">
                                                <table
                                                    cellpadding="0"
                                                    cellspacing="0"
                                                    width="480"
                                                    style="font-size: 14px"
                                                >
                                                    <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <p class="hero-subtext"
                                                               style="color: #796e6e;"
                                                            >
                                                                Copyright 2020 &copy; Qrate, All Rights reserved.
                                                            </p>
                                                            <p class="hero-subtext"
                                                               style="color: #4f4e4d;
                                                    font-weight: bold;
                                              "
                                                            >
                                                                {{--Our mailing address is:--}}
                                                            </p>
                                                            <p class="hero-text"
                                                               style="color: #877d7d;"
                                                            >
                                                                    {{-- Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloremque sit illo accusamus. --}}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">
                                                            <a href="#" target="_blank"
                                                               style="color: #4f4e4d; font-size: larger;"
                                                            ><i class="fab fa-twitter"></i>
                                                            </a
                                                            {{-- >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}
                                                            <a href="#" target="_blank" style="color: #4f4e4d; font-size: larger;"
                                                            ><i class="fab fa-facebook-f"></i></a
                                                            {{-- >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a --}}
                                                                href="#"
                                                                target="_blank"
                                                                style="color: #4f4e4d; font-size: larger;"
                                                            ><i class="fab fa-linkedin-in"></i></a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
