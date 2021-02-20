<div class="table-responsive">
    <table class="table" id="customerNextOfKins-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Customer</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Relationship</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerNextOfKins as $customerNextOfKin)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $customerNextOfKin->company->name }}</td>
                @endif
                <td>{{ $customerNextOfKin->customer_id }}</td>
                <td>{{ $customerNextOfKin->name }}</td>
                <td>{{ $customerNextOfKin->address }}</td>
                <td>{{ $customerNextOfKin->phone }}</td>
                <td>{{ $customerNextOfKin->email }}</td>
                <td>{{ $customerNextOfKin->relationship }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerNextOfKins.destroy', $customerNextOfKin->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerNextOfKins.show', [$customerNextOfKin->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerNextOfKins.edit', [$customerNextOfKin->id]) }}"
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
