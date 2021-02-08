<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $accountCategory->name }}</p>
</div>

<!-- Prefix Digit Field -->
<div class="col-sm-12">
    {!! Form::label('prefix_digit', 'Prefix Digit:') !!}
    <p>{{ $accountCategory->prefix_digit }}</p>
</div>

<!-- Account Type Field -->
<div class="col-sm-12">
    {!! Form::label('account_type', 'Account Type:') !!}
    <p>{{ $accountCategory->account_type }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $accountCategory->slug }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $accountCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $accountCategory->updated_at }}</p>
</div>

