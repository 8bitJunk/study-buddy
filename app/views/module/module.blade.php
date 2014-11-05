@extends('master')

@section('title')
    {{{$module->module_name}}}
@stop

@section('content')
<div class="row">
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
    
    <div class="col-sm-2">
        <h2 class="hidden-xs"><br /></h2>
        <ul class="nav nav-pills nav-stacked global-menu">
            <li>{{ HTML::linkRoute('home', 'Home') }}</li>
            <li class="active"> {{ HTML::linkRoute('module.index', 'Your Modules') }}</li>
            
        </ul>
    </div>

    <div class="col-sm-8">
        <ul class="nav nav-tabs" role="tablist" id="tab-list">
            <li class="active"><a href="#overview" role="tab" data-toggle="tab">Overview</a></li>
            <li><a href="#announcements" role="tab" data-toggle="tab">Announcements</a></li>
            <li><a href="#materials" role="tab" data-toggle="tab">Materials</a></li>
            <li><a href="#notes" role="tab" data-toggle="tab">Notes</a></li>
            <li><a href="#public-notes" role="tab" data-toggle="tab">Public Notes</a></li>
        </ul>
        <br />
        <div class="tab-content">
            <div class="tab-pane active" id="overview">
                @include('module.moduleOverview')
            </div>
            <div class="tab-pane" id="announcements">
                @include('module.moduleAnnouncements')
            </div>
            <div class="tab-pane" id="materials">
                @include('module.moduleMaterials')
            </div>
            <div class="tab-pane" id="notes">
                @include('module.moduleNotes')
            </div>
            <div class="tab-pane" id="public-notes">
                @include('module.modulePublicNotes')
            </div>
        </div>
    </div>
</div>
@stop