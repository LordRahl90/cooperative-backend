<!-- Company Id Field -->
<div class="col-sm-6">
    {!! Form::label('company_id', 'Company:') !!}
    <p>{{ $loanRepayment->company->name }}</p>
</div>

<!-- Loan Application Id Field -->
<div class="col-sm-6">
    {!! Form::label('loan_application_id', 'Loan Application Id:') !!}
    <p>{{ $loanRepayment->loan_application->pv->pv_id }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-6">
    {!! Form::label('customer_id', 'Customer:') !!}
    <p>{{ $loanRepayment->customer->full_name }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-6">
    {!! Form::label('amount', 'Principal:') !!}
    <p>{{ number_format($loanRepayment->principal,2) }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-6">
    {!! Form::label('amount', 'Interest:') !!}
    <p>{{ number_format($loanRepayment->interest,2) }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $loanRepayment->created_at }}</p>
</div>
