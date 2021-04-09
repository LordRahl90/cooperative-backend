@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer Loan Logs</h1>
                </div>
{{--                <div class="col-sm-6">--}}
{{--                    <a class="btn btn-primary float-right"--}}
{{--                       href="{{ route('customerLoanLogs.create',$account) }}">--}}
{{--                        Add New--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('customer_loan_logs.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

