<div class="table-responsive">
    <table class="table" id="savingsCategories-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Name</th>
            <th>Account Category</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($savingsCategories as $savingsCategory)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $savingsCategory->company->name }}</td>
                @endif
                <td>{{ $savingsCategory->name }}</td>
                <td>{{ $savingsCategory->category->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['savingsCategories.destroy',$account, $savingsCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('savingsCategories.show', [$account,$savingsCategory->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('savingsCategories.edit', [$account,$savingsCategory->id]) }}"
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
