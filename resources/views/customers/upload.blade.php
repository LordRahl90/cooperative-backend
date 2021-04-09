@extends('layouts.app')
@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.min.css"/>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Upload Customer Records</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="card" id="createCustomerForm">

            {!! Form::open(['url' => '/customer/upload','id'=>'uploadCustomerForm','ref'=>'updateCustomerForm','files'=>'true']) !!}

            <div class="card-body">
            @if(session('company_id')==0)
                <!-- Company Id Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('company_id', 'Company:') !!}
                        {!! Form::select('company_id', $companies, null, ['class' => 'form-control custom-select','v-model'=>'customer.company_id']) !!}
                    </div>
                @else
                    <input type="hidden" name="company_id" value="{{ session('company_id') }}"/>
            @endif

            <!-- Account Name Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('upload', 'Select Customer List:') !!}
                    {!! Form::file('upload') !!}
                </div>

                <p>Download customer format <a href="#">here</a></p>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('customers.index',$account) }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script src="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection
