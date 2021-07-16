<div class="table-responsive" style="padding:5px 5px;">
    <table class="table table-bordered table-hover" id="example">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Name</th>
            {{--                <th>Slug</th>--}}
            <th>Account Type</th>
            <th>Prefix Digit</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orgAccountCategories as $orgAccountCategory)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $configuration->company->name }}</td>
                @endif
                <td>{{ $orgAccountCategory->name }}</td>
                {{--                <td>{{ $orgAccountCategory->slug }}</td>--}}
                <td>{{ $orgAccountCategory->account_type }}</td>
                <td>{{ $orgAccountCategory->prefix_digit }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['orgAccountCategories.destroy',$account, $orgAccountCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('orgAccountCategories.show', [$account, $orgAccountCategory->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('orgAccountCategories.edit', [$account, $orgAccountCategory->id]) }}"
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
