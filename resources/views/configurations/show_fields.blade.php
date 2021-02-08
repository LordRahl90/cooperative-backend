<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $configuration->company_id }}</p>
</div>

<!-- Income Category Field -->
<div class="col-sm-12">
    {!! Form::label('income_category', 'Income Category:') !!}
    <p>{{ $configuration->income_category }}</p>
</div>

<!-- Expense Category Field -->
<div class="col-sm-12">
    {!! Form::label('expense_category', 'Expense Category:') !!}
    <p>{{ $configuration->expense_category }}</p>
</div>

<!-- Cash Account Categories Field -->
<div class="col-sm-12">
    {!! Form::label('cash_account_categories', 'Cash Account Categories:') !!}
    <p>{{ $configuration->cash_account_categories }}</p>
</div>

<!-- Fixed Asset Categories Field -->
<div class="col-sm-12">
    {!! Form::label('fixed_asset_categories', 'Fixed Asset Categories:') !!}
    <p>{{ $configuration->fixed_asset_categories }}</p>
</div>

<!-- Current Assets Category Field -->
<div class="col-sm-12">
    {!! Form::label('current_assets_category', 'Current Assets Category:') !!}
    <p>{{ $configuration->current_assets_category }}</p>
</div>

<!-- Account Payable Category Field -->
<div class="col-sm-12">
    {!! Form::label('account_payable_category', 'Account Payable Category:') !!}
    <p>{{ $configuration->account_payable_category }}</p>
</div>

<!-- Account Recieveable Category Field -->
<div class="col-sm-12">
    {!! Form::label('account_recieveable_category', 'Account Recieveable Category:') !!}
    <p>{{ $configuration->account_recieveable_category }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $configuration->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $configuration->updated_at }}</p>
</div>

