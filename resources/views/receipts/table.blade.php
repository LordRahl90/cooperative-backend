<div class="table-responsive">
    <table class="table" id="receipts-table">
        <thead>
        <tr>
            <th>Company</th>
            <th>Reference</th>
            <th>Payer</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($receipts as $receipt)
            <tr>
                <td>{{ $receipt->company->name }}</td>
                <td>{{ $receipt->reference }}</td>
                <td>{{ $receipt->payer }}</td>
                <td>{{ $receipt->phone }}</td>
                <td>{{ $receipt->email }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['receipts.destroy', $receipt->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('receipts.show', [$receipt->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('receipts.edit', [$receipt->id]) }}" class='btn btn-default btn-xs'>
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
