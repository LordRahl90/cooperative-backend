<div class="table-responsive">
    <table class="table" id="customerSavings-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Customer</th>
            <th>Savings Account</th>
            <th>Amount</th>
            <th>Narration</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerSavings as $customerSaving)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $customerSaving->company->name }}</td>
                @endif
                <td>{{ $customerSaving->customer_id }}</td>
                <td>{{ $customerSaving->savings_account_id }}</td>
                <td>{{ $customerSaving->amount }}</td>
                <td>{{ $customerSaving->narration }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerSavings.destroy', $customerSaving->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerSavings.show', [$customerSaving->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerSavings.edit', [$customerSaving->id]) }}"
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
