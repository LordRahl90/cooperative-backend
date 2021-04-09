<?php
?>
<?php
?>
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Reverse Payment</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="card" id="paymentVoucherDiv">

            {!! Form::open(['url'=>'/reverse/payment','id'=>'paymentReceiptForm']) !!}

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


                    <!-- Pv Id Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('reference', 'Payment Reference:') !!}
                        {!! Form::text('reference', null, ['class' => 'form-control','v-model="pv.id"']) !!}
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary">Proceed</button>
                <a href="{{ route('payments.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

