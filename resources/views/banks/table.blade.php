<div class="table-responsive">
    <table class="table" id="banks-table">
        <thead>
        <tr>
            <th>Country</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Active</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($banks as $bank)
            <tr>
                <td>{{ $bank->country->name }}</td>
                <td>{{ $bank->name }}</td>
                <td>{{ $bank->slug }}</td>
                <td>{{ $bank->active?"Active":"InActive" }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['banks.destroy', $bank->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('banks.show', [$bank->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('banks.edit', [$bank->id]) }}" class='btn btn-default btn-xs'>
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
