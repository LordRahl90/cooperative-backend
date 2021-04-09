<?php
?>
<?php
?>
@extends('layouts.app')

@section('third_party_stylesheets')
    <link rel="stylesheet"
          href="{{ asset('bower_components/datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Download Repayment Schedule</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['url' => '/repayment/schedule']) !!}

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

                <!-- Schedule date Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('start_date', 'Select Month and Year:') !!}
                        {!! Form::text('start_date', null, ['class' => 'form-control']) !!}
                    </div>

                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('staff.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script type="text/javascript" src="{{ asset("bower_components/moment/min/moment.min.js") }}"></script>
    <script type="text/javascript"
            src="{{ asset("bower_components/datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}"></script>
    <script>
        $(function () {
            $('#start_date').datetimepicker({
                format: 'YYYY-MM'
            });
        });
    </script>
@endsection

