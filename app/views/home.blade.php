@extends('master')

@section('title')
    Home
@stop

@section('content')
@if(Session::has('flash_error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Error!</strong> {{ Session::get('flash_error') }}
    </div>
@endif
<div class="row">
    <div class="col-sm-2">
        <h2 class="hidden-xs"><br /></h2>
        <ul class="nav nav-pills nav-stacked global-menu">
            <li class="active">{{ HTML::linkRoute('home', 'Home') }}</li>
            <li> {{ HTML::linkRoute('module.index', 'Your Modules') }}</li>
        </ul>
    </div>
    <div class="col-sm-4">
        <h2>Recently Added Modules</h2>
        <ul class="list-group" id="module-list">
            @foreach($user->modules->take(4) as $module)
                <li class="list-group-item">
                    {{ HTML::linkRoute('module', $module->module_name, $module->id) }}
                </li>
            @endforeach
            <li class="list-group-item">
                {{ HTML::linkRoute('module.index', 'Show All...') }}
            </li>
        </ul>
    </div>
    <div class="col-sm-4">
        <h2>Announcements</h2>
        <ul class="list-group">
            @foreach($announcements as $announcement)
                <li class="list-group-item">
                    <h class="list-group-heading">
                        <strong>{{{ Module::find($announcement->module_id)->module_name }}} </strong>
                    </p>

                    <p class="list-group-item-text">{{{ $announcement->announcement_body }}}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <h2>Words of Wisdom</h2>
        <?php
            $f_contents = file(public_path() . "/quotes.txt");
            $line = $f_contents[array_rand($f_contents)];
            echo('<span id="quote-of-the-day">
                    <i class="fa fa-quote-left fa-2x" id="left-quote"></i>
                    <br />
                    <p>' . htmlentities($line) . '</p>
                    <i class="fa fa-quote-right fa-2x" id="right-quote"></i>
                </span>');
         ?>
    </div>
</div>
@stop