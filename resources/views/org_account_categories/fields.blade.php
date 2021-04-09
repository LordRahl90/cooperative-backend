@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Account Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_type', 'Account Type:') !!}
    {!! Form::select('account_type', [''=>'Select','DEBIT'=>'DEBIT','CREDIT'=>'CREDIT'], !isset($orgAccountCategory) || $orgAccountCategory==null?null:$orgAccountCategory->account_type, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Prefix Digit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('prefix_digit', 'Prefix Digit:') !!}
    {!! Form::number('prefix_digit', null, ['class' => 'form-control']) !!}
</div>
