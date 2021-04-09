@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Loan Application</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="card" id="loanApplicationDiv">

            {!! Form::open(['route' => ['loanApplications.store',$account],'target'=>'_blank']) !!}

            <div class="card-body">

                <div class="row">
                    @include('loan_applications.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('loanApplications.index',$account) }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script>
        let loanApplication = new Vue({
            el: '#loanApplicationDiv',
            data: {
                principal: 0,
                rate: 0,
                tenor: 0,
                interest_type: '',
                repayment_amount: 0,
            },
            methods: {
                calculateRepaymentPlan() {
                    let type = this.interest_type;
                    if (type !== 'FLAT_RATE' || parseInt(this.tenor) === 0) {
                        this.repayment_amount = 0;
                        return 0;
                    }

                    let interest = parseInt(this.principal) * (parseFloat(this.rate) / 100);
                    console.log(interest);
                    this.repayment_amount = ((parseFloat(this.principal) + interest) / parseInt(this.tenor)).toFixed(2);
                },
                calculateTenor() {
                    let amount = this.repayment_amount;
                    let principal = parseFloat(this.principal);
                    let rate = parseFloat(this.rate);

                    if (principal === 0 || rate === 0) {
                        return 0;
                    }

                    let tenor = principal / amount;
                    this.tenor = Math.ceil(tenor);
                }
            },
            computed: {
                flatRate() {
                    return this.interest_type === "FLAT_RATE"
                },
                reducingBalance() {
                    return this.interest_type === "REDUCING_BALANCE"
                }
            }
        });
    </script>
@endsection
