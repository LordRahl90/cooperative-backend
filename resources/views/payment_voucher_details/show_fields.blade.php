<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $paymentVoucherDetails->company_id }}</p>
</div>

<!-- Pv Id Field -->
<div class="col-sm-12">
    {!! Form::label('pv_id', 'Pv Id:') !!}
    <p>{{ $paymentVoucherDetails->pv_id }}</p>
</div>

<!-- Account Head Id Field -->
<div class="col-sm-12">
    {!! Form::label('account_head_id', 'Account Head Id:') !!}
    <p>{{ $paymentVoucherDetails->account_head_id }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $paymentVoucherDetails->amount }}</p>
</div>

<!-- Narration Field -->
<div class="col-sm-12">
    {!! Form::label('narration', 'Narration:') !!}
    <p>{{ $paymentVoucherDetails->narration }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $paymentVoucherDetails->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $paymentVoucherDetails->updated_at }}</p>
</div>

