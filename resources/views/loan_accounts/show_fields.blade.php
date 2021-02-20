<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $loanAccount->company_id }}</p>
</div>

<!-- Loan Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('loan_category_id', 'Loan Category Id:') !!}
    <p>{{ $loanAccount->loan_category_id }}</p>
</div>

<!-- Account Head Id Field -->
<div class="col-sm-12">
    {!! Form::label('account_head_id', 'Account Head Id:') !!}
    <p>{{ $loanAccount->account_head_id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $loanAccount->name }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $loanAccount->slug }}</p>
</div>

<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', 'Code:') !!}
    <p>{{ $loanAccount->code }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $loanAccount->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $loanAccount->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $loanAccount->updated_at }}</p>
</div>

