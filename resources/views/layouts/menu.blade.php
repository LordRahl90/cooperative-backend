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
    <a href="{{ route('companies.index') }}"
       class="nav-link {{ Request::is('companies*') ? 'active' : '' }}">
        <p>Companies</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('orgAccountCategories.index') }}"
       class="nav-link {{ Request::is('orgAccountCategories*') ? 'active' : '' }}">
        <p>Org Account Categories</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('configurations.index') }}"
       class="nav-link {{ Request::is('configurations*') ? 'active' : '' }}">
        <p>Configurations</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('orgAccountHeads.index') }}"
       class="nav-link {{ Request::is('orgAccountHeads*') ? 'active' : '' }}">
        <p>Org Account Heads</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('banks.index') }}"
       class="nav-link {{ Request::is('banks*') ? 'active' : '' }}">
        <p>Banks</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('orgBankAccounts.index') }}"
       class="nav-link {{ Request::is('orgBankAccounts*') ? 'active' : '' }}">
        <p>Org Bank Accounts</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('paymentVouchers.index') }}"
       class="nav-link {{ Request::is('paymentVouchers*') ? 'active' : '' }}">
        <p>Payment Vouchers</p>
    </a>
</li>


{{--<li class="nav-item">--}}
{{--    <a href="{{ route('paymentVoucherDetails.index') }}"--}}
{{--       class="nav-link {{ Request::is('paymentVoucherDetails*') ? 'active' : '' }}">--}}
{{--        <p>Payment Voucher Details</p>--}}
{{--    </a>--}}
{{--</li>--}}


<li class="nav-item">
    <a href="{{ route('payments.index') }}"
       class="nav-link {{ Request::is('payments*') ? 'active' : '' }}">
        <p>Payments</p>
    </a>
</li>

<li class="nav-item">
    <a href="/income/create"
       class="nav-link {{ Request::is('income*') ? 'active' : '' }}">
        <p>Income</p>
    </a>
</li>

<li class="nav-item">
    <a href="/jv/create"
       class="nav-link {{ Request::is('jv*') ? 'active' : '' }}">
        <p>Journal Vouchers</p>
    </a>
</li>


{{--<li class="nav-item">--}}
{{--    <a href="{{ route('transactions.index') }}"--}}
{{--       class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}">--}}
{{--        <p>Transactions</p>--}}
{{--    </a>--}}
{{--</li>--}}


<li class="nav-item">
    <a href="{{ route('users.index') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <p>Users</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('staff.index') }}"
       class="nav-link {{ Request::is('staff*') ? 'active' : '' }}">
        <p>Staff</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('receipts.index') }}"
       class="nav-link {{ Request::is('receipts*') ? 'active' : '' }}">
        <p>Receipts</p>
    </a>
</li>


