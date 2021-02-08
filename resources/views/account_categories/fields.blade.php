<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Prefix Digit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('prefix_digit', 'Prefix Digit:') !!}
    {!! Form::number('prefix_digit', null, ['class' => 'form-control','min' => 1,'max' => 9]) !!}
</div>

<!-- Account Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_type', 'Account Type:') !!}
    {!! Form::select('account_type', ['Select' => '0'], null, ['class' => 'form-control custom-select']) !!}
</div>
