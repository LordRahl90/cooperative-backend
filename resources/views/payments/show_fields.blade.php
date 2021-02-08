<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $payment->company_id }}</p>
</div>

<!-- Pv Id Field -->
<div class="col-sm-12">
    {!! Form::label('pv_id', 'Pv Id:') !!}
    <p>{{ $payment->pv_id }}</p>
</div>

<!-- Reference Field -->
<div class="col-sm-12">
    {!! Form::label('reference', 'Reference:') !!}
    <p>{{ $payment->reference }}</p>
</div>

<!-- Confirmed By Field -->
<div class="col-sm-12">
    {!! Form::label('confirmed_by', 'Confirmed By:') !!}
    <p>{{ $payment->confirmed_by }}</p>
</div>

<!-- Authorized By Field -->
<div class="col-sm-12">
    {!! Form::label('authorized_by', 'Authorized By:') !!}
    <p>{{ $payment->authorized_by }}</p>
</div>

<!-- Total Amount Field -->
<div class="col-sm-12">
    {!! Form::label('total_amount', 'Total Amount:') !!}
    <p>{{ $payment->total_amount }}</p>
</div>

<!-- Debit Account Field -->
<div class="col-sm-12">
    {!! Form::label('debit_account', 'Debit Account:') !!}
    <p>{{ $payment->debit_account }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $payment->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $payment->updated_at }}</p>
</div>

