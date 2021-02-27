<div class="table-responsive">
    <table class="table" id="loanApplications-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Customer</th>
            <th>Loan Account</th>
            <th>Principal</th>
            <th>Rate</th>
            <th>Interest Type</th>
            <th>Tenor</th>
            <th>Status</th>
            <th>Staff</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($loanApplications as $loanApplication)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $loanApplication->company->name }}</td>
                @endif
                <td>{{ $loanApplication->customer->full_name }}</td>
                <td>{{ $loanApplication->loan_account->name }}</td>
                <td>{{ number_format($loanApplication->principal,2) }}</td>
                <td>{{ $loanApplication->rate }}</td>
                <td>{{ str_replace("_"," ",$loanApplication->interest_type) }}</td>
                <td>{{ $loanApplication->tenor }}</td>
                <td>{{ $loanApplication->status }}</td>
                <td>{{ $loanApplication->staff->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['loanApplications.destroy', $loanApplication->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('loanApplications.show', [$loanApplication->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('loanApplications.edit', [$loanApplication->id]) }}"
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
