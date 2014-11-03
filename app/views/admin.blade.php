@extends('master')

@section('title')
    Admin
@stop

@section('content')

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Success: </strong> {{ Session::get('success') }}
    </div>
@elseif(Session::has('flash_error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Error: </strong> {{ Session::get('flash_error') }}
    </div>
@endif
<div class="row">
    <div class="col-sm-2">
        <h2 class="hidden-xs"><br /></h2>
        <ul class="nav nav-pills nav-stacked global-menu">
            <li> {{ HTML::linkRoute('home', 'Home') }}</li>
            <li> {{ HTML::linkRoute('moduleIndex', 'Your Modules') }}</li>
        </ul>
    </div>
    <div class="col-sm-4">
        <h2>Add Courses</h2>

    </div>
    <div class="col-sm-4">
        <h2>Add Modules</h2>

    </div>
</div>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <h2>Add User</h2>
        {{ Form::open(array('method' => 'POST', 'action' => 'UserController@store', 'id' => 'admin-user-form')) }}
            {{ Form::input('text', 'name', '', ['class'=>'form-control', 'placeholder' => 'Name', 'required']) }} <br>
            {{ Form::input('text', 'surname', '', ['class'=>'form-control', 'placeholder' => 'Surname', 'required']) }} <br>
            {{ Form::input('text', 'email', '', ['class'=>'form-control', 'placeholder' => 'Email', 'required']) }} <br>
            {{ Form::input('password', 'password', '', ['class'=>'form-control', 'placeholder' => 'Password', 'required']) }} <br>
            {{ Form::select('user_level', ['STUDENT'=>'STUDENT', 'TEACHER'=>'TEACHER', 'ADMIN'=>'ADMIN'], null, ['class'=>'form-control', 'required']) }} <br>
            {{ Form::submit('Add', array('class' => 'btn btn-primary btn-large btn-block', 'id' => 'admin-user-add')) }}
        {{ Form::close() }}
    </div>
</div>
@stop