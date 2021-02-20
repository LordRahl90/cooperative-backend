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
    {!! Form::label('customer_id', 'Customer Id:') !!}
    {!! Form::select('customer_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Savings Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('savings_id', 'Savings Id:') !!}
    {!! Form::select('savings_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Loan Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_id', 'Loan Id:') !!}
    {!! Form::select('loan_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Narration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('narration', 'Narration:') !!}
    {!! Form::text('narration', null, ['class' => 'form-control']) !!}
</div>
