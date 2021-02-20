<!-- Company Id Field -->
<div class="col-sm-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{{ $customerAddress->company_id }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-12">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{{ $customerAddress->customer_id }}</p>
</div>

<!-- Street Field -->
<div class="col-sm-12">
    {!! Form::label('street', 'Street:') !!}
    <p>{{ $customerAddress->street }}</p>
</div>

<!-- Street2 Field -->
<div class="col-sm-12">
    {!! Form::label('street2', 'Street2:') !!}
    <p>{{ $customerAddress->street2 }}</p>
</div>

<!-- State Field -->
<div class="col-sm-12">
    {!! Form::label('state', 'State:') !!}
    <p>{{ $customerAddress->state }}</p>
</div>

<!-- Country Field -->
<div class="col-sm-12">
    {!! Form::label('country', 'Country:') !!}
    <p>{{ $customerAddress->country }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerAddress->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customerAddress->updated_at }}</p>
</div>

