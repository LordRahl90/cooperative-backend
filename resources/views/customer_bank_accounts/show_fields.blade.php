<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $customerBankAccount->company_id }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-12">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{{ $customerBankAccount->customer_id }}</p>
</div>

<!-- Bank Id Field -->
<div class="col-sm-12">
    {!! Form::label('bank_id', 'Bank Id:') !!}
    <p>{{ $customerBankAccount->bank_id }}</p>
</div>

<!-- Account Name Field -->
<div class="col-sm-12">
    {!! Form::label('account_name', 'Account Name:') !!}
    <p>{{ $customerBankAccount->account_name }}</p>
</div>

<!-- Account Number Field -->
<div class="col-sm-12">
    {!! Form::label('account_number', 'Account Number:') !!}
    <p>{{ $customerBankAccount->account_number }}</p>
</div>

<!-- Sort Code Field -->
<div class="col-sm-12">
    {!! Form::label('sort_code', 'Sort Code:') !!}
    <p>{{ $customerBankAccount->sort_code }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerBankAccount->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customerBankAccount->updated_at }}</p>
</div>

