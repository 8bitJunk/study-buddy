@extends('master')

@section('content')
<div class="row">
    <div class="col-sm-2">
        <h2 class="hidden-xs"><br /></h2>
        <ul class="nav nav-pills nav-stacked global-menu">
            <li>{{ HTML::linkRoute('home', 'Home') }}</li>
            <li> {{ HTML::linkRoute('moduleIndex', 'Your Modules') }}</li>
        </ul>
    </div>
    <div class="col-sm-4">
        <h2>Details</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Name:</strong> {{ $userData['name'] }} {{ $userData['surname'] }} <br />
                <strong>Email:</strong> {{ $userData['email'] }} <br />
                <strong>User Level:</strong> {{ $userData['level'] }} <br />
            </li>
        </ul>
    </div>
    <div class="col-sm-4">
    </div>
</div>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
    </div>
</div>
@stop