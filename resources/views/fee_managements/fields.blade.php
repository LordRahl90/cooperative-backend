<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Duration Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('duration', 'Duration:') !!}--}}
{{--    {!! Form::text('duration', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Deadline Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deadline', 'Deadline:') !!}
    {!! Form::text('deadline', null, ['class' => 'form-control','id'=>'deadline']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#deadline').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Account Head Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_head_id', 'Account Head:') !!}
    {!! Form::select('account_head_id', [], null, ['class' => 'form-control custom-select']) !!}
</div>
