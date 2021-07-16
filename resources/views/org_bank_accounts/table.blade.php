<div class="table-responsive" style="padding:5px 5px;">
    <table id="example" class="table table-bordered table-hover">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Bank</th>
            <th>Account Name</th>
            <th>Account Number</th>
            <th>Account Code</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orgBankAccounts as $orgBankAccount)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $configuration->company->name }}</td>
                @endif
                <td>{{ $orgBankAccount->bank->name }}</td>
                <td>{{ $orgBankAccount->account_name }}</td>
                <td>{{ $orgBankAccount->account_number }}</td>
                <td>{{ $orgBankAccount->account_head->code }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['orgBankAccounts.destroy',$account, $orgBankAccount->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('orgBankAccounts.show', [$account,$orgBankAccount->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('orgBankAccounts.edit', [$account,$orgBankAccount->id]) }}"
                           class='btn btn-default btn-xs'>
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
