@extends('master')

@section('content')
<div class="row">
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>Success: </strong> {{ Session::get('success') }}
        </div>
    @endif

    <div class="col-sm-2">
    <h2 class="hidden-xs"><br /></h2>
        <ul class="nav nav-pills nav-stacked global-menu">
            <li>{{ HTML::linkRoute('home', 'Home') }}</li>
            <li>{{ HTML::linkRoute('module', 'Your Modules') }}</li>
            <hr>
            <li><a href="#">Module Material</a></li>
            <li><a href="#">Announcements</a></li>
            <li>{{ HTML::linkRoute('moduleNotes', 'Notes', [$module->id]) }}</li>
        </ul>
    </div>
    <div class="col-sm-2">
        <h2>Your Notes</h2>
        <ul class="list-group">
            <li class="list-group-item">{{ HTML::linkRoute('newModuleNote', 'Create New', [$module->id]) }}</li>
            @foreach ($module->notesForUser() as $note)
                <li class="list-group-item">
                    {{ HTML::linkRoute('individualModuleNote',  $note->note_title , [$note->module_id, $note->id]) }}
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-6">
        <h2>Edit Note</h2>
        {{ Form::open(['url' => 'module/'. $module->id .'/note/' . $selectedNote->id . '/update']) }}
            {{ Form::text('noteTitle', $selectedNote->note_title, ['class'=>'form-control']) }} <br>
            {{ Form::textarea('noteBody', $selectedNote->note_body, ['class'=>'form-control']) }} <br>
            {{ Form::text('noteTags', 'Tags...', ['class'=>'form-control']) }} <br>
            {{ Form::submit('Save', ['class' => 'btn btn-lg btn-primary btn-block']) }} <br>
        {{ Form::close() }}

        <span class="pull-right">
            {{ Form::open(['url' => 'module/'. $module->id .'/note/' . $selectedNote->id . '/delete']) }}
                {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-lg', 'onclick' => 'return confirm("Do you really want to permanently delete this note?")'])}}
            {{ Form::close()}}
        </span>
    </div>
</div>
@stop

@section('javascript')
@stop