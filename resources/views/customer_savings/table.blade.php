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
                <td>{{ $customerSaving->customer->full_name }}</td>
                <td>{{ $customerSaving->savings->name }}</td>
                <td>{{ number_format($customerSaving->amount,2) }}</td>
                <td>{{ $customerSaving->narration }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerSavings.destroy',$account, $customerSaving->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerSavings.show', [$account,$customerSaving->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerSavings.edit', [$account,$customerSaving->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
{{--                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
