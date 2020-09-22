@extends('layouts.master')

<?php

$url = URL::action('App\Auth\Http\Controllers\Front\Auth\Controller@register');

?>
@section('content')
    <section class="container">
        <header class="">
            <h1><i class="fa fa-lock icon"></i> {{ trans('register.title') }}</h1>
        </header>

        {!! Form::open(['url' => $url, 'role' => 'form', 'autocomplete' => 'off']) !!}

        {{-- Email address --}}

        <div class="form-group">
            {!! Form::label('email', trans('register.labels.email')) !!}
            {!! Form::email('email', null, ['autofocus', 'class' => 'form-control', 'required']) !!}
            <span class="form-group-highlight"></span>
            <span class="form-group-bar"></span>
        </div>

        @if ($errors->has('email'))
            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif


        {{-- First name --}}

        <div class="form-group">
            {!! Form::label('first_name', trans('register.labels.firstName'), ['class' => 'c-inputLabel']) !!}
            <div class="input-group">
                {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
            </div>

            @if ($errors->has('first_name'))
                <p class="alert alert-danger">{{ $errors->first('first_name') }}</p>
            @endif
        </div>


        {{-- Last name --}}

        <div class="form-group">
            {!! Form::label('last_name', trans('register.labels.lastName'), ['class' => 'c-inputLabel']) !!}
            <div class="input-group">
                {!! Form::text('last_name', null, ['class' => 'form-control', 'required']) !!}
            </div>

            @if ($errors->has('last_name'))
                <p class="alert alert-danger">{{ $errors->first('last_name') }}</p>
            @endif
        </div>


        {{-- Password --}}

        <div class="form-group ">
            {!! Form::label('password', trans('register.labels.password'), ['class' => 'c-inputLabel']) !!}
            {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
            <span class="form-group-highlight"></span>
            <span class="form-group-bar"></span>
        </div>

        @if ($errors->has('password'))
            <div class="alert alert-danger">{{ $errors->first('password') }}</div>
        @endif


        {{-- Confirm Password --}}

        <div class="form-group ">
            {!! Form::label('password_confirmation', trans('register.labels.confirmPassword'), ['class' => 'c-inputLabel']) !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
            <span class="form-group-highlight"></span>
            <span class="form-group-bar"></span>
        </div>

        @if ($errors->has('password_confirmation'))
            <div class="alert alert-danger">{{ $errors->first('password_confirmation') }}</div>
        @endif


        {{-- Submit button --}}

        <div class="form-group">
            {!!
                Form::button(
                    trans('register.labels.send.default'),
                    [
                        'class' => 'btn btn-lg btn-primary',
                        'tabIndex' => 4,
                        'type' => 'submit',
                        'data-loading-text' => trans('register.labels.send.loading'),
                    ]
                )
            !!}
        </div>

        {!! Form::close() !!}

    </section>
@stop
