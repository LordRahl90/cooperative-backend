<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $customerTransaction->company_id }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-12">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{{ $customerTransaction->customer_id }}</p>
</div>

<!-- Savings Id Field -->
<div class="col-sm-12">
    {!! Form::label('savings_id', 'Savings Id:') !!}
    <p>{{ $customerTransaction->savings_id }}</p>
</div>

<!-- Loan Id Field -->
<div class="col-sm-12">
    {!! Form::label('loan_id', 'Loan Id:') !!}
    <p>{{ $customerTransaction->loan_id }}</p>
</div>

<!-- Narration Field -->
<div class="col-sm-12">
    {!! Form::label('narration', 'Narration:') !!}
    <p>{{ $customerTransaction->narration }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerTransaction->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customerTransaction->updated_at }}</p>
</div>

