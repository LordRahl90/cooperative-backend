@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif

{{--<!-- Customer Id Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('customer_id', 'Customer Id:') !!}--}}
{{--    {!! Form::select('customer_id', [], null, ['class' => 'form-control custom-select']) !!}--}}
{{--</div>--}}


<!-- Bank Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bank_id', 'Select Bank:') !!}
    {!! Form::select('bank_id', $banks, null, ['class' => 'form-control custom-select','v-model'=>'bank.id']) !!}
</div>


<!-- Account Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_name', 'Account Name:') !!}
    {!! Form::text('account_name', null, ['class' => 'form-control','v-model'=>'bank.account_name']) !!}
</div>

<!-- Account Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_number', 'Account Number:') !!}
    {!! Form::text('account_number', null, ['class' => 'form-control','v-model'=>'bank.account_number']) !!}
</div>

<!-- Sort Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sort_code', 'Sort Code:') !!}
    {!! Form::text('sort_code', null, ['class' => 'form-control','v-model'=>'bank.sort_code']) !!}
</div>
