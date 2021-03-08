@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif


<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer:') !!}
    {!! Form::select('customer_id', $customers, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Loan Account Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_account_id', 'Loan Account:') !!}
    {!! Form::select('loan_account_id', $loanAccount, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Principal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('principal', 'Principal:') !!}
    {!! Form::text('principal', null, ['class' => 'form-control','v-model'=>'principal','@change'=>'calculateRepaymentPlan']) !!}
</div>

<!-- Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rate', 'Rate:') !!}
    {!! Form::text('rate', null, ['class' => 'form-control', 'v-model'=>'rate','@change'=>'calculateRepaymentPlan']) !!}
</div>

<!-- Interest Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interest_type', 'Interest Type:') !!}
    {!! Form::select('interest_type', [''=>'Select Interest Type','FLAT_RATE' => 'FLAT RATE', 'REDUCING_BALANCE' => 'REDUCING BALANCE'], null,
     ['class' => 'form-control custom-select','v-model'=>'interest_type','@change'=>'calculateRepaymentPlan']) !!}
</div>


<!-- Tenor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tenor', 'Tenor (Months):') !!}
    {!! Form::number('tenor', null, ['class' => 'form-control','v-model'=>'tenor','@change'=>'calculateRepaymentPlan',':readonly="reducingBalance"']) !!}
</div>

<!-- Principal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('repayment_amount', 'Monthly Repayment Amount:') !!}
    {!! Form::text('repayment_amount', null, ['class' => 'form-control','v-model'=>'repayment_amount',':readonly="flatRate" @change="calculateTenor"']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <input type="hidden" name="status" value="PENDING"/>
</div>


<input type="hidden" name="staff_id" value="{{ auth()->id() }}"/>
