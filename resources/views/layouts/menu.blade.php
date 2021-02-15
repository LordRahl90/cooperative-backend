<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            Setup
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="{{ route('countries.index') }}"
               class="nav-link {{ Request::is('countries*') ? 'active' : '' }}">
                <p>Countries</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('accountCategories.index') }}"
               class="nav-link {{ Request::is('accountCategories*') ? 'active' : '' }}">
                <p>Account Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('accountHeads.index') }}"
               class="nav-link {{ Request::is('accountHeads*') ? 'active' : '' }}">
                <p>Account Heads</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('banks.index') }}"
               class="nav-link {{ Request::is('banks*') ? 'active' : '' }}">
                <p>Banks</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('companies.index') }}"
               class="nav-link {{ Request::is('companies*') ? 'active' : '' }}">
                <p>Companies</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('users.index') }}"
               class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                <p>Users</p>
            </a>
        </li>

    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('configurations.index') }}"
       class="nav-link {{ Request::is('configurations*') ? 'active' : '' }}">
        <p>Configurations</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('orgAccountCategories.index') }}"
       class="nav-link {{ Request::is('orgAccountCategories*') ? 'active' : '' }}">
        <p>Account Categories</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('orgAccountHeads.index') }}"
       class="nav-link {{ Request::is('orgAccountHeads*') ? 'active' : '' }}">
        <p>Account Heads</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('orgBankAccounts.index') }}"
       class="nav-link {{ Request::is('orgBankAccounts*') ? 'active' : '' }}">
        <p>Bank Accounts</p>
    </a>
</li>


{{--<li class="nav-item">--}}
{{--    <a href="{{ route('paymentVoucherDetails.index') }}"--}}
{{--       class="nav-link {{ Request::is('paymentVoucherDetails*') ? 'active' : '' }}">--}}
{{--        <p>Payment Voucher Details</p>--}}
{{--    </a>--}}
{{--</li>--}}


<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            Postings
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        {{--        <li class="nav-item">--}}
        {{--            <a href="/income/create"--}}
        {{--               class="nav-link {{ Request::is('income*') ? 'active' : '' }}">--}}
        {{--                <p>Income</p>--}}
        {{--            </a>--}}
        {{--        </li>--}}

        <li class="nav-item">
            <a href="{{ route('receipts.index') }}"
               class="nav-link {{ Request::is('receipts*') ? 'active' : '' }}">
                <p>Receipts</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('paymentVouchers.index') }}"
               class="nav-link {{ Request::is('paymentVouchers*') ? 'active' : '' }}">
                <p>Payment Vouchers</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('payments.index') }}"
               class="nav-link {{ Request::is('payments*') ? 'active' : '' }}">
                <p>Payments</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('journalVouchers.index') }}"
               class="nav-link {{ Request::is('journalVouchers*') ? 'active' : '' }}">
                <p>Journal Vouchers</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('staff.index') }}"
       class="nav-link {{ Request::is('staff*') ? 'active' : '' }}">
        <p>Staff</p>
    </a>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>
            Operations
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="/reprints/receipt" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reprint Receipt</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/reprints/pv" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reprint PV</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/reprints/jv" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reprint JV</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/reverse/receipt" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reverse Receipt</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="/reverse/payment" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reverse Payment</p>
            </a>
        </li>
    </ul>
</li>


<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>
            Reports
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="/reports/general-ledger" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>General Ledger</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Account Statements</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Trial Balance</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Income/Expense Statement</p>
            </a>
        </li>
    </ul>
</li>
