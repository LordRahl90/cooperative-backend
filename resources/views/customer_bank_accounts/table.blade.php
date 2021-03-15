<div class="table-responsive">
    <table class="table" id="customerBankAccounts-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Customer Id</th>
        <th>Bank Id</th>
        <th>Account Name</th>
        <th>Account Number</th>
        <th>Sort Code</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($customerBankAccounts as $customerBankAccount)
            <tr>
                <td>{{ $customerBankAccount->company_id }}</td>
            <td>{{ $customerBankAccount->customer_id }}</td>
            <td>{{ $customerBankAccount->bank_id }}</td>
            <td>{{ $customerBankAccount->account_name }}</td>
            <td>{{ $customerBankAccount->account_number }}</td>
            <td>{{ $customerBankAccount->sort_code }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerBankAccounts.destroy', $customerBankAccount->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerBankAccounts.show', [$customerBankAccount->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerBankAccounts.edit', [$customerBankAccount->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>