<div class="table-responsive">
    <table class="table" id="orgBankAccounts-table">
        <thead>
            <tr>
                <th>Bank Id</th>
        <th>Account Name</th>
        <th>Slug</th>
        <th>Account Number</th>
        <th>Account Head Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orgBankAccounts as $orgBankAccount)
            <tr>
                <td>{{ $orgBankAccount->bank_id }}</td>
            <td>{{ $orgBankAccount->account_name }}</td>
            <td>{{ $orgBankAccount->slug }}</td>
            <td>{{ $orgBankAccount->account_number }}</td>
            <td>{{ $orgBankAccount->account_head_id }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['orgBankAccounts.destroy', $orgBankAccount->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('orgBankAccounts.show', [$orgBankAccount->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('orgBankAccounts.edit', [$orgBankAccount->id]) }}" class='btn btn-default btn-xs'>
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
