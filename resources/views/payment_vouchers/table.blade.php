<div class="table-responsive">
    <table class="table" id="paymentVouchers-table">
        <thead>
        <tr>
            <th>Company</th>
            <th>Payee</th>
            <th>Address</th>
            <th>Email</th>
            <th>Website</th>
            <th>Phone</th>
            <th>Pv Ref</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($paymentVouchers as $paymentVoucher)
            <tr>
                <td>{{ $paymentVoucher->company->name }}</td>
                <td>{{ $paymentVoucher->payee }}</td>
                <td>{{ $paymentVoucher->address }}</td>
                <td>{{ $paymentVoucher->email }}</td>
                <td>{{ $paymentVoucher->website }}</td>
                <td>{{ $paymentVoucher->phone }}</td>
                <td>{{ $paymentVoucher->pv_id }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['paymentVouchers.destroy', $paymentVoucher->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('paymentVouchers.show', [$paymentVoucher->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('paymentVouchers.edit', [$paymentVoucher->id]) }}"
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
