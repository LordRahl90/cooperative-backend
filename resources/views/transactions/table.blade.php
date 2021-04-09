<div class="table-responsive">
    <table class="table" id="transactions-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Account Head Id</th>
        <th>Reference</th>
        <th>Narration</th>
        <th>Debit Amount</th>
        <th>Credit Amount</th>
        <th>Created By</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->company_id }}</td>
            <td>{{ $transaction->account_head_id }}</td>
            <td>{{ $transaction->reference }}</td>
            <td>{{ $transaction->narration }}</td>
            <td>{{ $transaction->debit_amount }}</td>
            <td>{{ $transaction->credit_amount }}</td>
            <td>{{ $transaction->created_by }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['transactions.destroy', $transaction->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('transactions.show', [$transaction->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('transactions.edit', [$transaction->id]) }}" class='btn btn-default btn-xs'>
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
