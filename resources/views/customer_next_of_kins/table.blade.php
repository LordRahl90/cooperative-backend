<div class="table-responsive">
    <table class="table" id="customerNextOfKins-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Customer Id</th>
        <th>Name</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Relationship</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($customerNextOfKins as $customerNextOfKin)
            <tr>
                <td>{{ $customerNextOfKin->company_id }}</td>
            <td>{{ $customerNextOfKin->customer_id }}</td>
            <td>{{ $customerNextOfKin->name }}</td>
            <td>{{ $customerNextOfKin->address }}</td>
            <td>{{ $customerNextOfKin->phone }}</td>
            <td>{{ $customerNextOfKin->email }}</td>
            <td>{{ $customerNextOfKin->relationship }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerNextOfKins.destroy', $customerNextOfKin->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerNextOfKins.show', [$customerNextOfKin->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerNextOfKins.edit', [$customerNextOfKin->id]) }}" class='btn btn-default btn-xs'>
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
