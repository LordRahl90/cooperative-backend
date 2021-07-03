<?php
?>
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Post Journal Voucher</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="card" id="journalVoucherDiv">

            {!! Form::open(['url' => '/journalVoucher/create']) !!}

            <div class="card-body">

                <div class="row">
                @if(session('company_id')==0)
                    <!-- Company Id Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('company_id', 'Company:') !!}
                            {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select',' v-model="company_id"']) !!}
                        </div>
                    @else
                        <input type="hidden" name="company_id" v-model="company_id"
                               value="{{ session('company_id') }}"/>
                @endif

                <!-- Narration Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('narration', 'Narration:') !!}
                        {!! Form::text('narration', null, ['class' => 'form-control','v-model="narration"']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('reference', 'Reference:') !!}
                        {!! Form::text('reference', null, ['class' => 'form-control','v-model="reference"']) !!}
                    </div>
                </div>

                <div class="row" v-if="company_id!=0 && narration!=''">
                    <div class="col-sm-6">
                        <table width="100%" class="table table-striped table-bordered" v-if="debit.length>0">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="10%">SN</th>
                                <th scope="col" width="20%">Code</th>
                                <th scope="col" width="45%">Amount</th>
                                <th scope="col" width="5%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(v,k) in debit">
                                <td>@{{ k+1 }}</td>
                                <td>@{{ v.accountHead }}</td>
                                <td>@{{ v.amount.toLocaleString() }}</td>
                                <td style="text-align: center; vertical-align: center" @click="removeDebitItem(k)">
                                    <i style="color:red;"
                                       class="fas fa-times"></i>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight: bold">Total Debit:</td>
                                <td style="font-weight: bold">@{{ totalDebit.toLocaleString() }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                {!! Form::label('debit_account', 'Account Head:') !!}
                                {!! Form::select('debit_account', $accountHeads, null, ['class' => 'form-control custom-select',' v-model="debitItem.accountHead"']) !!}
                            </div>
                            <div class="form-group col-sm-4">
                                {!! Form::label('debit_amount', 'Enter Amount:') !!}
                                {!! Form::text('debit_amount', null, ['class' => 'form-control','v-model="debitItem.amount"']) !!}
                            </div>
                            <div style="vertical-align: center; padding-top: 5%;" class="form-group col-sm-4">
                                <button type="button" @click="addDebitEntry" class="btn btn-info">Add Debit Entry
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <table width="100%" class="table table-striped table-bordered" v-if="credit.length>0">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="10%">SN</th>
                                <th scope="col" width="20%">Code</th>
                                <th scope="col" width="45%">Amount</th>
                                <th scope="col" width="5%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(v,k) in credit">
                                <td>@{{ k+1 }}</td>
                                <td>@{{ v.accountHead }}</td>
                                <td>@{{ v.amount.toLocaleString() }}</td>
                                <td style="text-align: center; vertical-align: center" @click="removeCreditItem(k)">
                                    <i style="color:red;"
                                       class="fas fa-times"></i>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight: bold">Total Credit:</td>
                                <td style="font-weight: bold">@{{ totalCredit.toLocaleString() }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                {!! Form::label('credit_account', 'Account Head:') !!}
                                {!! Form::select('credit_account', $accountHeads, null, ['class' => 'form-control custom-select',' v-model="creditItem.accountHead"']) !!}
                            </div>
                            <div class="form-group col-sm-4">
                                {!! Form::label('credit_amount', 'Enter Amount:') !!}
                                {!! Form::text('credit_amount', null, ['class' => 'form-control','v-model="creditItem.amount"']) !!}
                            </div>
                            <div style="vertical-align: center; padding-top: 5%;" class="form-group col-sm-4">
                                <button type="button" @click="addCreditEntry" class="btn btn-info">Add Credit Entry
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="button" @click="postJV()" class="btn btn-primary">Post JV</button>
                    <button type="button" @click="previewJV()" class="btn btn-info">Preview JV</button>
                    <a href="{{ route('payments.index',$account) }}" class="btn btn-default">Cancel</a>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function initialState() {
            return {
                company_id: '{{ session('company_id') }}',
                debitItem: {
                    accountHead: 0,
                    amount: 0,
                },
                creditItem: {
                    accountHead: 0,
                    amount: 0,
                },
                credit: [],
                debit: [],
                narration: 'Test Narration',
                reference: '{{ strtoupper(uniqid('JV-')) }}'
            };
        }

        var journalVoucherApp = new Vue({
            el: '#journalVoucherDiv',
            data: {
                company_id: 1,
                debitItem: {
                    accountHead: 0,
                    amount: 0,
                },
                creditItem: {
                    accountHead: 0,
                    amount: 0,
                },
                credit: [],
                debit: [],
                narration: '',
                reference: '{{ strtoupper(uniqid('JV-')) }}'
            },
            methods: {
                addDebitEntry() {
                    let entry = this.debitItem;
                    if (entry.accountHead === 0) {
                        this.error('Invalid account head');
                        return;
                    }
                    if (entry.amount === 0) {
                        this.error('Amount must be greater than 0');
                        return;
                    }

                    // check for duplicates in credit entry
                    for (const i of this.credit) {
                        if (i.accountHead === entry.accountHead) {
                            this.error('Cannot have same account on both sides');
                            return;
                        }
                    }
                    this.debit.push(entry);
                    this.debitItem = {
                        accountHead: 0,
                        amount: 0
                    }
                },
                addCreditEntry() {
                    let entry = this.creditItem;
                    if (entry.accountHead === 0) {
                        this.error('Invalid account head');
                        return;
                    }
                    if (entry.amount === 0) {
                        this.error('Amount must be greater than 0');
                        return;
                    }
                    // check for duplicates in credit entry
                    for (const i of this.debit) {
                        if (i.accountHead === entry.accountHead) {
                            this.error('Cannot have same account on both sides');
                            return;
                        }
                    }
                    this.credit.push(entry);
                    this.creditItem = {
                        accountHead: 0,
                        amount: 0
                    }
                },
                removeDebitItem(index) {
                    this.debit = this.debit.filter((val, i, element) => {
                        return i !== index;
                    });
                },
                removeCreditItem(index) {
                    this.credit = this.credit.filter((val, i, element) => {
                        return i !== index;
                    });
                },
                async postJV() {
                    if (this.totalCredit !== this.totalDebit) {
                        this.error("The Journal Voucher is not balanced.");
                        return;
                    }
                    let payload = {
                        company_id: this.company_id,
                        narration: this.narration,
                        reference: this.reference,
                        credit: this.credit,
                        debit: this.debit,
                        user_id: '{{ auth()->id() }}'
                    };
                    try {
                        let response = await axios.post('/api/payments/jv', payload);
                        success(response.data.message);
                        this.clearFields();
                    } catch (e) {
                        this.error(e);
                    }
                },
                previewJV() {
                    alert("Preview JV");
                },
                success(msg) {
                    toastr.success(msg)
                },
                error(msg) {
                    toastr.error(msg)
                },
                clearFields() {
                    this.credit = [];
                    this.debit = [];
                    this.company_id = 0;
                    this.reference = '{{ strtoupper(uniqid('JV-')) }}';
                    this.narration = '';
                }
            },
            computed: {
                totalCredit() {
                    return this.credit.map(el => el.amount)
                        .reduce((total, element) => parseFloat(total) + parseFloat(element));
                },
                totalDebit() {
                    return this.debit.map(el => el.amount)
                        .reduce((total, element) => parseFloat(total) + parseFloat(element));
                }
            }
        });
    </script>
@endsection
