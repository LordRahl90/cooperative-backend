<div class="table-responsive">
    <table class="table" id="payments-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Payee</th>
            <th>Reference</th>
            <th>Confirmed By</th>
            <th>Authorized By</th>
            <th>Total Amount</th>
            <th>Bank Account</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $payment->company->name }}</td>
                @endif
                <td>{{ $payment->pv->payee }}</td>
                <td>{{ $payment->reference }}</td>
                <td>{{ $payment->confirmed->name }}</td>
                <td>{{ $payment->authorized->name }}</td>
                <td>{{ number_format($payment->total_amount,2) }}</td>
                <td>{{ $payment->bankAccount->account_name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['payments.destroy', $payment->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('payments.show', [$payment->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('payments.edit', [$payment->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
{{--                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
