<div class="table-responsive">
    <table class="table" id="feeManagements-table">
        <thead>
        <tr>
            @if(session('company_id')==0)
                <th>Company</th>
            @endif
            <th>Name</th>
            <th>Description</th>
            {{--            <th>Duration</th>--}}
            <th>Deadline</th>
            <th>Amount</th>
            <th>Account Head</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($feeManagements as $feeManagement)
            <tr>
                @if(session('company_id')==0)
                    <td>{{ $feeManagement->company_id }}</td>
                @endif
                <td>{{ $feeManagement->name }}</td>
                <td>{{ $feeManagement->description }}</td>
                {{--                <td>{{ $feeManagement->duration }}</td>--}}
                <td>{{ $feeManagement->deadline->format('Y-m-d') }}</td>
                <td>{{ number_format($feeManagement->amount,2) }}</td>
                <td>{{ $feeManagement->account_head->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['feeManagements.destroy',$account, $feeManagement->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('feeManagements.show', [$account,$feeManagement->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('feeManagements.edit', [$account,$feeManagement->id]) }}"
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
