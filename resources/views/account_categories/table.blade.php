<div class="table-responsive">
    <table class="table" id="accountCategories-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Prefix Digit</th>
        <th>Account Type</th>
        <th>Slug</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($accountCategories as $accountCategory)
            <tr>
                <td>{{ $accountCategory->name }}</td>
            <td>{{ $accountCategory->prefix_digit }}</td>
            <td>{{ $accountCategory->account_type }}</td>
            <td>{{ $accountCategory->slug }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['accountCategories.destroy', $accountCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('accountCategories.show', [$accountCategory->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('accountCategories.edit', [$accountCategory->id]) }}" class='btn btn-default btn-xs'>
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
