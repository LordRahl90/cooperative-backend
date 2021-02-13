<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $receipt->company_id }}</p>
</div>

<!-- Reference Field -->
<div class="col-sm-12">
    {!! Form::label('reference', 'Reference:') !!}
    <p>{{ $receipt->reference }}</p>
</div>

<!-- Payer Field -->
<div class="col-sm-12">
    {!! Form::label('payer', 'Payer:') !!}
    <p>{{ $receipt->payer }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', 'Phone:') !!}
    <p>{{ $receipt->phone }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $receipt->email }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $receipt->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $receipt->updated_at }}</p>
</div>

