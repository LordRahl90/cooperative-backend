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
    <select name="loan_id" v-model="loan_id" class="form-control" @change="loadLoanRepaymentAmount">
        <option value="0" selected disabled>Select Loan</option>
        <option v-for="loan in loans" :value="loan.id">@{{ loan.loan_application.pv.pv_id }}</option>
    </select>
</div>

<!-- Debit Account Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bank_account', 'Select Bank Account:') !!}
    {!! Form::select('bank_account', $bankAccounts, null, ['class' => 'form-control custom-select','payments.debit_account']) !!}
</div>

<!-- Narration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reference', 'Reference:') !!}
    {!! Form::text('reference', strtoupper(uniqid('SV-')), ['class' => 'form-control']) !!}
</div>

<!-- Narration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('narration', 'Narration:') !!}
    {!! Form::text('narration', null, ['class' => 'form-control']) !!}
</div>


<!-- Amount Payable Field -->
<div class="form-group col-sm-6" v-if="amountPayable>0">
    {!! Form::label('amount_payable', 'Monthly Payable Amount:') !!}
    {!! Form::text('amount_payable', null, ['class' => 'form-control','v-model'=>'amountPayable','readonly']) !!}
</div>


{{--<input type="hidden" name="amount" v-model="amount" />--}}
<!-- Interest Field -->
<div class="form-group col-sm-6">
    {!! Form::label('principal', 'Principal:') !!}
{{--    <input type="text" name="principal" class="form-control" v-model="principal" @change="updateAmount" />--}}
    {!! Form::text('principal', null, ['class' => 'form-control','v-model'=>'principal','@change="updateAmount"']) !!}
</div>


<!-- Interest Field -->
<div class="form-group col-sm-6" v-if="interest>0">
    {!! Form::label('interest', 'Interest:') !!}
    {!! Form::text('interest', null, ['class' => 'form-control','v-model'=>'interest','readonly']) !!}
</div>

<!-- Principal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Total Payable:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control','v-model'=>'amount','readonly']) !!}
</div>
