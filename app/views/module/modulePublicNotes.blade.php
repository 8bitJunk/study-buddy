<div class="row">
    <div class="col-sm-12">
        <h2>Public Notes
            <!-- Searchbar -->
            <div class="input-group pull-right col-sm-4">
                <input type="text" id="public-note-search" class="form-control" placeholder="Search titles...">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            </div>
        </h2>
        <div class="public-note-container">
            @foreach ($publicNotes as $publicNote)
                <div class="panel panel-default individual-public-note-container" data-id="{{$publicNote->id}}">
                    <div class="panel-heading public-note-head">
                        {{{$publicNote->note_title}}}
                        <span class="pull-right ">
                            <span class="public-notes-created-time">created: {{$publicNote->created_at->diffForHumans()}}</span>
                            <i class="glyphicon glyphicon-chevron-down public-note-icon"></i>
                        </span>
                    </div>
                    <div class="panel-body public-note-body">
                        <pre>{{{$publicNote->note_body}}}</pre>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>