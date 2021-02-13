<div class="table-responsive">
    <table class="table" id="staff-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Password</th>
        <th>Role</th>
        <th>Address</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($staff as $staff)
            <tr>
                <td>{{ $staff->company_id }}</td>
            <td>{{ $staff->name }}</td>
            <td>{{ $staff->email }}</td>
            <td>{{ $staff->phone }}</td>
            <td>{{ $staff->password }}</td>
            <td>{{ $staff->role }}</td>
            <td>{{ $staff->address }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['staff.destroy', $staff->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('staff.show', [$staff->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('staff.edit', [$staff->id]) }}" class='btn btn-default btn-xs'>
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
