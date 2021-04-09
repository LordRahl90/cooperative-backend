<div id="mainBody">
    <table width="100%">
        <tr>
            <td colspan="2">
                <table width="100%">
                    <tr>
                        <td width="30%" style="padding:5px;">
                            <p align="justify" class="address">
                                {{ $details->company->address }}<br/>
                                {{ $details->company->phone }},<br>
                                {{ $details->company->email }}<br/>
                                <span class="web">{{ $details->company->website }}</span>
                            </p>
                        </td>
                        <td valign="top" align="center">
                            <h2 align="center">{{ $details->company->name }}</h2>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" width="100%">
                <h3>Receipt</h3>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding-left:60px;">
                <table id="recdetails">
                    <tr>
                        <td>Recieved From:</td>
                        <td><span id="payer">{{ $details->receipt->payer }}</span></td>
                    </tr>

                    <tr>
                        <td>Phone:</td>
                        <td>{{ $details->receipt->phone }}</td>
                    </tr>

                    <tr>
                        <td>Amount:</td>
                        <td><span
                                style="text-decoration:line-through">N</span> {{ number_format($details->receipt->amount,2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>Amount in Words:</td>
                        <td>{{ ucfirst(\App\Utility\NumberConversion::convert_number_to_words($details->receipt->amount)) }}
                            naira
                        </td>
                    </tr>

                    <tr>
                        <td>Being Payment For:</td>
                        <td>{{ $details->account_head->name }}</td>
                    </tr>

                    <tr>
                        <td>Reciept No:</td>
                        <td>{{ $details->receipt->id }}</td>
                    </tr>

                    <tr>
                        <td>Slip No.</td>
                        <td> {{ $details->receipt->reference }}</td>
                    </tr>

                    <tr>
                        <td>Email:</td>
                        <td>{{ $details->receipt->email }}</td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td style="padding-top:30px;">

                ---------------------------------------------------<br/>
                Account Officer<br>
                (Signature & Date);
            </td>
        </tr>

    </table>
</div>
-----------------------------------------------------------------------------------------------------------------------------------------
