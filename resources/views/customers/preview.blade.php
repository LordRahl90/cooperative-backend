<?php
?>
<div class="col-md-3">
    <fieldset>
        <h3>Basic Information</h3>
        <div class="row">
            <label>Surname: @{{ customer.surname }}</label>
        </div>
        <div class="row">
            <label>Other names: @{{ customer.other_names }}</label>
        </div>
        <div class="row">
            <label>Reference: @{{ customer.reference }}</label>
        </div>
        <div class="row">
            <label>Email: @{{ customer.email }}</label>
        </div>
        <div class="row">
            <label>Phone: @{{ customer.phone }}</label>
        </div>
        <div class="row">
            <label>Gender: @{{ customer.gender }}</label>
        </div>
        <div class="row">
            <label>Religion: @{{ customer.religion }}</label>
        </div>
        <div class="row">
            <label>Date of Birth: @{{ customer.dob }}</label>
        </div>
    </fieldset>
</div>

<div class="col-md-3">
    <fieldset>
        <legend>Address Information</legend>
        <div class="row">
            <label>Street: @{{ address.street }}</label>
        </div>
        <div class="row">
            <label>Street2: @{{ address.street2 }}</label>
        </div>
        <div class="row">
            <label>Country: @{{ address.country }}</label>
        </div>
        <div class="row">
            <label>State: @{{ address.state }}</label>
        </div>
    </fieldset>

</div>

<div class="col-md-3">
    <fieldset>
        <legend>Next-of-Kin Information</legend>

        <div class="row">
            <label>Full name: @{{ nok.name }}</label>
        </div>
        <div class="row">
            <label>Address: @{{ nok.address }}</label>
        </div>
        <div class="row">
            <label>Phone: @{{ nok.phone }}</label>
        </div>
        <div class="row">
            <label>Email: @{{ nok.email }}</label>
        </div>
        <div class="row">
            <label>Relationship: @{{ nok.relationship }}</label>
        </div>
    </fieldset>
</div>

<div class="col-md-3">
    <fieldset>
        <legend>Bank Information</legend>
        <div class="row">
            <label>Account Name: @{{ bank.account_name }}</label>
        </div>
        <div class="row">
            <label>Account Number: @{{ bank.account_number }}</label>
        </div>
        <div class="row">
            <label>Sort code: @{{ bank.sort_code }}</label>
        </div>
    </fieldset>
</div>
