<div class="table-responsive" style="padding:5px 5px;">
    <table class="table table-bordered table-hover" id="example">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Payee</th>
            <th>Address</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Pv Ref</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($paymentVouchers as $paymentVoucher)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $paymentVoucher->company->name }}</td>
                @endif
                @php
                    $amount=0;
                    foreach ($paymentVoucher->items as $v){
                    $amount+=$v->amount;
                    }

                @endphp

                <td>{{ $paymentVoucher->payee }}</td>
                <td>{{ $paymentVoucher->address }}</td>
                <td>{{ $paymentVoucher->email }}</td>
                <td>{{ $paymentVoucher->phone }}</td>
                <td>{{ $paymentVoucher->pv_id }}</td>
                <td>{{ number_format($amount,2) }}</td>
                <td>{{ $paymentVoucher->status }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['paymentVouchers.destroy',$account, $paymentVoucher->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('paymentVouchers.show', [$account,$paymentVoucher->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
{{--                        <a href="{{ route('paymentVouchers.edit', [$account,$paymentVoucher->id]) }}"--}}
{{--                           class='btn btn-default btn-xs'>--}}
{{--                            <i class="far fa-edit"></i>--}}
{{--                        </a>--}}
{{--                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
