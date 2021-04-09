@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif

<!-- Bank Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bank_id', 'Bank:') !!}
    {!! Form::select('bank_id', $banks, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Account Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_name', 'Account Name:') !!}
    {!! Form::text('account_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Account Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_number', 'Account Number:') !!}
    {!! Form::text('account_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Account Head Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_code', 'Account Code:') !!}
    {!! Form::text('account_code', !isset($orgBankAccount)?null:$orgBankAccount->account_head->code, ['class' => 'form-control']) !!}
</div>
