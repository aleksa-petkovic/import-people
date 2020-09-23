@extends('layouts.master')

@section('content')
<div class="container">
    <section>
        <a href="{{ URL::to('/logout') }}" class="btn btn-md btn-danger">Logout</a>

        @if ($authenticatedUser->inRole('admin'))
            <a href="{{ URL::to('admin') }}" class="btn btn-md btn-info">Admin Panel</a>
        @endif
    </section>
    <hr>
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
