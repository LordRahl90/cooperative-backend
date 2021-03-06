<div class="table-responsive">
    <table class="table" id="savingsAccounts-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Savings Category</th>
            <th>Account Head</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($savingsAccounts as $savingsAccount)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $savingsAccount->company->name }}</td>
                @endif
                <td>{{ $savingsAccount->category->name }}</td>
                <td>{{ $savingsAccount->account_head->name }}</td>
                <td>{{ $savingsAccount->name }}</td>
                <td>{{ $savingsAccount->description }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['savingsAccounts.destroy',$account, $savingsAccount->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('savingsAccounts.show', [$account,$savingsAccount->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('savingsAccounts.edit', [$account,$savingsAccount->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {{--                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
