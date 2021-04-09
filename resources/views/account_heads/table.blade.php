<div class="table-responsive">
    <table class="table" id="accountHeads-table">
        <thead>
        <tr>
            <th>Category</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Code</th>
            <th>Active</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($accountHeads as $accountHead)
            <tr>
                <td>{{ $accountHead->category->name }}</td>
                <td>{{ $accountHead->name }}</td>
                <td>{{ $accountHead->slug }}</td>
                <td>{{ $accountHead->code }}</td>
                <td>{{ $accountHead->active?"Active":"InActive" }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['accountHeads.destroy', $accountHead->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('accountHeads.show', [$accountHead->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('accountHeads.edit', [$accountHead->id]) }}" class='btn btn-default btn-xs'>
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
