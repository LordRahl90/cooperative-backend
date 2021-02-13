<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company:') !!}
    {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select',' v-model="payments.company_id"']) !!}
</div>


<!-- Pv Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pv_id', 'Select PV:') !!}
    {!! Form::select('pv_id', $pvs, null, ['class' => 'form-control custom-select','v-model="payments.pv_id" @change="loadPVDetails"']) !!}
</div>

<div class="row" v-if="pv!==undefined && pv.id!==undefined" style="border: 1px solid #000; width: 100%">
    <div class="col-md-6 form-group">
        <label>Payee: </label>
        <p>@{{ pv.payee }}</p>
    </div>

    <div class="col-md-6  form-group">
        <label>Address: </label>
        <p>@{{ pv.address }}</p>
    </div>

    <div class="col-md-6  form-group">
        <label>Email: </label>
        <p>@{{ pv.email }}</p>
    </div>

    <div class="col-md-6 form-group">
        <label>Phone: </label>
        <p>@{{ pv.phone }}</p>
    </div>

    <div class="col-md-12" v-if="pv.items!==undefined && pv.items.length>0">
        <h3>PV Details</h3>
        <table width="100%" class="table table-responsive table-bordered">
            <thead>
            <tr>
                <th width="5%">SN</th>
                <th width="20%">Account Head</th>
                <th width="40%">Description</th>
                <th width="10%">Rate</th>
                <th width="10%">Quantity</th>
                <th width="25%">Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(v,k) in pv.items" :key="k">
                <td>@{{ k+1 }}</td>
                <td>@{{ v.account_head.code }}</td>
                <td>@{{ v.narration }}</td>
                <td>@{{ v.rate }}</td>
                <td>@{{ v.quantity.toLocaleString() }}</td>
                <td>&#x20A6;@{{ v.amount.toLocaleString() }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold" colspan="5">Total</td>
                <td style="font-weight: bold">&#x20A6;@{{ totalAmount.toLocaleString() }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</div>


<!-- Reference Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reference', 'Reference:') !!}
    {!! Form::text('reference', null, ['class' => 'form-control','v-model="payments.reference"']) !!}
</div>

<!-- Confirmed By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('confirmed_by', 'Confirmed By:') !!}
    {!! Form::select('confirmed_by', $staff, null, ['class' => 'form-control custom-select','v-model="payments.confirmed_by"']) !!}
</div>


<!-- Authorized By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('authorized_by', 'Authorized By:') !!}
    {!! Form::select('authorized_by', $staff, null, ['class' => 'form-control custom-select','v-model="payments.authorized_by"']) !!}
</div>


<!-- Total Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('narration', 'Narration:') !!}
    {!! Form::text('narration', null, ['class' => 'form-control','v-model="payments.narration"']) !!}
</div>


<!-- Total Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_amount', 'Total Amount:') !!}
    {!! Form::text('total_amount', null, ['class' => 'form-control','v-model="payments.total_amount"']) !!}
</div>

<!-- Debit Account Field -->
<div class="form-group col-sm-6">
    {!! Form::label('debit_account', 'Select Bank Account:') !!}
    {!! Form::select('debit_account', $bankAccounts, null, ['class' => 'form-control custom-select','payments.debit_account']) !!}
</div>
