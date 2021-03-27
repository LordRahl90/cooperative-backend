<div class="table-responsive">
    <table class="table" id="customerLoanLogs-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Customer</th>
            <th>Loan Id</th>
            <th>Debit</th>
            <th>Credit</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerLoanLogs as $customerLoanLog)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $customerLoanLog->company->name }}</td>
                @endif
                <td>{{ $customerLoanLog->customer }}</td>
                <td>{{ $customerLoanLog->loan_id }}</td>
                <td>{{ $customerLoanLog->debit }}</td>
                <td>{{ $customerLoanLog->credit }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerLoanLogs.destroy', $customerLoanLog->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerLoanLogs.show', [$customerLoanLog->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerLoanLogs.edit', [$customerLoanLog->id]) }}"
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
