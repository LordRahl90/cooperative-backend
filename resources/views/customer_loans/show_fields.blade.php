<!-- Company Id Field -->
<div class="col-sm-4">
    {!! Form::label('company_id', 'Company:') !!}
    <p>{{ $customerLoan->company->name }}</p>
</div>

<!-- Loan Application Id Field -->
<div class="col-sm-4">
    {!! Form::label('loan_application_id', 'Loan Application Ref:') !!}
    <p>{{ $customerLoan->loan_application->pv->pv_id }}</p>
</div>

<!-- Approved By Field -->
<div class="col-sm-4">
    {!! Form::label('approved_by', 'Approved By:') !!}
    <p>{{ $customerLoan->approver==null?"":$customerLoan->approver->name }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-4">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $customerLoan->status }}</p>
</div>

<!-- Total Repaid Field -->
<div class="col-sm-4">
    {!! Form::label('total_repaid', 'Total Repaid:') !!}
    <p>{{ number_format($repayments->sum('principal'),2) }}</p>
</div>

<!-- Narration Field -->
<div class="col-sm-4">
    {!! Form::label('narration', 'Narration:') !!}
    <p>{{ $customerLoan->narration }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-4">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerLoan->created_at->format('Y-m-d') }}</p>
</div>

{{--<!-- Updated At Field -->--}}
{{--<div class="col-sm-4">--}}
{{--    {!! Form::label('updated_at', 'Updated At:') !!}--}}
{{--    <p>{{ $customerLoan->updated_at }}</p>--}}
{{--</div>--}}

