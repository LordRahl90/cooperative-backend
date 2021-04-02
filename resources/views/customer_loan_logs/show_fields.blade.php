<!-- Company Id Field -->
<div class="col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $customerLoanLog->company->name }}</p>
</div>

<!-- Customer Field -->
<div class="col-sm-6">
    {!! Form::label('customer', 'Customer:') !!}
    <p>{{ $customerLoanLog->customer->full_name }}</p>
</div>

<!-- Loan Id Field -->
<div class="col-sm-6">
    {!! Form::label('loan_id', 'Loan Id:') !!}
    <p>{{ $customerLoanLog->loan->loan_application->pv->pv_id }}</p>
</div>

<!-- Debit Field -->
<div class="col-sm-6">
    {!! Form::label('debit', 'Debit:') !!}
    <p>{{ $customerLoanLog->debit }}</p>
</div>

<!-- Credit Field -->
<div class="col-sm-6">
    {!! Form::label('credit', 'Credit:') !!}
    <p>{{ $customerLoanLog->credit }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerLoanLog->created_at }}</p>
</div>

<!-- Updated At Field -->
{{--<div class="col-sm-6">--}}
{{--    {!! Form::label('updated_at', 'Updated At:') !!}--}}
{{--    <p>{{ $customerLoanLog->updated_at }}</p>--}}
{{--</div>--}}

