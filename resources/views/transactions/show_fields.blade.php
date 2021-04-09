<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $transaction->company_id }}</p>
</div>

<!-- Account Head Id Field -->
<div class="col-sm-12">
    {!! Form::label('account_head_id', 'Account Head Id:') !!}
    <p>{{ $transaction->account_head_id }}</p>
</div>

<!-- Reference Field -->
<div class="col-sm-12">
    {!! Form::label('reference', 'Reference:') !!}
    <p>{{ $transaction->reference }}</p>
</div>

<!-- Narration Field -->
<div class="col-sm-12">
    {!! Form::label('narration', 'Narration:') !!}
    <p>{{ $transaction->narration }}</p>
</div>

<!-- Debit Amount Field -->
<div class="col-sm-12">
    {!! Form::label('debit_amount', 'Debit Amount:') !!}
    <p>{{ $transaction->debit_amount }}</p>
</div>

<!-- Credit Amount Field -->
<div class="col-sm-12">
    {!! Form::label('credit_amount', 'Credit Amount:') !!}
    <p>{{ $transaction->credit_amount }}</p>
</div>

<!-- Created By Field -->
<div class="col-sm-12">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $transaction->created_by }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $transaction->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $transaction->updated_at }}</p>
</div>

