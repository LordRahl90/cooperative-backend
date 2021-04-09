<?php
?>
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Reprint Payment Receipt</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card" id="paymentVoucherDiv">

            {!! Form::open(['url'=>'/reprints/receipt','id'=>'paymentReceiptForm','target'=>'_blank']) !!}

            <div class="card-body">
                <div class="row">
                    <!-- Pv Id Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('reference', 'Receipt Reference:') !!}
                        {!! Form::text('reference', null, ['class' => 'form-control','v-model="pv.id"']) !!}
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary">Proceed</button>
                <a href="{{ route('paymentVouchers.index',$account) }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
