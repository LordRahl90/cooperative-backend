<?php
$totalDebit = 0;
$totalCredit = 0;
?>
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
                <h3>Journal Voucher Summary</h3>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td>
                            <h3>Debit</h3>
                            <table width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">SN</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th align="right">Debit</th>
                                    <th align="right">Credit</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($details->transactions)>0)
                                    @foreach($details->transactions as $k=>$v)
                                        @php
                                            $totalDebit += $v->debit_amount;
                                            $totalCredit += $v->credit_amount;
                                        @endphp
                                        <tr>
                                            <td>{{ $k+1 }}</td>
                                            <td align="center">{{ $v->account_head->code }}</td>
                                            <td>{{ $v->account_head->name }}</td>
                                            <td align="right">{{ number_format($v->debit_amount,2) }}</td>
                                            <td align="right">{{ number_format($v->credit_amount,2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td style="font-weight: bold" colspan="3">Total</td>
                                        <td style="font-weight: bold"
                                            align="right">{{ number_format($totalDebit,2) }}</td>
                                        <td style="font-weight: bold"
                                            align="right">{{ number_format($totalCredit,2) }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
