<div class="row">
    <div class="col-sm-6">
        <div class="dragdrop">
            <h2>Module Information
                <span class="pull-right">
                    @if(Auth::user()->user_level == "TEACHER")
                        @include('module.modals.changeModuleInfoModal')
                    @endif
                </span>
            </h2>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{{ $module->module_name }}}</h3>
                </div>
                <div class="panel-body">
                    {{{ $module->module_description }}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="dragdrop">
            <h2>Teacher Information</h2>
            @foreach($teachersInformation as $teacherInformation)
                <li class="list-group-item">
                <i class="glyphicon glyphicon-user"></i> {{{ $teacherInformation->name }}} {{{ $teacherInformation->surname }}} <br>
                <i class="glyphicon glyphicon-envelope"></i> {{ HTML::mailto($teacherInformation->email, $teacherInformation->email) }}
                </li>
            @endforeach
        </div>
    </div>
</div>

@section('javascript')
    {{ HTML::script('js/jquery-ui.js') }}
    <script>
        $(function() {
            // hides the delete button on the note edit form because chris said to.
            $('#delete-button').hide();
            $('#new-note-save').hide();
            $('#edit-button').hide();

            // public note collapse note body on load
            $('.public-note-body').hide();


            // dragable, swapable divs
            jQuery.fn.swap = function(b){ 
                // method from: http://blog.pengoworks.com/index.cfm/2008/9/24/A-quick-and-dirty-swap-method-for-jQuery
                b = jQuery(b)[0]; 
                var a = this[0]; 
                var t = a.parentNode.insertBefore(document.createTextNode(''), a); 
                b.parentNode.insertBefore(a, b); 
                t.parentNode.insertBefore(b, t); 
                t.parentNode.removeChild(t); 
                return this; 
            };


            $( ".dragdrop" ).draggable({ revert: true, helper: "clone" });

            $( ".dragdrop" ).droppable({
                accept: ".dragdrop",
                activeClass: "ui-state-hover",
                hoverClass: "ui-state-active",
                drop: function( event, ui ) {

                    var draggable = ui.draggable, droppable = $(this);
                    var dragPos = draggable.position(), dropPos = droppable.position();
                    
                    draggable.css({
                        left: dropPos.left+'px',
                        top: dropPos.top+'px'
                    });

                    droppable.css({
                        left: dragPos.left+'px',
                        top: dragPos.top+'px'
                    });
                    draggable.swap(droppable);
                }
            });

            window.routeLink = "{{{ URL::route('note.json') }}}";

            // ajax for notes
            $('#note-list, #note-search-results').on('click', '.note-loader', function(e) {
                e.preventDefault();
                var noteID = $(this).data('id');
                var url = decodeURI("{{ URL::route('note.json') }}");

                $this = $(this);
                // now insert the note ID
                url = url.replace('{id}', noteID);

                $.get(url, function(json) {
                    $('#noteTitle').val(json.note_title);
                    $('#noteBody').val(json.note_body);
                    $('#noteTags').val(json.note_tags);
                    $('#noteID').val(json.id);
                    if (json.is_public) {
                        $('#isPublic').prop('checked', true);
                    } else {
                        $('#isPublic').prop('checked', false);
                    }

                    // disable fields
                    $('#note-form input[name = "noteTitle"]').prop('disabled', true);
                    $('#note-form textarea[name = "noteBody"]').prop('disabled', true);
                    $('#note-form input[name = "noteTags"]').prop('disabled', true);
                    $('#note-form input[name = "isPublic"]').attr('disabled', true);
                    $('#note-save').prop('disabled', true);

                    // change button from delete to edit
                    $('#delete-button').hide();
                    $('#edit-button').show();
                    $('#note-heading').text('Edit Note');
                })
                .error(function () {
                    console.log('error');
                });
            });

            // saves the note and disables editing
            $('#note-save').click(function(e){
                e.preventDefault();

                var noteID = $('#noteID').val();
                var url = decodeURI("{{ URL::route('note.update') }}");
                var $this = $(this);

                // now insert the note ID
                url = url.replace('{id}', noteID);

                // console.log(url);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        note_title: $('#noteTitle').val(), 
                        note_body: $('#noteBody').val(),
                        note_tags: $('#noteTags').val(),
                        is_public: $('#isPublic').is(':checked') ? 1 : 0
                    },

                    //console.log(data);
                    success: function (json) {
                        // update note list title
                        $('a[data-id = "' + json['id'] + '"]').text(json['note_title']);

                        // then make the form uneditable
                        $this
                            .parents('form')
                            .find(':input')
                            .attr('disabled', true);


                        // change delete button for edit button
                        $('#edit-button').show();
                        $('#delete-button').hide();
                        $('#note-heading').text('Edit Note');

                        // if it is public add it to public note list
                        if (json.is_public) {
                            var $newElem = ' \
                                <div class="panel panel-default"> \
                                    <div class="panel-heading public-note-head"> \
                                        ' + json.note_title +' \
                                        <i class="glyphicon glyphicon-chevron-down pull-right"></i> \
                                    </div> \
                                    <div class="panel-body public-note-body"> \
                                        <pre>' + json.note_body + '</pre> \
                                    </div> \
                                </div> \
                            ';
                            $($newElem).prependTo('.public-note-container');
                            $('.public-note-body').hide();
                        }
                    }
                });
            });

            $('#edit-button').click(function () {
                $('#note-form input[name = "noteTitle"]').removeAttr('disabled').focus();
                $('#note-form textarea[name = "noteBody"]').removeAttr('disabled');
                $('#note-form input[name = "noteTags"]').removeAttr('disabled');
                $('#note-form input[name = "isPublic"]').removeAttr('disabled');
                $('#note-save').removeAttr('disabled');

                // unhide the delete button and hide this button
                $(this).hide();
                $('#delete-button').show();
                $('#note-heading').text('Edit Note');
            });

            $('#create-new-button').click(function () {
                $('.note-form :input').val('')
                    .removeAttr('disabled');
                $('#note-form input[name = "noteTitle"]').removeAttr('disabled').focus().val('');
                $('#note-form textarea[name = "noteBody"]').removeAttr('disabled').val('');
                $('#note-form input[name = "noteTags"]').removeAttr('disabled').val('');
                $('#note-form input[name = "isPublic"]').removeAttr('disabled').prop('checked', false);
                $('#note-save').hide();
                $('#new-note-save').show();
                $('#edit-button').hide();
                $('#note-heading').text('New Note');
            });

            // save a new note
            $('#new-note-save').click(function(e) {
                e.preventDefault();

                var url = decodeURI("{{ URL::route('note.store') }}");
                var $this = $(this);

                var moduleID = {{$module->id}};
                var userID = {{Auth::user()->id}};
                // now insert the note ID
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        note_title: $('#noteTitle').val(), 
                        note_body: $('#noteBody').val(),
                        note_tags: $('#noteTags').val(),
                        is_public: $('#isPublic').is(':checked') ? 1 : 0,
                        module_id: moduleID,
                        user_id: userID
                    },

                    success: function (json) {
                        // update the parent form elements based on the json
                        // then make the form uneditable
                        $this
                            .parents('form')
                            .find(':input')
                            .attr('disabled', true);

                        // add new item to list
                        var $newLink = $('<li class="list-group-item"><a href="#" data-id="'+json["id"]+'" class="note-loader"> '+json["note_title"]+' </a></li>')
                            .hide()
                            .prependTo('#note-list')
                            .slideDown();

                        // if it is public add it to public note list
                        if (json.is_public) {
                            var $newElem = ' \
                                <div class="panel panel-default"> \
                                    <div class="panel-heading public-note-head"> \
                                        ' + json.note_title +' \
                                        <i class="glyphicon glyphicon-chevron-down pull-right"></i> \
                                    </div> \
                                    <div class="panel-body public-note-body"> \
                                        <pre>' + json.note_body + '</pre> \
                                    </div> \
                                </div> \
                            ';
                            $($newElem).prependTo('.public-note-container');
                            $('.public-note-body').hide();
                        }


                        // disable form
                        $('#note-form input[name = "noteTitle"]').prop('disabled', true);
                        $('#note-form textarea[name = "noteBody"]').prop('disabled', true);
                        $('#note-form input[name = "noteTags"]').prop('disabled', true);
                        $('#note-form input[name = "isPublic"]').prop('disabled', true);

                        // get the note id and insert into form, allows user to edit
                        $('#note-form input[name="noteID"]').val(json['id']);
                        $('#new-note-save').hide();
                        $('#note-save').show();
                    }
                });
            });

            // form delete
            $('#delete-button').click(function () {
                // if they choose to delete the note
                if(confirm('Are you sure you want to permanently delete this note?')){
                    //delete the note
                    var noteID = $('#noteID').val();

                    var url = decodeURI("{{ URL::route('note.delete') }}");
                    var $this = $(this);

                    // now insert the note ID
                    url = url.replace('{id}', noteID);

                    // console.log(url);
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(id) {
                            console.log('success');


                            // remove from note-list
                            $('a[data-id = "' + id + '"]').parent().slideUp(500, function() {
                                $(this).remove();
                            });

                            // // hide this button
                            $this.hide();

                            // //show the edit button
                            $('#edit-button').show();

                            // show blank, disabled note form
                            $('#note-form input[name = "noteTitle"]').val('').prop('disabled', true);
                            $('#note-form textarea[name = "noteBody"]').val('').prop('disabled', true);
                            $('#note-form input[name = "noteTags"]').val('').prop('disabled', true);
                            $('#note-form input[name = "isPublic"]').prop('checked', false).prop('disabled', true);

                            $('#new-note-save').hide();
                            $('#note-save').show();
                            $('#edit-button').hide();
                            $('#note-heading').text('Select Note');
                        }
                    });
                }
            });

            // note search
            $('#note-search-button').click(function(e) {
                e.preventDefault();

                var url = decodeURI("{{ URL::route('note.search') }}");
                var $this = $(this);

                var moduleID = {{$module->id}};
                url = url.replace('{id}', moduleID);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        note_tags: $('#note-search').val()
                    },
                    datatype: 'json',

                    //console.log(data);
                    success: function (json) {

                        // clear list ready to add new items
                        $("#note-search-results").empty();
                        $('#note-search-results').show();

                        
                        $.each(json, function(){
                            $('<li class="list-group-item"><a href="#" data-id="'+this["id"]+'" class="note-loader"> '+this["note_title"]+' </a></li>')
                                .prependTo('#note-search-results');
                        });
                        $('<br />').prependTo('#note-search-results');
                    }
                });
            });

            // expands note to show body
            $('.public-note-container').on('click', '.public-note-head', function() {
                $('.public-note-body').slideUp(400);

                var isHidden = $(this).siblings().is( ":hidden" );
                if (isHidden) {
                    $(this).siblings().slideToggle( "slow", function() {

                    });
                }
                $(this).children('.public-note-icon').toggleClass("glyphicon glyphicon-chevron-down glyphicon glyphicon-chevron-up");
            });
            
            // Used to display PDF in modal
            $('#material-list').on('click', '#preview-link', function() {
                $('#preview-frame').attr('src', $(this).data('src'));
            });
        });
    </script>
@stop