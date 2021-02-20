<div class="table-responsive">
    <table class="table" id="loanCategories-table">
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
        @foreach($loanCategories as $loanCategory)
            <tr>
                <td>{{ $loanCategory->company_id }}</td>
            <td>{{ $loanCategory->name }}</td>
            <td>{{ $loanCategory->category_id }}</td>
            <td>{{ $loanCategory->slug }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['loanCategories.destroy', $loanCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('loanCategories.show', [$loanCategory->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('loanCategories.edit', [$loanCategory->id]) }}" class='btn btn-default btn-xs'>
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
