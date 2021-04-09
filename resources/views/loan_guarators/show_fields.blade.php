<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $loanGuarator->company_id }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-12">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{{ $loanGuarator->customer_id }}</p>
</div>

<!-- Loan Id Field -->
<div class="col-sm-12">
    {!! Form::label('loan_id', 'Loan Id:') !!}
    <p>{{ $loanGuarator->loan_id }}</p>
</div>

<!-- Guarantor Field -->
<div class="col-sm-12">
    {!! Form::label('guarantor', 'Guarantor:') !!}
    <p>{{ $loanGuarator->guarantor }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $loanGuarator->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $loanGuarator->updated_at }}</p>
</div>

