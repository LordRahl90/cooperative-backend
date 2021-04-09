<div class="table-responsive">
    <table class="table" id="paymentVoucherDetails-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Pv Id</th>
        <th>Account Head Id</th>
        <th>Amount</th>
        <th>Narration</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($paymentVoucherDetails as $paymentVoucherDetails)
            <tr>
                <td>{{ $paymentVoucherDetails->company_id }}</td>
            <td>{{ $paymentVoucherDetails->pv_id }}</td>
            <td>{{ $paymentVoucherDetails->account_head_id }}</td>
            <td>{{ $paymentVoucherDetails->amount }}</td>
            <td>{{ $paymentVoucherDetails->narration }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['paymentVoucherDetails.destroy', $paymentVoucherDetails->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('paymentVoucherDetails.show', [$paymentVoucherDetails->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('paymentVoucherDetails.edit', [$paymentVoucherDetails->id]) }}" class='btn btn-default btn-xs'>
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
