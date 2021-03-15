<div class="table-responsive">
    <table class="table" id="loanGuarators-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Customer Id</th>
        <th>Loan Id</th>
        <th>Guarantor</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($loanGuarators as $loanGuarator)
            <tr>
                <td>{{ $loanGuarator->company_id }}</td>
            <td>{{ $loanGuarator->customer_id }}</td>
            <td>{{ $loanGuarator->loan_id }}</td>
            <td>{{ $loanGuarator->guarantor }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['loanGuarators.destroy', $loanGuarator->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('loanGuarators.show', [$loanGuarator->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('loanGuarators.edit', [$loanGuarator->id]) }}" class='btn btn-default btn-xs'>
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
