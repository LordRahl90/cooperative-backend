<!-- Bank Id Field -->
<div class="col-sm-12">
    {!! Form::label('bank_id', 'Bank Id:') !!}
    <p>{{ $orgBankAccount->bank_id }}</p>
</div>

<!-- Account Name Field -->
<div class="col-sm-12">
    {!! Form::label('account_name', 'Account Name:') !!}
    <p>{{ $orgBankAccount->account_name }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $orgBankAccount->slug }}</p>
</div>

<!-- Account Number Field -->
<div class="col-sm-12">
    {!! Form::label('account_number', 'Account Number:') !!}
    <p>{{ $orgBankAccount->account_number }}</p>
</div>

<!-- Account Head Id Field -->
<div class="col-sm-12">
    {!! Form::label('account_head_id', 'Account Head Id:') !!}
    <p>{{ $orgBankAccount->account_head_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $orgBankAccount->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $orgBankAccount->updated_at }}</p>
</div>

