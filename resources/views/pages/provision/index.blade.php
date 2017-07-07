@extends('layouts.master')

@section('title', 'Provision User')

@section('description')
    Provisions a new user in the Google Apps system
@endsection

@section('content')
    <p>This will provision a new user and then send out the emails specified in the database.</p>

    {!! Form::open() !!}

        {!! Form::label('first_name', 'First Name') !!}
        {!! Form::text('first_name') !!}

        {!! Form::label('last_name', 'Last Name') !!}
        {!! Form::text('last_name') !!}

        {!! Form::label('org_email', 'New Email Address within the Organization') !!}
        {!! Form::text('org_email', null, ['placeholder' => 'first.last@organization.com']) !!}

        {!! Form::label('ext_email', 'Existing External Email Address') !!}
        {!! Form::text('ext_email', null, ['placeholder' => 'someaccount@external.com']) !!}

        {!! Form::label('org_unit', 'Organizational Unit') !!}
        {!! Form::select('org_unit', $orgUnits, null) !!}

        <br />
        {!! Form::submit('Provision User') !!}

    {!! Form::close() !!}
@endsection