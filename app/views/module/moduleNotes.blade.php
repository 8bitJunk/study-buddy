<div class="row">
    <div class="col-sm-4">
        <h2>Your Notes</h2>

        <!-- Searchbar -->
        <div class="input-group">
            <input type="text" id="note-search" class="form-control" placeholder="Search tags...">
            <span class="input-group-btn">
                <button class="btn btn-primary" id="note-search-button" type="button"><i class="glyphicon glyphicon-search"></i></button>
            </span>
        </div>

        
        <ul class="list-group" id="note-search-results">
            
        </ul>

        <button id="create-new-button" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-plus"></i> Create New</button>
        <ul class="list-group" id="note-list">
            @foreach ($module->notesForUser() as $note)
                <li class="list-group-item"><a href="#" data-id="{{$note->id}}" class="note-loader"> {{{$note->note_title}}} </a></li>
            @endforeach
        </ul>
    </div>

    <div class="col-sm-8">
        <h2><span id="note-heading">Select Note</span>
            <span class="pull-right">
                <button id="edit-button" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</button>
            </span>
            <button id="delete-button" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Delete</button>
        </h2>
        {{ Form::open(array('method' => 'PUT', 'action' => 'NoteController@update', 'id' => 'note-form')) }}
            {{ Form::input('text', 'noteTitle', '', ['disabled', 'class'=>'form-control', 'id'=>'noteTitle', 'placeholder' => 'Note Title', 'required']) }} <br>
            {{ Form::textarea('noteBody', '', ['disabled', 'class'=>'form-control', 'id'=>'noteBody', 'placeholder' => 'Note Body']) }} <br>
            {{ Form::input('text', 'noteTags', '', ['disabled', 'class'=>'form-control', 'id'=>'noteTags', 'placeholder' => 'Tags...']) }} <br>
            {{ Form::hidden('noteID', '', ['id' => 'noteID']) }}

            <span class="pull-right"><h4>Make public <input type="checkbox" id="isPublic" name="isPublic" value="Public" disabled></h4></span>
            <br />
            {{ Form::submit('Save', array('class' => 'btn btn-lg btn-primary btn-block', 'disabled', 'id' => 'note-save')) }}
        {{ Form::close() }}
        <button id="new-note-save" class="btn btn-primary btn-lg btn-block">Create</button>
    </div>
</div>