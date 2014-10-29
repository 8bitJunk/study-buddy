@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-2">
            <h2 class="hidden-xs"><br /></h2>
            <ul class="nav nav-pills nav-stacked global-menu">
                <li>{{ HTML::linkRoute('home', 'Home') }}</li>
                <li class="active"> {{ HTML::linkRoute('moduleIndex', 'Your Modules') }}</li>
            </ul>
        </div>
        <div class="col-sm-8">
            <h2>Your Modules</h2>
                <ul class="list-group">
                    @foreach($user->modules as $module)
                        <li class="list-group-item">
                            {{ HTML::linkRoute('module', $module->module_name, $module->id) }}
                        </li>
                    @endforeach
                </ul>
        </div>
    </div>
@stop
