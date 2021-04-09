<!-- Payee Field -->
<div class="col-sm-3">
    {!! Form::label('payee', 'Payee:') !!}
    <p>{{ $paymentVoucher->payee }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-3">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $paymentVoucher->address }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-3">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $paymentVoucher->email }}</p>
</div>

<!-- Website Field -->
<div class="col-sm-3">
    {!! Form::label('website', 'Website:') !!}
    <p>{{ $paymentVoucher->website }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-3">
    {!! Form::label('phone', 'Phone:') !!}
    <p>{{ $paymentVoucher->phone }}</p>
</div>

<!-- Pv Id Field -->
<div class="col-sm-3">
    {!! Form::label('pv_id', 'Pv Id:') !!}
    <p>{{ $paymentVoucher->pv_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-3">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $paymentVoucher->created_at }}</p>
</div>
<div class="col-md-12">
    <table width="100%" class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th>SN</th>
            <th>Code</th>
            <th width="40%">Narration</th>
            <th>Rate</th>
            <th>Quantity</th>
            <th width="20%">Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($paymentVoucher->items as $k=>$item)
            <tr>
                <td>{{ $k+1 }}</td>
                <td>{{ $item->accountHead->code }}</td>
                <td>{{ $item->narration }}</td>
                <td>{{ number_format($item->rate,2) }}</td>
                <td>{{ number_format($item->quantity,2) }}</td>
                <td>{{ number_format($item->amount,2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
