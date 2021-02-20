<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $loanApplication->company_id }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-12">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{{ $loanApplication->customer_id }}</p>
</div>

<!-- Loan Account Id Field -->
<div class="col-sm-12">
    {!! Form::label('loan_account_id', 'Loan Account Id:') !!}
    <p>{{ $loanApplication->loan_account_id }}</p>
</div>

<!-- Principal Field -->
<div class="col-sm-12">
    {!! Form::label('principal', 'Principal:') !!}
    <p>{{ $loanApplication->principal }}</p>
</div>

<!-- Rate Field -->
<div class="col-sm-12">
    {!! Form::label('rate', 'Rate:') !!}
    <p>{{ $loanApplication->rate }}</p>
</div>

<!-- Interest Type Field -->
<div class="col-sm-12">
    {!! Form::label('interest_type', 'Interest Type:') !!}
    <p>{{ $loanApplication->interest_type }}</p>
</div>

<!-- Tenor Field -->
<div class="col-sm-12">
    {!! Form::label('tenor', 'Tenor:') !!}
    <p>{{ $loanApplication->tenor }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $loanApplication->status }}</p>
</div>

<!-- Staff Id Field -->
<div class="col-sm-12">
    {!! Form::label('staff_id', 'Staff Id:') !!}
    <p>{{ $loanApplication->staff_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $loanApplication->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $loanApplication->updated_at }}</p>
</div>

