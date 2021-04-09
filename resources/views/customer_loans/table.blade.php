<div class="table-responsive">
    <table class="table" id="customerLoans-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Loan Application</th>
            <th>Approved</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Narration</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerLoans as $customerLoan)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $customerLoan->company->name }}</td>
                @endif
                <td>{{ $customerLoan->loan_application->pv->pv_id }}</td>
                <td>{{ $customerLoan->staff->name }}</td>
                <td>{{ number_format($customerLoan->amount,2) }}</td>
                <td>{{ $customerLoan->status }}</td>
                <td>{{ $customerLoan->narration }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerLoans.destroy', $customerLoan->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerLoans.show', [$customerLoan->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
{{--                        <a href="{{ route('customerLoans.edit', [$customerLoan->id]) }}" class='btn btn-default btn-xs'>--}}
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
