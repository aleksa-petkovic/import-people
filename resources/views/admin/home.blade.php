@extends('layouts.master')

<?php

$url = URL::action('App\People\Http\Controllers\Admin\People\Controller@importPeople');

?>

@section('content')
<div class="container">
    <section>
        <h1>Admin</h1>
    </section>

    <section>
        {!! Form::open(['url' => $url, 'files' => true]) !!}

        {{-- Import File --}}

        <div class="form-group">
            {!! Form::label('import_file', trans('admin/people.labels.importFile')) !!}
            {!! Form::file('import_file', ['class' => 'form-control']) !!}
        </div>

        @if ($errors->has('import_file'))
            <div class="alert alert-danger">{{ $errors->first('import_file') }}</div>
        @endif

        {{-- Submit button --}}

        <div class="form-group">
            {!!
                Form::button(
                    trans('admin/people.labels.send.default'),
                    [
                        'class' => 'btn btn-md btn-primary',
                        'type' => 'submit',
                        'data-loading-text' => trans('admin/people.labels.send.loading'),
                    ]
                )
            !!}
        </div>

        {!! Form::close() !!}
    </section>

    <section>
        @if ($people->count())
        <table class="table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birthday</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($people as $person)
                    <tr>
                        <td>{{ $person->first_name }}</td>
                        <td>{{ $person->last_name }}</td>
                        <td>{{ $person->birthday }}</td>
                        <td>{{ $person->gender->title }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="alert alert-info">Please import some people.</div>
        @endif
    </section>
</div>

@stop
