<div class="table-responsive">
    <table class="table" id="orgAccountCategories-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Account Type</th>
        <th>Prefix Digit</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orgAccountCategories as $orgAccountCategory)
            <tr>
                <td>{{ $orgAccountCategory->company_id }}</td>
            <td>{{ $orgAccountCategory->name }}</td>
            <td>{{ $orgAccountCategory->slug }}</td>
            <td>{{ $orgAccountCategory->account_type }}</td>
            <td>{{ $orgAccountCategory->prefix_digit }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['orgAccountCategories.destroy', $orgAccountCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('orgAccountCategories.show', [$orgAccountCategory->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('orgAccountCategories.edit', [$orgAccountCategory->id]) }}" class='btn btn-default btn-xs'>
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
