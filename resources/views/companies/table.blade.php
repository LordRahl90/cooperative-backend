<div class="table-responsive">
    <table class="table" id="companies-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Country</th>
            <th>Logo</th>
            <th>Slogan</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Website</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($companies as $company)
            <tr>
                <td>{{ $company->name }}</td>
                <td>{{ $company->country->name }}</td>
                <td>{{ $company->logo }}</td>
                <td>{{ $company->slogan }}</td>
                <td>{{ $company->email }}</td>
                <td>{{ $company->phone }}</td>
                <td>{{ $company->website }}</td>
                <td>{{ $company->address }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['companies.destroy', $company->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('companies.show', [$company->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('companies.edit', [$company->id]) }}" class='btn btn-default btn-xs'>
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
