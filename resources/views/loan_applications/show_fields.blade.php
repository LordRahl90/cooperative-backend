<!-- Company Id Field -->
<div class="col-sm-4">
    {!! Form::label('company_id', 'Company:') !!}
    <p>{{ $loanApplication->company->name }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-4">
    {!! Form::label('customer_id', 'Customer:') !!}
    <p>{{ $loanApplication->customer->full_name }}</p>
</div>

<!-- Loan Account Id Field -->
<div class="col-sm-4">
    {!! Form::label('loan_account_id', 'Loan Account:') !!}
    <p>{{ $loanApplication->loan_account->name }}</p>
</div>

<!-- Principal Field -->
<div class="col-sm-4">
    {!! Form::label('principal', 'Principal:') !!}
    <p>{{ number_format($loanApplication->principal,2) }}</p>
</div>

<!-- Rate Field -->
<div class="col-sm-4">
    {!! Form::label('rate', 'Rate:') !!}
    <p>{{ $loanApplication->rate }}</p>
</div>

<!-- Interest Type Field -->
<div class="col-sm-4">
    {!! Form::label('interest_type', 'Interest Type:') !!}
    <p>{{ str_replace("_"," ",$loanApplication->interest_type) }}</p>
</div>

<!-- Tenor Field -->
<div class="col-sm-4">
    {!! Form::label('tenor', 'Tenor:') !!}
    <p>{{ $loanApplication->tenor }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-4">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $loanApplication->status }}</p>
</div>

<!-- Staff Id Field -->
<div class="col-sm-4">
    {!! Form::label('staff_id', 'Created By:') !!}
    <p>{{ $loanApplication->staff->name }}</p>
</div>
