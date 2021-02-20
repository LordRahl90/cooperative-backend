<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::select('company_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Loan Application Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_application_id', 'Loan Application Id:') !!}
    {!! Form::select('loan_application_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Approved By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('approved_by', 'Approved By:') !!}
    {!! Form::select('approved_by', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', ['COMPLETED' => 'COMPLETED', 'RUNNING' => 'RUNNING'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Total Repaid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_repaid', 'Total Repaid:') !!}
    {!! Form::text('total_repaid', null, ['class' => 'form-control']) !!}
</div>

<!-- Narration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('narration', 'Narration:') !!}
    {!! Form::text('narration', null, ['class' => 'form-control']) !!}
</div>