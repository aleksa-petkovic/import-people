@extends('layouts.master')

<?php

$url = URL::action('App\Auth\Http\Controllers\Front\Auth\Controller@login');

?>
@section('content')
    <section class="container">
        <header class="">
            <h1><i class="fa fa-lock icon"></i> {{ trans('login.title') }}</h1>
        </header>

        {!! Form::open(['url' => $url, 'role' => 'form', 'autocomplete' => 'off']) !!}

        {{-- Email address --}}

        <div class="form-group">
            {!! Form::label('email', trans('login.labels.email')) !!}
            {!! Form::email('email', null, ['autofocus', 'class' => 'form-control', 'tabIndex' => 1]) !!}
            <span class="form-group-highlight"></span>
            <span class="form-group-bar"></span>
        </div>

        @if ($errors->has('email'))
            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif

        {{-- Password --}}

        <div class="form-group ">
            {!! Form::label('password', trans('login.labels.password')) !!}
            {!! Form::password('password', ['class' => 'form-control', 'tabIndex' => 2]) !!}
            <span class="form-group-highlight"></span>
            <span class="form-group-bar"></span>
        </div>

        @if ($errors->has('password'))
            <div class="alert alert-danger">{{ $errors->first('password') }}</div>
        @endif

        {{-- Remember me --}}

        <div class="checkbox">
            <label>
                {!! Form::checkbox('remember_me', '1', null, ['tabIndex' => 3]) !!}
                {{ trans('login.labels.rememberMe') }}
            </label>
        </div>

        {{-- Submit button --}}

        <div class="form-group">
            {!!
                Form::button(
                    trans('login.labels.send.default'),
                    [
                        'class' => 'btn btn-lg btn-primary',
                        'tabIndex' => 4,
                        'type' => 'submit',
                        'data-loading-text' => trans('login.labels.send.loading'),
                    ]
                )
            !!}
        </div>

        {!! Form::close() !!}

    </section>
@stop
