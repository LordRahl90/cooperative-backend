@if(session('company_id')==0)
    <!-- Company Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select','v-model'=>'account.company_id']) !!}
    </div>
@else
    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
@endif

<!-- Savings Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_category_id', 'Loans Category:') !!}
    {!! Form::select('loan_category_id', $categories, null, ['class' => 'form-control custom-select','v-model'=>'account.category_id','@change="loadAccountHeads"']) !!}
</div>

<div class="form-group col-sm-6" v-if="new_or_link==0">
    {!! Form::label('account_head_id', 'Account Head:') !!}
    <select class="form-control" name="account_head_id" v-model="account.account_head_id">
        @if(isset($loanAccount))
            <option value="{{ $loanAccount->account_head_id }}" selected
                    disabled>{{ $loanAccount->account_head->name }}</option>
        @else
            <option value="0" selected disabled>Select Account Head</option>
            <option v-for="(account,k) in account_heads" :value="k">@{{ account }}</option>
        @endif
    </select>
</div>


<!-- Code Field -->
<div class="form-group col-sm-6" v-if="new_or_link==1">
    {!! Form::label('code', 'Code:') !!}
    @if(isset($loanAccount))
        <input type="text" value="{{ $loanAccount->account_head->code }}" class="form-control" readonly/>
    @else
        {!! Form::text('code', null, ['class' => 'form-control','v-model'=>'account.code']) !!}
    @endif
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
