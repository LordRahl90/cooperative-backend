<style>
    td {
        text-align: center;
        align-content: center;
    }
</style>
<h1>Upload completed</h1>

@if(count($success)>0)
    <h2>Successful Uploads</h2>
    <table width="100%">
        <thead>
        <tr>
            <th align="left">Customer ID</th>
            <th align="left">Customer</th>
            <th align="left">Payable</th>
            <th align="left">Paid</th>
            <th align="left">Message</th>
        </tr>
        </thead>
        <tbody>
        @foreach($success as $s)
            <tr>
                <td>{{ $s['customer_id'] }}</td>
                <td>{{ $s['customer'] }}</td>
                <td>{{ number_format($s['payable'],2) }}</td>
                <td>{{ number_format($s['paid'],2) }}</td>
                <td>{{ $s['message'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

@if(count($incomplete)>0)
    <h2>Incomplete Amount</h2>
    <table width="100%">
        <thead>
        <tr>
            <th align="left">Customer ID</th>
            <th align="left">Customer</th>
            <th align="left">Payable</th>
            <th align="left">Paid</th>
            <th align="left">Message</th>
        </tr>
        </thead>
        <tbody>
        @foreach($incomplete as $icm)
            <tr>
                <td>{{ $icm['customer_id'] }}</td>
                <td>{{ $icm['customer'] }}</td>
                <td>{{ number_format($icm['payable'],2) }}</td>
                <td>{{ number_format($icm['paid'],2) }}</td>
                <td>{{ $icm['message'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

@if(count($duplicates)>0)
    <h2>Possible Duplicates</h2>
    <table width="100%">
        <thead>
        <tr>
            <th align="left">Customer ID</th>
            <th align="left">Customer</th>
            <th align="left">Paid</th>
            <th align="left">Message</th>
        </tr>
        </thead>
        <tbody>
        @foreach($duplicates as $icm)
            <tr>
                <td>{{ $icm['customer_id'] }}</td>
                <td>{{ $icm['customer'] }}</td>
                <td>{{ number_format($icm['paid'],2) }}</td>
                <td>{{ $icm['message'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

@if(count($failures)>0)
    <h2>Failed Upload</h2>

    <table width="100%">
        <thead>
        <tr>
            <th align="left">Customer ID</th>
            <th align="left">Customer</th>
            <th align="left">Reference</th>
            <th align="left">Message</th>
        </tr>
        </thead>
        <tbody>
        @foreach($failures as $f)
            <tr>
                <td>{{ $f['customer_id'] }}</td>
                <td>{{ $f['customer'] }}</td>
                <td>{{ $f['ref'] }}</td>
                <td>{{ $f['message'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

@if(count($invalidStaff)>0)
    <h2>Invalid Customer Reference</h2>
    <table width="100%">
        <thead>
        <tr>
            <th align="left">Customer Ref</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invalidStaff as $isd)
            <tr>
                <td>{{ $isd }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
