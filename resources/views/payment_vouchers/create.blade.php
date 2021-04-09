@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Payment Voucher</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card" id="paymentVoucherDiv">

            {!! Form::open(['route' => ['paymentVouchers.store',$account],'id'=>'paymentVoucherForm']) !!}

            <div class="card-body">
                <div class="row">
                    @include('payment_vouchers.fields')
                </div>
            </div>

            <div class="card-footer">
                <button type="button" class="btn btn-primary" @click="createPaymentVoucher">Save</button>
                <a href="{{ route('paymentVouchers.index',$account) }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var paymentVoucher = new Vue({
            el: "#paymentVoucherDiv",
            data: {
                item: {
                    account_head_id: "",
                    narration: "",
                    rate: "",
                    quantity: "",
                    amount: ""
                },
                pv: {
                    id: "{{ strtoupper(uniqid('PV-')) }}",
                    company_id: "{{ session('company_id') }}",
                    payee: "",
                    address: "",
                    email: "",
                    website: "",
                    phone: "",
                    bank_id: "",
                    account_name: "",
                    account_number: ""
                },
                items: [],
                account_heads: [],
            },
            methods: {
                addNewPVItem() {
                    let item = this.item;
                    if (item.narration === "" || item.rate === "" || item.quatity === "" || item.amount === "") {
                        this.error("Please provide the PV Item details")
                        return;
                    }
                    this.items.push(item);
                    this.clearItem();

                },
                async loadOrgAccounts() {
                    let companyID = this.pv.company_id;
                    if (companyID === 0) {
                        this.error("Select valid company iD");
                        return
                    }

                    try {
                        let response = await axios.get(`/api/companies/${companyID}/account-heads`);
                        if (response.data.data.length === 0) {
                            this.error("No account head registered for this company");
                            return;
                        }
                        this.account_heads = response.data.data;
                    } catch (e) {
                        this.error(e);
                    }
                },
                success(msg) {
                    toastr.success(msg)
                },
                error(msg) {
                    toastr.error(msg)
                },
                clearItem() {
                    this.item = {
                        account_head_id: "",
                        narration: "",
                        rate: "",
                        quantity: "",
                        amount: ""
                    }
                },
                removeItem(index) {
                    // delete this.items[index];
                    console.log(this.items);
                    this.items = this.items.filter((val, i, element) => {
                        return i !== index;
                    });

                    console.log(this.items);
                },
                accountHead(id) {
                    if (this.items.length === 0) {
                        return "";
                    }
                    let acc = this.account_heads.filter((acct) => {
                        if (acct.id === id) {
                            return acct;
                        }
                    });
                    if (acc === undefined || acc === null || acc.length === 0) {
                        return ""
                    }
                    acc = acc[0];
                    console.log(acc);
                    return `${acc.code | acc.name}`;
                },
                async createPaymentVoucher() {
                    let payload = {
                        _token: '{{ csrf_token() }}',
                        details: this.pv,
                        items: this.items
                    };
                    try {
                        let response = await axios.post('/api/payment_vouchers', payload);
                        window.location = `/paymentVouchers/${this.pv.id}/details`;
                        this.pv = {
                            id: "{{ strtoupper(uniqid('PV-')) }}",
                            company_id: "{{ session('company_id') }}",
                            payee: "",
                            address: "",
                            email: "",
                            website: "",
                            phone: "",
                            bank_id: "",
                            account_name: "",
                            account_number: ""
                        };
                        this.clearItem();
                    } catch (e) {
                        console.log(e);
                        this.error(e.message);
                    }
                }
            },
            created: function () {
                this.loadOrgAccounts();
            },
            computed: {}
        });
    </script>
@endsection
