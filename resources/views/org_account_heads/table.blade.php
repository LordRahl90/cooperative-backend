<div class="table-responsive">
    <table class="table" id="orgAccountHeads-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Category</th>
            <th>Name</th>
{{--            <th>Slug</th>--}}
            <th>Code</th>
            <th>Active</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orgAccountHeads as $orgAccountHead)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $configuration->company->name }}</td>
                @endif
                <td>{{ $orgAccountHead->category->name }}</td>
                <td>{{ $orgAccountHead->name }}</td>
{{--                <td>{{ $orgAccountHead->slug }}</td>--}}
                <td>{{ $orgAccountHead->code }}</td>
                <td>{{ $orgAccountHead->active?"Active":"InActive" }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['orgAccountHeads.destroy', $orgAccountHead->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('orgAccountHeads.show', [$orgAccountHead->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('orgAccountHeads.edit', [$orgAccountHead->id]) }}"
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
