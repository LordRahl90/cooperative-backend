<div class="table-responsive">
    <table class="table" id="payments-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Pv Id</th>
        <th>Reference</th>
        <th>Confirmed By</th>
        <th>Authorized By</th>
        <th>Total Amount</th>
        <th>Debit Account</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->company_id }}</td>
            <td>{{ $payment->pv_id }}</td>
            <td>{{ $payment->reference }}</td>
            <td>{{ $payment->confirmed_by }}</td>
            <td>{{ $payment->authorized_by }}</td>
            <td>{{ $payment->total_amount }}</td>
            <td>{{ $payment->debit_account }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['payments.destroy', $payment->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('payments.show', [$payment->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('payments.edit', [$payment->id]) }}" class='btn btn-default btn-xs'>
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
