<?php
$totalDebit = 0;
$totalCredit = 0;
?>
<table width="100%">
    <tr>
        <td style="text-align: center">
            <h3>{{ strtoupper($company->name) }}</h3>
            <p>{{ $company->address }}</p>
            <p>{{ $company->phone }}, {{ $company->email }}, {{ $company->website }}</p>
        </td>
    </tr>
    <tr>
        <td style="text-align: center">
            <h3>Trial Balance Between {{ Date('Y-m-d',strtotime($start_date)) }} and {{ Date('Y-m-d',strtotime($end_date)) }}</h3>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td style="font-weight: bold;">SN</td>
                    <td style="font-weight: bold;">Code</td>
                    <td style="font-weight: bold;">Account Name</td>
                    <td style="font-weight: bold; text-align: right">Debit</td>
                    <td style="font-weight: bold; text-align: right">Credit</td>
                </tr>

                @foreach($results as $k=>$v)
                    @php
                        $accountHead=\App\Models\OrgAccountHead::with('category')->find($v->account_head_id);
                        $category=$accountHead->category;
                        $debit=0;
                        $credit=0;
                        if($category->account_type==='DEBIT'){
                            $debit=$v->debit-$v->credit;
                            $credit=0;
                        }else{
                            $credit=$v->credit-$v->debit;
                            $debit=0;
                        }

                        if($debit<0){
                            $credit=abs($debit);
                            $debit=0;
                        }
                        if ($credit<0){
                            $debit=abs($credit);
                            $credit=0;
                        }
                        $totalDebit+=$debit;
                        $totalCredit+=$credit;
                    @endphp
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $accountHead->code }}</td>
                        <td>{{ $accountHead->name }}</td>
                        <td style="text-align: right">{{ number_format($debit,2) }}</td>
                        <td style="text-align: right">{{ number_format($credit,2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">Total</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($totalDebit,2) }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($totalCredit,2) }}</td>
                </tr>
            </table>
        </td>
    </tr>

</table>
