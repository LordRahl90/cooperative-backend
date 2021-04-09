@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Loan Repayment</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card" id="loanRepaymentDiv">

            {!! Form::open(['route' => 'loanRepayments.store','target'=>'_blank']) !!}

            <div class="card-body">

                <div class="row">
                    @include('loan_repayments.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('loanRepayments.index') }}" class="btn btn-default">Cancel</a>
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
                loan_id: 0,
                principal: 0.0,
                interest: 0,
                amount: 0,
                amountPayable: 0,
                loans: [],
            },
            methods: {
                async loadCustomerLoans() {
                    this.loan_id = 0;
                    this.loans = [];
                    try {
                        if (this.customer_id === 0) {
                            return;
                        }
                        let response = await axios.get(`/api/customer-loans/${this.customer_id}`);
                        this.loans = response.data.data;
                        console.log(response.data);
                    } catch (e) {
                        console.log(e);
                    }
                },
                async loadLoanRepaymentAmount() {
                    let loanID = this.loan_id;
                    if (loanID === 0) {
                        return;
                    }
                    try {
                        let response = await axios.get(`/api/customer-loans/${loanID}/details`);
                        this.principal = response.data.data.principal;
                        this.interest = response.data.data.interest;
                        console.log(this.principal);
                        this.amountPayable = this.principal + this.interest
                        this.amount = this.principal + this.interest;
                    } catch (e) {
                        console.log(e);
                    }
                },
                updateAmount() {
                    this.amount = parseFloat(this.principal) + parseFloat(this.interest);
                }
            },
            computed: {}
        });
    </script>
@endsection
