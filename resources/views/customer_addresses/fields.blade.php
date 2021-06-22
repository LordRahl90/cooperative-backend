@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif

<!-- Street Field -->
<div class="form-group col-sm-6">
    {!! Form::label('street', 'Address line:') !!}
    {!! Form::text('street', null, ['class' => 'form-control','v-model'=>'address.street']) !!}
</div>

<!-- Street2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('street2', 'Address Line 2:') !!}
    {!! Form::text('street2', null, ['class' => 'form-control','v-model'=>'address.street2']) !!}
</div>

<!-- Country Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country', 'Select Country:') !!}
    {!! Form::select('country', $countries, null, ['class' => 'form-control custom-select','v-model'=>'address.country','@change="loadState"']) !!}
</div>


<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'Select State:') !!}
    <select name="state" id="state" class="form-control" v-model="address.state">
        <option disabled selected>Select State</option>
        <option v-for="state in states" :key="state.id" :value="state.id">@{{ state.name }}</option>
    </select>
</div>
