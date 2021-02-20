<div class="table-responsive">
    <table class="table" id="customerSavings-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Customer Id</th>
        <th>Savings Account Id</th>
        <th>Amount</th>
        <th>Narration</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($customerSavings as $customerSaving)
            <tr>
                <td>{{ $customerSaving->company_id }}</td>
            <td>{{ $customerSaving->customer_id }}</td>
            <td>{{ $customerSaving->savings_account_id }}</td>
            <td>{{ $customerSaving->amount }}</td>
            <td>{{ $customerSaving->narration }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerSavings.destroy', $customerSaving->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerSavings.show', [$customerSaving->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerSavings.edit', [$customerSaving->id]) }}" class='btn btn-default btn-xs'>
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
