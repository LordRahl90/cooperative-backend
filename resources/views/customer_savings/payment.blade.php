<?php
?>
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Savings Payment</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card" id="loanRepaymentDiv">

            {!! Form::open(['/customer-savings/payment','target'=>'_blank']) !!}

            <div class="card-body">

                <div class="row">
                @if(session('company_id')==0)
                    <!-- Company Id Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('company_id', 'Company:') !!}
                            {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select','v-model'=>'company_id']) !!}
                        </div>
                    @else
                        <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
                @endif

                <!-- Customer Id Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('customer_id', 'Customer:') !!}
                        {!! Form::select('customer_id', $customers, null, ['class' => 'form-control custom-select','v-model'=>'customer_id','@change="loadCustomerLoans"']) !!}
                    </div>


                    <!-- Loan Id Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('savings_id', 'Savings Plan:') !!}
                        <select name="savings_id" v-model="savings_id" class="form-control">
                            <option value="0" selected disabled>Select Savings Plan</option>
                            <option v-for="saving in savings" :value="saving.id">@{{ saving.savings.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Debit Account Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('bank_account', 'Select Bank Account:') !!}
                        {!! Form::select('bank_account', $bankAccounts, null, ['class' => 'form-control custom-select','payments.debit_account']) !!}
                    </div>

                    <!-- Narration Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('reference', 'Reference:') !!}
                        {!! Form::text('reference', strtoupper(uniqid('SV-')), ['class' => 'form-control']) !!}
                    </div>

                    <!-- Narration Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('narration', 'Narration:') !!}
                        {!! Form::text('narration', null, ['class' => 'form-control']) !!}
                    </div>


                    <!-- Amount Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('amount', 'Amount:') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control','v-model'=>'amount']) !!}
                    </div>

                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('customerSavings.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var loanRepaymentApp = new Vue({
            el: '#loanRepaymentDiv',
            data: {
                company_id: 0,
                customer_id: 0,
                savings_id: 0,
                amount: 0,
                savings: [],
            },
            methods: {
                async loadCustomerLoans() {
                    this.savings_id = 0;
                    this.savings = [];
                    try {
                        if (this.customer_id === 0) {
                            return;
                        }
                        let response = await axios.get(`/api/customer-savings/${this.customer_id}`);
                        this.savings = response.data.data;
                        console.log(response.data);
                    } catch (e) {
                        console.log(e);
                    }
                }
            }
        });
    </script>
@endsection

