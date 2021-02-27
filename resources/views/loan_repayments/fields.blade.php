@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select','v-model'=>'company_id']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif

<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer:') !!}
    {!! Form::select('customer_id', $customers, null, ['class' => 'form-control custom-select','v-model'=>'customer_id','@change="loadCustomerLoans"']) !!}
</div>


<!-- Loan Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_id', 'Loan:') !!}
    {{--    {!! Form::select('loan_id', [], null, ['class' => 'form-control custom-select','v-mode'=>'loan_id']) !!}--}}
    <select name="loan_id" v-model="loan_id" class="form-control">
        <option value="0" selected disabled>Select Loan</option>
        <option v-for="loan in loans" :value="loan.id">@{{ loan.loan_application.pv.pv_id }}</option>
    </select>
</div>


<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control','v-model'=>'amount']) !!}
</div>
