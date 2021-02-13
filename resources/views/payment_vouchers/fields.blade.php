<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company:') !!}
    {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select','v-model="pv.company_id" @change="loadOrgAccounts"']) !!}
</div>

<!-- Payee Field -->
<div class="form-group col-sm-6">
    {!! Form::label('payee', 'Payee:') !!}
    {!! Form::text('payee', null, ['class' => 'form-control','v-model="pv.payee"']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control','v-model="pv.address"']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control','v-model="pv.email"']) !!}
</div>

<!-- Website Field -->
<div class="form-group col-sm-6">
    {!! Form::label('website', 'Website:') !!}
    {!! Form::text('website', null, ['class' => 'form-control','v-model="pv.website"']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control','v-model="pv.phone"']) !!}
</div>

<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bank_id', 'Bank Name:') !!}
    {!! Form::select('bank_id', $banks, null, ['class' => 'form-control custom-select','v-model="pv.bank_id"']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_name', 'Account Name:') !!}
    {!! Form::text('account_name', null, ['class' => 'form-control','v-model="pv.account_name"']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_number', 'Account Number:') !!}
    {!! Form::text('account_number', null, ['class' => 'form-control','v-model="pv.account_number"']) !!}
</div>

<!-- Pv Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pv_id', 'Pv ID:') !!}
    {!! Form::text('pv_id', null, ['class' => 'form-control','v-model="pv.id"']) !!}
</div>

<div class="col-md-12 form-group" style="border: 1px solid #000;">
    <h3>PV Items</h3>
    <table width="100%" class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th width="5%">SN</th>
            <th width="15%">Account Head</th>
            <th width="40%">Description</th>
            <th width="10%">Rate</th>
            <th width="10%">Quantity</th>
            <th width="25%">Amount</th>
            <th width="10%">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(v,k) in items" :key="k">
            <td>@{{ k+1 }}</td>
            <td>@{{ accountHead(v.account_head_id) }}</td>
            <td>@{{ v.narration }}</td>
            <td>@{{ v.rate }}</td>
            <td>@{{ v.quantity }}</td>
            <td>@{{ v.amount }}</td>
            <td style="text-align: center; vertical-align: center" @click="removeItem(k)">
                <i style="color:red;"
                   class="fas fa-times"></i>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="row" style="width:100%; border: 1px solid #000;">
    <!-- Account Head Id Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('account_head_id', 'Account Head:') !!}
        <select name="account_head_id[]" id="account_head_id" class="form-control custom-select"
                v-model="item.account_head_id">
            <option selected disabled>Select Account</option>
            <option v-for="v in account_heads" :value="v.id" :key="v.id">@{{ `${v.code}| ${v.name}` }}
            </option>
        </select>
    </div>

    <!-- Narration Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('narration', 'Narration:') !!}
        {!! Form::text('narration', null, ['class' => 'form-control','v-model="item.narration"']) !!}
    </div>

    <!-- Rate Field -->
    <div class="form-group col-sm-1">
        {!! Form::label('rate', 'Rate:') !!}
        {!! Form::text('rate', null, ['class' => 'form-control','v-model="item.rate"']) !!}
    </div>

    <div class="form-group col-sm-1">
        {!! Form::label('quantity', 'Quantity:') !!}
        {!! Form::text('quantity', null, ['class' => 'form-control custom-select','v-model="item.quantity"']) !!}
    </div>

    <!-- Amount Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('amount', 'Amount:') !!}
        {!! Form::text('amount', null, ['class' => 'form-control','v-model="item.amount"']) !!}
    </div>

    <div class="card-footer">
        <button type="button" class="btn btn-info" id="addPVItem" @click="addNewPVItem">Add PV Item</button>
    </div>

</div>
