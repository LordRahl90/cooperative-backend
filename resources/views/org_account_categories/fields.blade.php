<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::select('company_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Account Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_type', 'Account Type:') !!}
    {!! Form::select('account_type', ['Select' => '0'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Prefix Digit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('prefix_digit', 'Prefix Digit:') !!}
    {!! Form::number('prefix_digit', null, ['class' => 'form-control']) !!}
</div>