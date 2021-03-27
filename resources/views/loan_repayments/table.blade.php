<div class="table-responsive">
    <table class="table" id="loanRepayments-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Loan</th>
            <th>Customer</th>
            <th>Loan Application</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($loanRepayments as $loanRepayment)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $loanRepayment->company->name }}</td>
                @endif
                <td>{{ $loanRepayment->loan_application->loan_account->name }}</td>
                <td>{{ $loanRepayment->customer->full_name }}</td>
                <td>{{ $loanRepayment->loan_application->pv->pv_id }}</td>

                <td>{{ number_format(($loanRepayment->principal+$loanRepayment->interest),2) }}</td>

                <td width="120">
                    {!! Form::open(['route' => ['loanRepayments.destroy', $loanRepayment->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('loanRepayments.show', [$loanRepayment->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('loanRepayments.edit', [$loanRepayment->id]) }}"
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
