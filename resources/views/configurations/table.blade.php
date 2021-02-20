<div class="table-responsive">
    <table class="table" id="configurations-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Income</th>
            <th>Expense</th>
            <th>Cash Account</th>
            <th>Fixed Asset</th>
            <th>Current Assets</th>
            <th>Account Payable</th>
            <th>Account Receivable</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($configurations as $configuration)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $configuration->company->name }}</td>
                @endif
                <td>{{ $configuration->income->name }}</td>
                <td>{{ $configuration->expense->name }}</td>
                <td>{{ $configuration->cash_account->name }}</td>
                <td>{{ $configuration->fixed_asset->name }}</td>
                <td>{{ $configuration->current_asset->name }}</td>
                <td>{{ $configuration->account_payable->name }}</td>
                <td>{{ $configuration->account_receivable->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['configurations.destroy', $configuration->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('configurations.show', [$configuration->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('configurations.edit', [$configuration->id]) }}"
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
