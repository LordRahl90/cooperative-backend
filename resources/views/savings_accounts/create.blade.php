@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Savings Account</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="card" id="savingsAccountDiv">

            {!! Form::open(['route' => ['savingsAccounts.store',$account]]) !!}

            <div class="card-body">

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>New Account Head</label>
                        <input type="checkbox" v-model="new_or_link"/>
                    </div>

                    @include('savings_accounts.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('savingsAccounts.index',$account) }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('third_party_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var savingsAccount = new Vue({
            el: '#savingsAccountDiv',
            data: {
                new_or_link: false,
                account: {
                    code: '',
                    category_id: 0,
                    company_id: '{{ session('company_id') }}',
                    name: '',
                    account_head_id: 0,
                    description: '',
                },
                account_heads: {}
            },
            methods: {
                async loadAccountHeads() {
                    this.account_heads = {};
                    this.account.account_head_id = 0;
                    let categoryID = this.account.category_id;
                    if (categoryID === 0) {
                        return;
                    }
                    try {
                        let response = await axios.get(`/api/savings-categories/${categoryID}/accounts`);
                        this.account_heads = response.data.data;
                    } catch (e) {
                        console.log(e);
                    }
                }
            }
        });
    </script>
@endsection
