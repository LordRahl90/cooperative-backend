<div class="table-responsive">
    <table class="table" id="loanAccounts-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Loan Category Id</th>
        <th>Account Head Id</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Code</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($loanAccounts as $loanAccount)
            <tr>
                <td>{{ $loanAccount->company_id }}</td>
            <td>{{ $loanAccount->loan_category_id }}</td>
            <td>{{ $loanAccount->account_head_id }}</td>
            <td>{{ $loanAccount->name }}</td>
            <td>{{ $loanAccount->slug }}</td>
            <td>{{ $loanAccount->code }}</td>
            <td>{{ $loanAccount->description }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['loanAccounts.destroy', $loanAccount->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('loanAccounts.show', [$loanAccount->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('loanAccounts.edit', [$loanAccount->id]) }}" class='btn btn-default btn-xs'>
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
