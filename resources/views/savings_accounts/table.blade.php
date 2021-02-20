<div class="table-responsive">
    <table class="table" id="savingsAccounts-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Savings Category Id</th>
        <th>Account Head Id</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($savingsAccounts as $savingsAccount)
            <tr>
                <td>{{ $savingsAccount->company_id }}</td>
            <td>{{ $savingsAccount->savings_category_id }}</td>
            <td>{{ $savingsAccount->account_head_id }}</td>
            <td>{{ $savingsAccount->name }}</td>
            <td>{{ $savingsAccount->slug }}</td>
            <td>{{ $savingsAccount->description }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['savingsAccounts.destroy', $savingsAccount->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('savingsAccounts.show', [$savingsAccount->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('savingsAccounts.edit', [$savingsAccount->id]) }}" class='btn btn-default btn-xs'>
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
