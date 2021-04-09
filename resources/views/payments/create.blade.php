@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Payment</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="card" id="paymentsDiv">

            {!! Form::open(['route' => 'payments.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('payments.fields')
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
@section('third_party_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var paymentsApp = new Vue({
            el: "#paymentsDiv",
            data: {
                payments: {
                    company_id: '{{ session('company_id') }}',
                    pv_id: 0,
                    reference: '{{ uniqid('REF-') }}',
                    confirmed_by: 0,
                    authorized_by: 0,
                    total_amount: '',
                    debit_account: 0,
                    narration: '',
                },
                pv: {},
            },
            methods: {
                async loadPVDetails() {
                    if (this.payments.pv_id === 0) {
                        return;
                    }
                    try {
                        let response = await axios.get(`/api/payment_vouchers/${this.payments.pv_id}/details`);
                        this.pv = response.data.data;
                        console.log(response.data);
                    } catch (e) {
                        alert(e);
                    }
                }
            },
            computed: {
                totalAmount() {
                    return this.pv.items.map(el => el.amount)
                        .reduce((total, element) => total + element);
                }
            }
        });
    </script>
@endsection
