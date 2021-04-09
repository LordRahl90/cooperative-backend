@extends('layouts.app')
@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.min.css"/>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Customer</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="card" id="createCustomerForm">

            {!! Form::open(['route' => ['members.store',$account],'id'=>'createCustomerForm','ref'=>'createCustomerForm']) !!}

            <div class="card-body">
                <form-wizard @on-complete="onComplete">
                    <tab-content title="Personal details"
                                 icon="ti-user" :before-change="validateCustomer">
                        <div class="row">
                            @include('customers.fields')
                        </div>
                    </tab-content>
                    <tab-content title="Address and Bank Details"
                                 icon="ti-settings" :before-change="validateAddressAndBank">
                        <h2>Address</h2>
                        <div class="row">
                            @include('customer_addresses.fields')
                        </div>

                        <h2>Bank Details</h2>
                        <hr/>
                        <div class="row">
                            @include('customer_bank_accounts.fields')
                        </div>
                    </tab-content>
                    <tab-content title="Next of Kin"
                                 icon="ti-check" :before-change="validateNextOfKin">
                        <div class="row">
                            @include('customer_next_of_kins.fields')
                        </div>
                    </tab-content>
                    <tab-content title="Preview"
                                 icon="ti-check">
                        <div class="row">
                            @include('customers.preview')
                        </div>
                    </tab-content>
                </form-wizard>
            </div>

            {{--            <div class="card-footer">--}}
            {{--                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}--}}
            {{--                <a href="{{ route('customers.index') }}" class="btn btn-default">Cancel</a>--}}
            {{--            </div>--}}

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script src="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        Vue.use(VueFormWizard);
        var customer = new Vue({
            el: '#createCustomerForm',
            data: {
                customer: {
                    company_id: '{{ session('company_id') }}',
                    surname: '',
                    other_names: '',
                    reference: '',
                    email: '',
                    phone: '',
                    gender: '',
                    password: '',
                    religion: '',
                    dob: '',
                },
                nok: {
                    name: '',
                    address: '',
                    phone: '',
                    email: '',
                    relationship: '',
                },
                bank: {
                    id: 0,
                    account_name: '',
                    account_number: '',
                    sort_code: ''
                },
                address: {
                    street: '',
                    street2: '',
                    country: '',
                    state: '',
                },
                states: [],
            },
            methods: {
                onComplete() {
                    this.$refs.createCustomerForm.submit();
                },
                validateCustomer() {
                    console.log('Validating customer');
                    return true;
                },
                validateAddressAndBank() {
                    console.log('Validating Address and bank');
                    return true;
                },
                validateNextOfKin() {
                    console.log('Validating Next of kin');
                    return true;
                },
                async loadState() {
                    console.log('Loading state');
                    let code = this.address.country;
                    try {
                        let response = await axios.get(`/api/countries/${code}/states`);
                        this.states = response.data.data;
                        console.log(response.data);
                    } catch (e) {
                        console.error(e);
                    }
                }
            },
        });
    </script>
@endsection
