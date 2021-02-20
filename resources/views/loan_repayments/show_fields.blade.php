<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $loanRepayment->company_id }}</p>
</div>

<!-- Loan Application Id Field -->
<div class="col-sm-12">
    {!! Form::label('loan_application_id', 'Loan Application Id:') !!}
    <p>{{ $loanRepayment->loan_application_id }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-12">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{{ $loanRepayment->customer_id }}</p>
</div>

<!-- Count Field -->
<div class="col-sm-12">
    {!! Form::label('count', 'Count:') !!}
    <p>{{ $loanRepayment->count }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $loanRepayment->amount }}</p>
</div>

<!-- Loan Id Field -->
<div class="col-sm-12">
    {!! Form::label('loan_id', 'Loan Id:') !!}
    <p>{{ $loanRepayment->loan_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $loanRepayment->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $loanRepayment->updated_at }}</p>
</div>

