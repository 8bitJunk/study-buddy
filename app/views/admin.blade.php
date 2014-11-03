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
    <div class="col-sm-8">
        <ul class="nav nav-tabs" role="tablist" id="tab-list">
            <li class="active"><a href="#overview" role="tab" data-toggle="tab">Overview</a></li>
            <li><a href="#users" role="tab" data-toggle="tab">Users</a></li>
            <li><a href="#modules" role="tab" data-toggle="tab">Modules</a></li>
            <li><a href="#courses" role="tab" data-toggle="tab">Courses</a></li>
        </ul>
        <br />
        <div class="tab-content">
            <div class="tab-pane active" id="overview">
                @include('admin.adminOverview')
            </div>
            <div class="tab-pane" id="users">
                @include('admin.adminUsers')
            </div>
            <div class="tab-pane" id="modules">
                @include('admin.adminModules')
            </div>
            <div class="tab-pane" id="courses">
                @include('admin.adminCourses')
            </div>
        </div>
    </div>
</div>
@stop