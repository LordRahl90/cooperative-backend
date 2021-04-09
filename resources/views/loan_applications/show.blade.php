@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Loan Application Details</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('loanApplications.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    @include('loan_applications.show_fields')
                    @if(count($repayments)>0)
                        <div class="row col">
                            <h2>Repayment</h2>
                            <table width="100%" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th width="10%">Date</th>
                                    <th>Principal</th>
                                    <th>Interest</th>
                                    <th>Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($repayments as $repayment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($repayment->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ number_format($repayment->principal,2) }}</td>
                                        <td>{{ number_format($repayment->interest,2) }}</td>
                                        <td>{{ number_format(($loanApplication->principal - $repayment->principal),2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                {{ Form::open(['url'=>'loan_applications/approve']) }}
                {!! Form::submit('Approve Loan', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('loanApplications.index') }}" class="btn btn-default">Cancel</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
