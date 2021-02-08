<!-- Payee Field -->
<div class="col-sm-12">
    {!! Form::label('payee', 'Payee:') !!}
    <p>{{ $paymentVoucher->payee }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $paymentVoucher->address }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $paymentVoucher->email }}</p>
</div>

<!-- Website Field -->
<div class="col-sm-12">
    {!! Form::label('website', 'Website:') !!}
    <p>{{ $paymentVoucher->website }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', 'Phone:') !!}
    <p>{{ $paymentVoucher->phone }}</p>
</div>

<!-- Pv Id Field -->
<div class="col-sm-12">
    {!! Form::label('pv_id', 'Pv Id:') !!}
    <p>{{ $paymentVoucher->pv_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $paymentVoucher->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $paymentVoucher->updated_at }}</p>
</div>

