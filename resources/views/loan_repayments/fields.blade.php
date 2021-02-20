<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company:') !!}
    {!! Form::select('company_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Loan Application Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_application_id', 'Loan Application:') !!}
    {!! Form::select('loan_application_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer:') !!}
    {!! Form::select('customer_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Loan Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_id', 'Loan:') !!}
    {!! Form::select('loan_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>
