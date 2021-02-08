<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::select('company_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Pv Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pv_id', 'Pv Id:') !!}
    {!! Form::select('pv_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Account Head Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_head_id', 'Account Head Id:') !!}
    {!! Form::select('account_head_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Narration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('narration', 'Narration:') !!}
    {!! Form::text('narration', null, ['class' => 'form-control']) !!}
</div>
