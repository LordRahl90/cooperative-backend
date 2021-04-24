<?php
$role = session('role');
//dd($role);
?>
@if($role==='ADMIN')
    @include("layouts.admin_menu")
@else
    @include("layouts.companies_menu")
@endif

