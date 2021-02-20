<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company:') !!}
    {!! Form::select('company_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Select Customer:') !!}
    {!! Form::select('customer_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Street Field -->
<div class="form-group col-sm-6">
    {!! Form::label('street', 'Street:') !!}
    {!! Form::text('street', null, ['class' => 'form-control']) !!}
</div>

<!-- Street2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('street2', 'Street2:') !!}
    {!! Form::text('street2', null, ['class' => 'form-control']) !!}
</div>

<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'Select State:') !!}
    {!! Form::select('state', [], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Country Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country', 'Select Country:') !!}
    {!! Form::select('country', [], null, ['class' => 'form-control custom-select']) !!}
</div>
