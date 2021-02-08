<div class="table-responsive">
    <table class="table" id="configurations-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Income Category</th>
        <th>Expense Category</th>
        <th>Cash Account Categories</th>
        <th>Fixed Asset Categories</th>
        <th>Current Assets Category</th>
        <th>Account Payable Category</th>
        <th>Account Recieveable Category</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($configurations as $configuration)
            <tr>
                <td>{{ $configuration->company_id }}</td>
            <td>{{ $configuration->income_category }}</td>
            <td>{{ $configuration->expense_category }}</td>
            <td>{{ $configuration->cash_account_categories }}</td>
            <td>{{ $configuration->fixed_asset_categories }}</td>
            <td>{{ $configuration->current_assets_category }}</td>
            <td>{{ $configuration->account_payable_category }}</td>
            <td>{{ $configuration->account_recieveable_category }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['configurations.destroy', $configuration->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('configurations.show', [$configuration->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('configurations.edit', [$configuration->id]) }}" class='btn btn-default btn-xs'>
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
