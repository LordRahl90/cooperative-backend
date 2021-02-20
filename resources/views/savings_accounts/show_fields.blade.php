<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $savingsAccount->company_id }}</p>
</div>

<!-- Savings Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('savings_category_id', 'Savings Category Id:') !!}
    <p>{{ $savingsAccount->savings_category_id }}</p>
</div>

<!-- Account Head Id Field -->
<div class="col-sm-12">
    {!! Form::label('account_head_id', 'Account Head Id:') !!}
    <p>{{ $savingsAccount->account_head_id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $savingsAccount->name }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $savingsAccount->slug }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $savingsAccount->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $savingsAccount->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $savingsAccount->updated_at }}</p>
</div>

