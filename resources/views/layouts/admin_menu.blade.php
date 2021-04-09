<?php
?>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            Setup
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">

{{--        <li class="nav-item">--}}
{{--            <a href="{{ route('countries.index') }}"--}}
{{--               class="nav-link {{ Request::is('countries*') ? 'active' : '' }}">--}}
{{--                <p>Countries</p>--}}
{{--            </a>--}}
{{--        </li>--}}

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


{{--        <li class="nav-item">--}}
{{--            <a href="{{ route('states.index') }}"--}}
{{--               class="nav-link {{ Request::is('states*') ? 'active' : '' }}">--}}
{{--                <p>States</p>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('staff.index') }}"
       class="nav-link {{ Request::is('staff*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Staff</p>
    </a>
</li>
