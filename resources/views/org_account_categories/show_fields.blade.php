<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $orgAccountCategory->company_id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $orgAccountCategory->name }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $orgAccountCategory->slug }}</p>
</div>

<!-- Account Type Field -->
<div class="col-sm-12">
    {!! Form::label('account_type', 'Account Type:') !!}
    <p>{{ $orgAccountCategory->account_type }}</p>
</div>

<!-- Prefix Digit Field -->
<div class="col-sm-12">
    {!! Form::label('prefix_digit', 'Prefix Digit:') !!}
    <p>{{ $orgAccountCategory->prefix_digit }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $orgAccountCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $orgAccountCategory->updated_at }}</p>
</div>

