<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::select('company_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    {!! Form::select('customer_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Loan Account Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_account_id', 'Loan Account Id:') !!}
    {!! Form::select('loan_account_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Principal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('principal', 'Principal:') !!}
    {!! Form::text('principal', null, ['class' => 'form-control']) !!}
</div>

<!-- Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rate', 'Rate:') !!}
    {!! Form::text('rate', null, ['class' => 'form-control']) !!}
</div>

<!-- Interest Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interest_type', 'Interest Type:') !!}
    {!! Form::select('interest_type', ['FLAT_RATE' => 'FLAT_RATE', 'FLAT' => 'FLAT'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Tenor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tenor', 'Tenor:') !!}
    {!! Form::number('tenor', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', ['APPROVED' => 'APPROVED', 'DISAPPROVED' => 'DISAPPROVED', 'PENDING' => 'PENDING'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Staff Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('staff_id', 'Staff Id:') !!}
    {!! Form::select('staff_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>
