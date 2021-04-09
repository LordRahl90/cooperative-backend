<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company:') !!}
    <p>{{ $journalVoucher->company->name }}</p>
</div>

<!-- Reference Field -->
<div class="col-sm-12">
    {!! Form::label('reference', 'Reference:') !!}
    <p>{{ $journalVoucher->reference }}</p>
</div>

<!-- Narration Field -->
<div class="col-sm-12">
    {!! Form::label('narration', 'Narration:') !!}
    <p>{{ $journalVoucher->narration }}</p>
</div>

<!-- Total Amount Field -->
<div class="col-sm-12">
    {!! Form::label('total_amount', 'Total Amount:') !!}
    <p>{{ number_format($journalVoucher->total_amount,2) }}</p>
</div>

<!-- Created By Field -->
<div class="col-sm-12">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $journalVoucher->staff->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $journalVoucher->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $journalVoucher->updated_at }}</p>
</div>

