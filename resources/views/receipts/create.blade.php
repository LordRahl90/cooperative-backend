<?php
//dd(session()->all());
//dd(auth()->id());
?>
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Post new Income</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="card" id="incomeRegisterDiv">

            {!! Form::open(['url' => '/income/create','target'=>'_blank']) !!}

            <div class="card-body">

                <div class="row">
                @if(session('company_id')==0)
                    <!-- Company Id Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('company_id', 'Company:') !!}
                            {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select']) !!}
                        </div>
                    @else
                        <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
                @endif

                <!-- Name Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('payer', 'Name:') !!}
                        {!! Form::text('payer', null, ['class' => 'form-control','v-model="payments.narration"']) !!}
                    </div>

                    <!-- Phone Number Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('phone', 'Phone Number:') !!}
                        {!! Form::text('phone', null, ['class' => 'form-control','v-model="payments.narration"']) !!}
                    </div>
                    <!-- Email Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::text('email', null, ['class' => 'form-control','v-model="payments.narration"']) !!}
                    </div>

                    <!-- Credit Account Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('account_head', 'Select Account Head:') !!}
                        {!! Form::select('account_head', $acctHeads, null, ['class' => 'form-control custom-select','payments.debit_account']) !!}
                    </div>

                    <!-- Debit Account Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('bank_account', 'Select Bank Account:') !!}
                        {!! Form::select('bank_account', $bankAccounts, null, ['class' => 'form-control custom-select','payments.debit_account']) !!}
                    </div>

                    <!-- Reference Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('reference', 'Reference:') !!}
                        {!! Form::text('reference', strtoupper(uniqid('IN-')), ['class' => 'form-control','v-model="payments.reference"']) !!}
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

                </div>

            </div>

            <div class="card-footer" v-if="pv.id!==undefined">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('payments.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
