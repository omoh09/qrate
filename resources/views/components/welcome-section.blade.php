<tr>
    <td
        align="left"
        style="
                              background-position: left top;
                              background-color: #ffffff;
                            "
    >

<table
    cellpadding="0"
    cellspacing="0"
    width="100%"
    style="font-size: 14px"
>
    <tbody>
    <tr>
        <td width="480" align="center" valign="top">
            <table
                cellpadding="0"
                cellspacing="0"
                width="500px"
            >
                <tbody>
                <br />
                <tr>
                    <td align="center">
                        <h2
                            align="center"
                            margin="auto"
                            style="
                                                color: #f7931e;
                                                font-size: 30px;
                                              "
                        >{{$heading}}</h2>
                        <p class="hero-text">
                            {{$slot}}
                            @if($url)
                            <a
                                href="{{$url}}"
                                style="
                                                  text-decoration: underline;
                                                  font-weight: 500;
                                                  color: #059ae5;
                                                "
                            >
                                <span>here</span></a
                            >
                            @endif
                        </p>
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
