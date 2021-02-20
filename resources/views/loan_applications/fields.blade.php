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
    {!! Form::text('principal', null, ['class' => 'form-control']) !!}
</div>

<!-- Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rate', 'Rate:') !!}
    {!! Form::text('rate', null, ['class' => 'form-control']) !!}
</div>

<!-- Interest Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interest_type', 'Interest Type:') !!}
    {!! Form::select('interest_type', ['FLAT_RATE' => 'FLAT RATE', 'REDUCING_BALANCE' => 'REDUCING BALANCE'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Tenor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tenor', 'Tenor:') !!}
    {!! Form::number('tenor', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', ['APPROVED' => 'APPROVED', 'DISAPPROVED' => 'DISAPPROVED', 'PENDING' => 'PENDING'], null, ['class' => 'form-control custom-select']) !!}
</div>


<input type="hidden" name="staff_id" value="{{ auth()->id() }}"/>
