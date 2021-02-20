<div class="table-responsive">
    <table class="table" id="customerAddresses-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Customer Id</th>
            <th>Street</th>
            <th>Street2</th>
            <th>State</th>
            <th>Country</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerAddresses as $customerAddress)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $customerAddress->company->name }}</td>
                @endif
                <td>{{ $customerAddress->customer_id }}</td>
                <td>{{ $customerAddress->street }}</td>
                <td>{{ $customerAddress->street2 }}</td>
                <td>{{ $customerAddress->state }}</td>
                <td>{{ $customerAddress->country }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerAddresses.destroy', $customerAddress->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerAddresses.show', [$customerAddress->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerAddresses.edit', [$customerAddress->id]) }}"
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
