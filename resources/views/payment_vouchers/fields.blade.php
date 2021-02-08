<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company:') !!}
    {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Payee Field -->
<div class="form-group col-sm-6">
    {!! Form::label('payee', 'Payee:') !!}
    {!! Form::text('payee', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Website Field -->
<div class="form-group col-sm-6">
    {!! Form::label('website', 'Website:') !!}
    {!! Form::text('website', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Pv Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pv_id', 'Pv Id:') !!}
    {!! Form::text('pv_id', strtoupper(uniqid('PV-')), ['class' => 'form-control']) !!}
</div>

<div class="row" style="width:100%; border: 1px solid #000;">
    <!-- Account Head Id Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('account_head_id', 'Account Head Id:') !!}
        {!! Form::select('account_head_id', [], null, ['class' => 'form-control custom-select']) !!}
    </div>

    <!-- Narration Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('narration', 'Narration:') !!}
        {!! Form::text('narration', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Rate Field -->
    <div class="form-group col-sm-1">
        {!! Form::label('rate', 'Rate:') !!}
        {!! Form::text('rate', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-sm-1">
        {!! Form::label('quantity', 'Quantity:') !!}
        {!! Form::text('quantity', null, ['class' => 'form-control custom-select']) !!}
    </div>

    <!-- Amount Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('amount', 'Amount:') !!}
        {!! Form::text('amount', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">

    </div>
</div>
