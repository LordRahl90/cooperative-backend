@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select','v-model'=>'account.company_id']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif

<div class="form-group col-sm-12">
    <label>New Account Head</label>
    <input type="checkbox" v-model="new_or_link" />
</div>

<!-- Savings Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('savings_category_id', 'Savings Category:') !!}
    {!! Form::select('savings_category_id', $categories, null, ['class' => 'form-control custom-select','v-model'=>'account.category_id','@change="loadAccountHeads"']) !!}
</div>


<!-- Account Head Id Field -->
<div class="form-group col-sm-6" v-if="new_or_link==0">
    {!! Form::label('account_head_id', 'Account Head:') !!}
    <select class="form-control" name="account_head_id" v-model="account.account_head_id">
        <option value="0" selected disabled>Select Account Head</option>
        <option v-for="(account,k) in account_heads" :value="k">@{{ account }}</option>
    </select>
</div>


<!-- Code Field -->
<div class="form-group col-sm-6" v-if="new_or_link==1">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control','v-model'=>'account.code']) !!}
</div>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','v-model'=>'account.name']) !!}
</div>


<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control','v-model'=>'account.description']) !!}
</div>
