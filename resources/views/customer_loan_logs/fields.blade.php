<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::select('company_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Customer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer', 'Customer:') !!}
    {!! Form::select('customer', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Loan Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_id', 'Loan Id:') !!}
    {!! Form::select('loan_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Debit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('debit', 'Debit:') !!}
    {!! Form::text('debit', null, ['class' => 'form-control']) !!}
</div>

<!-- Credit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('credit', 'Credit:') !!}
    {!! Form::text('credit', null, ['class' => 'form-control']) !!}
</div>
