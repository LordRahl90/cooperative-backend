@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif


<!-- Loan Application Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_application_id', 'Loan Application:') !!}
    {!! Form::select('loan_application_id', $applications, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Approved By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('approved_by', 'Approved By:') !!}
    {!! Form::select('approved_by', $staff, null, ['class' => 'form-control custom-select']) !!}
</div>
<input type="hidden" name="status" value="RUNNING"/>


<!-- Debit Account Field -->
<div class="form-group col-sm-6">
    {!! Form::label('debit_account', 'Select Bank Account:') !!}
    {!! Form::select('debit_account', $bankAccounts, null, ['class' => 'form-control custom-select','payments.debit_account']) !!}
</div>

<!-- Narration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reference', 'Reference:') !!}
    {!! Form::text('reference', null, ['class' => 'form-control']) !!}
</div>

<!-- Narration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('narration', 'Narration:') !!}
    {!! Form::text('narration', null, ['class' => 'form-control']) !!}
</div>
