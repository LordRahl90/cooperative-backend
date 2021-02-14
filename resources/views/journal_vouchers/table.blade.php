<div class="table-responsive">
    <table class="table" id="journalVouchers-table">
        <thead>
        <tr>
            <th>Company</th>
            <th>Reference</th>
            <th>Narration</th>
            <th>Total Amount</th>
            <th>Created By</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($journalVouchers as $journalVoucher)
            <tr>
                <td>{{ $journalVoucher->company->name }}</td>
                <td>{{ $journalVoucher->reference }}</td>
                <td>{{ $journalVoucher->narration }}</td>
                <td>{{ number_format($journalVoucher->total_amount,2) }}</td>
                <td>{{ $journalVoucher->staff->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['journalVouchers.destroy', $journalVoucher->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('journalVouchers.show', [$journalVoucher->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('journalVouchers.edit', [$journalVoucher->id]) }}"
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
