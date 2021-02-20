<div class="table-responsive">
    <table class="table" id="customers-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Surname</th>
        <th>Othernames</th>
        <th>Reference</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Gender</th>
        <th>Password</th>
        <th>Religion</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->company_id }}</td>
            <td>{{ $customer->surname }}</td>
            <td>{{ $customer->othernames }}</td>
            <td>{{ $customer->reference }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{ $customer->gender }}</td>
            <td>{{ $customer->password }}</td>
            <td>{{ $customer->religion }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['customers.destroy', $customer->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customers.show', [$customer->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customers.edit', [$customer->id]) }}" class='btn btn-default btn-xs'>
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
