<div class="table-responsive">
    <table class="table" id="savingsCategories-table">
        <thead>
            <tr>
                <th>Company Id</th>
        <th>Name</th>
        <th>Category Id</th>
        <th>Slug</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($savingsCategories as $savingsCategory)
            <tr>
                <td>{{ $savingsCategory->company_id }}</td>
            <td>{{ $savingsCategory->name }}</td>
            <td>{{ $savingsCategory->category_id }}</td>
            <td>{{ $savingsCategory->slug }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['savingsCategories.destroy', $savingsCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('savingsCategories.show', [$savingsCategory->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('savingsCategories.edit', [$savingsCategory->id]) }}" class='btn btn-default btn-xs'>
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
