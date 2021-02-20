<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $customerLoan->company_id }}</p>
</div>

<!-- Loan Application Id Field -->
<div class="col-sm-12">
    {!! Form::label('loan_application_id', 'Loan Application Id:') !!}
    <p>{{ $customerLoan->loan_application_id }}</p>
</div>

<!-- Approved By Field -->
<div class="col-sm-12">
    {!! Form::label('approved_by', 'Approved By:') !!}
    <p>{{ $customerLoan->approved_by }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $customerLoan->status }}</p>
</div>

<!-- Total Repaid Field -->
<div class="col-sm-12">
    {!! Form::label('total_repaid', 'Total Repaid:') !!}
    <p>{{ $customerLoan->total_repaid }}</p>
</div>

<!-- Narration Field -->
<div class="col-sm-12">
    {!! Form::label('narration', 'Narration:') !!}
    <p>{{ $customerLoan->narration }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerLoan->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customerLoan->updated_at }}</p>
</div>

