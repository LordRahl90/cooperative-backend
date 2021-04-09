<?php
?>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>
            Setup
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="{{ route('configurations.index') }}"
               class="nav-link {{ Request::is('configurations*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Balance Sheet Setup</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('orgAccountCategories.index') }}"
               class="nav-link {{ Request::is('orgAccountCategories*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Account Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('orgAccountHeads.index') }}"
               class="nav-link {{ Request::is('orgAccountHeads*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Account Heads</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('orgBankAccounts.index') }}"
               class="nav-link {{ Request::is('orgBankAccounts*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Bank Accounts</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('staff.index') }}"
               class="nav-link {{ Request::is('staff*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Staff</p>
            </a>
        </li>

    </ul>
</li>


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
                <i class="far fa-circle nav-icon"></i>
                <p>Receipts</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('paymentVouchers.index') }}"
               class="nav-link {{ Request::is('paymentVouchers*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Payment Vouchers</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('payments.index') }}"
               class="nav-link {{ Request::is('payments*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Payments</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('journalVouchers.index') }}"
               class="nav-link {{ Request::is('journalVouchers*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Journal Vouchers</p>
            </a>
        </li>
    </ul>
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

        <li class="nav-item">
            <a href="/reverse/payment" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Monthly Payment Schedule</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>
            Customers
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="{{ route('members.index') }}"
               class="nav-link {{ Request::is('members*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Customers</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('customerAddresses.index') }}"
               class="nav-link {{ Request::is('customerAddresses*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer Addresses</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('customerNextOfKins.index') }}"
               class="nav-link {{ Request::is('customerNextOfKins*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer Next Of Kins</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('customerBankAccounts.index') }}"
               class="nav-link {{ Request::is('customerBankAccounts*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer Bank Accounts</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="/customer/upload"
               class="nav-link {{ Request::is('customer/upload') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Upload Customer List</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('customerTransactions.index') }}"
               class="nav-link {{ Request::is('customerTransactions*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer Transactions</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('customerLoanLogs.index') }}"
               class="nav-link {{ Request::is('customerLoanLogs*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer Loan Logs</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('loanGuarators.index') }}"
               class="nav-link {{ Request::is('loanGuarators*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Loan Guarators</p>
            </a>
        </li>

    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>
            Savings
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="{{ route('savingsCategories.index') }}"
               class="nav-link {{ Request::is('savingsCategories*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Savings Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('savingsAccounts.index') }}"
               class="nav-link {{ Request::is('savingsAccounts*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Savings Accounts</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('customerSavings.index') }}"
               class="nav-link {{ Request::is('customerSavings*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer Savings</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="/customer-savings/payment"
               class="nav-link {{ Request::is('customer-savings*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Savings Payment</p>
            </a>
        </li>

    </ul>
</li>


<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>
            Loans
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="{{ route('loanCategories.index') }}"
               class="nav-link {{ Request::is('loanCategories*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Loan Categories</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('loanAccounts.index') }}"
               class="nav-link {{ Request::is('loanAccounts*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Loan Accounts</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('loanApplications.index') }}"
               class="nav-link {{ Request::is('loanApplications*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Loan Applications</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('customerLoans.index') }}"
               class="nav-link {{ Request::is('customerLoans*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer Loans</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('loanRepayments.index') }}"
               class="nav-link {{ Request::is('loanRepayments*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Loan Repayments</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="/repayment/schedule"
               class="nav-link {{ Request::is('customerAddresses*') ? 'active' : '' }}">
                {{--                <i class="far fa-circle nav-icon"></i>--}}
                <p>Download Repayment Schedule</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="/repayment/upload"
               class="nav-link {{ Request::is('customerAddresses*') ? 'active' : '' }}">
                <p>Upload Repayment Schedule</p>
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
            <a href="/reports/bank-report" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Account Statements</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/reports/trial-balance" class="nav-link">
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
