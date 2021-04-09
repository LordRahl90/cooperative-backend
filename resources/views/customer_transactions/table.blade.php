<div class="table-responsive">
    <table class="table" id="customerTransactions-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Customer</th>
            <th>Savings</th>
            <th>Loan</th>
            <th>Narration</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerTransactions as $customerTransaction)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $customerTransaction->company->name }}</td>
                @endif
                <td>{{ $customerTransaction->customer->full_name }}</td>
                <td>{{ $customerTransaction->savings_id==null?"":$customerTransaction->savings->savings->name }}</td>
                <td>{{ $customerTransaction->loan_id==null?"":$customerTransaction->loan->loan_application->loan_account->name }}</td>
                <td>{{ $customerTransaction->narration }}</td>
                <td>{{ number_format($customerTransaction->debit,2) }}</td>
                <td>{{ number_format($customerTransaction->credit,2) }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerTransactions.destroy', $customerTransaction->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerTransactions.show', [$customerTransaction->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerTransactions.edit', [$customerTransaction->id]) }}"
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
