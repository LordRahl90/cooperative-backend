<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::select('company_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Account Head Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_head_id', 'Account Head Id:') !!}
    {!! Form::select('account_head_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Reference Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reference', 'Reference:') !!}
    {!! Form::text('reference', null, ['class' => 'form-control']) !!}
</div>

<!-- Narration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('narration', 'Narration:') !!}
    {!! Form::text('narration', null, ['class' => 'form-control']) !!}
</div>

<!-- Debit Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('debit_amount', 'Debit Amount:') !!}
    {!! Form::text('debit_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Credit Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('credit_amount', 'Credit Amount:') !!}
    {!! Form::text('credit_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Created By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_by', 'Created By:') !!}
    {!! Form::select('created_by', ], null, ['class' => 'form-control custom-select']) !!}
</div>
