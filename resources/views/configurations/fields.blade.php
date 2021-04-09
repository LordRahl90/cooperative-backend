@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif

<!-- Income Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('income_category', 'Income Category:') !!}
    {!! Form::select('income_category', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Expense Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('expense_category', 'Expense Category:') !!}
    {!! Form::select('expense_category', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Cash Account Categories Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cash_account_category', 'Cash Account Categories:') !!}
    {!! Form::select('cash_account_category', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Fixed Asset Categories Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fixed_asset_category', 'Fixed Asset Categories:') !!}
    {!! Form::select('fixed_asset_category', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Current Assets Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('current_assets_category', 'Current Assets Category:') !!}
    {!! Form::select('current_assets_category', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Account Payable Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_payable_category', 'Account Payable Category:') !!}
    {!! Form::select('account_payable_category', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Account Recieveable Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_receivable_category', 'Account Receivable Category:') !!}
    {!! Form::select('account_receivable_category', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Account Recieveable Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bank_category', 'Bank Category:') !!}
    {!! Form::select('bank_category', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Account Recieveable Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('current_liability_category', 'Current Liability Category:') !!}
    {!! Form::select('current_liability_category', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>
