@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif
{{--<!-- Customer Id Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('customer_id', 'Customer:') !!}--}}
{{--    {!! Form::select('customer_id', [], null, ['class' => 'form-control custom-select']) !!}--}}
{{--</div>--}}


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','v-model'=>'nok.name']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_address', 'Address:') !!}
    {!! Form::text('nok_address', null, ['class' => 'form-control','v-model'=>'nok.address']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_phone', 'Phone:') !!}
    {!! Form::text('nok_phone', null, ['class' => 'form-control','v-model'=>'nok.phone']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_email', 'Email:') !!}
    {!! Form::email('nok_email', null, ['class' => 'form-control','v-model'=>'nok.email']) !!}
</div>

<!-- Relationship Field -->
<div class="form-group col-sm-6">
    {!! Form::label('relationship', 'Relationship:') !!}
    {!! Form::text('relationship', null, ['class' => 'form-control','v-model'=>'nok.relationship']) !!}
</div>
