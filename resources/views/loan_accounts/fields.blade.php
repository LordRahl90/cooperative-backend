<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::select('company_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Loan Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_category_id', 'Loan Category Id:') !!}
    {!! Form::select('loan_category_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Account Head Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_head_id', 'Account Head Id:') !!}
    {!! Form::select('account_head_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>