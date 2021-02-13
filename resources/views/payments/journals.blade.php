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

            {!! Form::open(['url' => '/income/create']) !!}

            <div class="card-body">

                <div class="row">
                    <div class="form-group col-sm-6">
                        {!! Form::label('company_id', 'Company:') !!}
                        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select',' v-model="company_id"']) !!}
                    </div>

                    <!-- Total Amount Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('narration', 'Narration:') !!}
                        {!! Form::text('narration', null, ['class' => 'form-control','v-model="narration"']) !!}
                    </div>
                </div>

                <div class="row" v-if="company_id!=0 && narration!=''">
                    <div class="col-sm-6">
                        <table width="100%" class="table table-striped table-bordered" v-if="debit.length>0">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="10%">SN</th>
                                <th scope="col" width="20%">Code</th>
                                <th scope="col" width="20%">Name</th>
                                <th scope="col" width="45%">Amount</th>
                                <th scope="col" width="5%">Action</th>
                            </tr>
                            </thead>
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
                                <th scope="col" width="20%">Name</th>
                                <th scope="col" width="45%">Amount</th>
                                <th scope="col" width="5%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(v,k) in credit">
                                <td>@{{ k+1 }}</td>
                                <td>@{{ v.accountHead }}</td>
                                <td>dd</td>
                                <td>@{{ v.amount }}</td>
                                <td>dd</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="font-weight: bold">Total Credit:</td>
                                <td style="font-weight: bold">@{{ totalCredit }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                {!! Form::label('credit_account', 'Account Head:') !!}
                                {!! Form::select('credit_account', $accountHeads, null, ['class' => 'form-control custom-select',' v-model="creditItem.accountHead"']) !!}
                            </div>
                            <div class="form-group col-sm-4">
                                {!! Form::label('debit_amount', 'Enter Amount:') !!}
                                {!! Form::text('debit_amount', null, ['class' => 'form-control','v-model="debitItem.amount"']) !!}
                            </div>
                            <div style="vertical-align: center; padding-top: 5%;" class="form-group col-sm-4">
                                <button type="button" @click="addCreditEntry" class="btn btn-info">Add Credit Entry
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    <a href="{{ route('payments.index') }}" class="btn btn-default">Cancel</a>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var journalVoucherApp = new Vue({
            el: '#journalVoucherDiv',
            data: {
                company_id: 0,
                debitItem: {
                    accountHead: 0,
                    amount: 0,
                },
                creditItem: {
                    accountHead: 0,
                    amount: 0,
                },
                credit: [
                    {
                        accountHead: 1212,
                        amount: 2000,
                    }
                ],
                debit: [
                    {
                        accountHead: 1212,
                        amount: 2000,
                    }
                ],
                narration: '',
            },
            methods: {
                addDebitEntry() {
                    alert("Debit entry added");
                },
                addCreditEntry() {
                    alert("Credit entry added");
                }
            },
            computed: {
                totalCredit() {
                    return this.credit.map(el => el.amount)
                        .reduce((total, element) => total + element);
                }
            }
        });
    </script>
@endsection
