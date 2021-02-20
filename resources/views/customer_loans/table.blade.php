<div class="table-responsive">
    <table class="table" id="customerLoans-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Loan Application Id</th>
        <th>Approved By</th>
        <th>Status</th>
        <th>Total Repaid</th>
        <th>Narration</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($customerLoans as $customerLoan)
            <tr>
                <td>{{ $customerLoan->company_id }}</td>
            <td>{{ $customerLoan->loan_application_id }}</td>
            <td>{{ $customerLoan->approved_by }}</td>
            <td>{{ $customerLoan->status }}</td>
            <td>{{ $customerLoan->total_repaid }}</td>
            <td>{{ $customerLoan->narration }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerLoans.destroy', $customerLoan->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerLoans.show', [$customerLoan->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerLoans.edit', [$customerLoan->id]) }}" class='btn btn-default btn-xs'>
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
