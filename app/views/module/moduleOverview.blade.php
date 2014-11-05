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
                    <i class="glyphicon glyphicon-user"></i> {{ HTML::linkRoute('viewProfile', 
                        $teacherInformation->name . " " . $teacherInformation->surname ,
                        [$teacherInformation->id]) }}
                    <br>
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

                // setup url
                var noteID = $(this).data('id');
                var url = decodeURI("{{ URL::route('note.json') }}");
                url = url.replace('{id}', noteID);

                $this = $(this);

                $.get(url, function(json) {
                    // set fileds of the form
                    $('#noteTitle').val(json.note_title);
                    $('#noteBody').val(json.note_body);
                    $('#noteTags').val(json.note_tags);
                    $('#noteID').val(json.id);
                    if (json.is_public == 1) {
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

            // save edited notes
            $('#note-save').click(function(e){
                e.preventDefault();

                // setup url
                var noteID = $('#noteID').val();
                var url = decodeURI("{{ URL::route('note.update') }}");
                url = url.replace('{id}', noteID);

                var $this = $(this);

                var wasPublic = $('#isPublic').is(':checked') ? 1 : 0;

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        note_title: $('#noteTitle').val(), 
                        note_body: $('#noteBody').val(),
                        note_tags: $('#noteTags').val(),
                        is_public: wasPublic
                    },

                    success: function (json) {
                        // update note list title
                        $('a[data-id = "' + json['id'] + '"]').text(json['note_title']);

                        // make the form uneditable
                        $this
                            .parents('form')
                            .find(':input')
                            .attr('disabled', true);

                        // change delete button for edit button
                        $('#edit-button').show();
                        $('#delete-button').hide();
                        $('#note-heading').text('Edit Note');

                        if (json.is_public == 0) {
                            // not public so remove
                            $('div[data-id = "' + json['id'] + '"]').remove();
                        }
                    }
                });
            });

            // check server for public notes every 30 seconds
            setInterval(function() {
                var moduleID = {{ $module->id }};
                var url = decodeURI("{{ URL::route('note.public.recent') }}");
                url = url.replace('{id}', moduleID);

                $.ajax({
                    type: "GET",
                    url: url,

                    success: function (json) {
                        $.each(json, function(index, val) {
                            //remove all of the ones here
                            $('div[data-id = "' + json[index]['id'] + '"]').remove();

                            // re-add public ones
                            if(json[index]['is_public']) {
                                var $newElem = ' \
                                    <div class="panel panel-default individual-public-note-container" data-id="'+json[index]["id"]+'"> \
                                        <div class="panel-heading public-note-head"> \
                                            <span class="public-note-title">'+json[index]["note_title"]+'</span> \
                                            <span class="pull-right "> \
                                                <span class="public-notes-created-time">'+json[index]["diffForHumans"]+'</span> \
                                                <i class="glyphicon glyphicon-chevron-down public-note-icon"></i> \
                                            </span> \
                                        </div> \
                                        <div class="panel-body public-note-body"> \
                                            <pre>'+json[index]["note_body"]+'</pre> \
                                        </div> \
                                    </div> \
                                ';
                                $($newElem).prependTo('.public-note-container');
                            }
                        });
                    $('.public-note-body').hide();
                    }
                });
            }, 1e3 * 30);

            // used to edit the selected note
            $('#edit-button').click(function () {
                // remove disabled from all fields
                $('#note-form input[name = "noteTitle"]').removeAttr('disabled').focus();
                $('#note-form textarea[name = "noteBody"]').removeAttr('disabled');
                $('#note-form input[name = "noteTags"]').removeAttr('disabled');
                $('#note-form input[name = "isPublic"]').removeAttr('disabled');
                $('#note-save').removeAttr('disabled');

                // show the delete button and hide this button
                $(this).hide();
                $('#delete-button').show();
                $('#note-heading').text('Edit Note');
            });

            // create a new note
            $('#create-new-button').click(function () {
                // enable form and clear it.
                $('#note-form input[name = "noteTitle"]').removeAttr('disabled').focus().val('');
                $('#note-form textarea[name = "noteBody"]').removeAttr('disabled').val('');
                $('#note-form input[name = "noteTags"]').removeAttr('disabled').val('');
                $('#note-form input[name = "isPublic"]').removeAttr('disabled').prop('checked', false);

                // show correct save button
                $('#note-save').hide();
                $('#new-note-save').show();
                $('#edit-button').hide();
                // change heading
                $('#note-heading').text('New Note');
            });

            // save a new note
            $('#new-note-save').click(function(e) {
                e.preventDefault();

                var $this = $(this);

                $.ajax({
                    type: "POST",
                    url: decodeURI("{{ URL::route('note.store') }}"),
                    data: {
                        note_title: $('#noteTitle').val(), 
                        note_body: $('#noteBody').val(),
                        note_tags: $('#noteTags').val(),
                        is_public: $('#isPublic').is(':checked') ? 1 : 0,
                        module_id: {{$module->id}},
                        user_id: {{Auth::user()->id}}
                    },

                    success: function (json) {
                        // make the form uneditable
                        $this
                            .parents('form')
                            .find(':input')
                            .attr('disabled', true);

                        // add new item to list
                        var $newLink = $('<li class="list-group-item"><a href="#" data-id="'+json["id"]+'" class="note-loader"> '+json["note_title"]+' </a></li>')
                            .hide()
                            .prependTo('#note-list')
                            .slideDown();

                        // show edit button
                        $('#edit-button').show();

                        // change title
                        $('#note-heading').text('Edit Note');

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

            // delete button above the form
            $('#delete-button').click(function () {
                // if they choose to delete the note
                if(confirm('Are you sure you want to permanently delete this note?')){
                    // setup url
                    var noteID = $('#noteID').val();
                    var url = decodeURI("{{ URL::route('note.delete') }}");
                    url = url.replace('{id}', noteID);

                    var $this = $(this);

                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(id) {
                            console.log('success');

                            // remove from note-list
                            $('a[data-id = "' + id + '"]').parent().slideUp(500, function() {
                                $(this).remove();
                            });

                            //hide this button
                            $this.hide();

                            //show the edit button
                            $('#edit-button').show();

                            // show blank, disabled note form
                            $('#note-form input[name = "noteTitle"]').val('').prop('disabled', true);
                            $('#note-form textarea[name = "noteBody"]').val('').prop('disabled', true);
                            $('#note-form input[name = "noteTags"]').val('').prop('disabled', true);
                            $('#note-form input[name = "isPublic"]').prop('checked', false).prop('disabled', true);

                            // hide/show correct buttons
                            $('#new-note-save').hide();
                            $('#note-save').show();
                            $('#edit-button').hide();
                            $('#note-heading').text('Select Note');

                            // remove from public notes
                            $('div[data-id = "' + id + '"]').remove();
                        }
                    });
                }
            });

            // note search
            $('#note-search-button').click(function(e) {
                e.preventDefault();

                var url = decodeURI("{{ URL::route('note.search') }}");
                url = url.replace('{id}', {{$module->id}});

                var $this = $(this);

                if($('#note-search').val() != "") {
                     $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            note_tags: $('#note-search').val()
                        },
                        datatype: 'json',

                        success: function (json) {
                            // clear list ready to add new items
                            $("#note-search-results").empty();

                            if(json.length > 0) {
                                //show empty list
                                $('#note-search-results').show();

                                // add notes to the list
                                $.each(json, function(){
                                    $('<li class="list-group-item"><a href="#" data-id="'+this["id"]+'" class="note-loader"> '+this["note_title"]+' </a></li>')
                                        .prependTo('#note-search-results');
                                });
                                $('<br />').prependTo('#note-search-results');
                            }
                        }
                    });
                }
            });

            // expands note to show body
            $('.public-note-container').on('click', '.public-note-head', function(e) {
                $('.public-note-head').each(function() {
                    var desiredVisible;
                    var isHidden = $(this).siblings().is( ":hidden" );

                    // removing || ($(this).has($(e.target)).size()>0) makes it kind of work better but less places to click
                    if ($(this).is(e.target) || ($(this).has($(e.target)).size()>0)) {
                        if (isHidden) {
                            showNote($(this));
                        } else {
                            hideNote($(this));
                        }
                    } else {
                        hideNote($(this));
                    }
                });
            });

            function hideNote(elem) {
                elem.siblings().slideUp(400, function() {
                    $('.public-note-icon').removeClass('glyphicon-chevron-up')
                        .addClass('glyphicon-chevron-down');
                }) ;
            }

            function showNote(elem) {
                elem.siblings().slideDown(400, function() {
                    $(elem).find('.public-note-icon').removeClass('glyphicon-chevron-down')
                        .addClass('glyphicon-chevron-up');
                });

            }

            // make ':contains' insensitive
            $.expr[":"].contains = $.expr.createPseudo(function(arg) {
                return function( elem ) {
                    return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
                };
            });

            //search public notes
            $('#public-note-search').on('propertychange keyup input paste', function() {
                var searchTerm = $(this).val();
                $('.individual-public-note-container').hide();

                // hide everything that does not contain the search term
                $('.public-note-title:contains("'+searchTerm+'")').parents().show();

                if (searchTerm == "") {
                    $('.individual-public-note-container').show();
                }
            });

            // ajaxing up the announcements
            $('#announcement-submit').click(function(e) {
                e.preventDefault();

                var url = decodeURI("{{ URL::route('announcement.new') }}");
                url = url.replace('{id}', {{$module->id}});

                var $this = $(this);

                if($('#announcement').val() != "") {
                     $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            module_id: {{$module->id}},
                            announcement_body: $('#announcement').val(),
                            user_id: {{ Auth::user()->id }}
                        },
                        datatype: 'json',

                        success: function (json) {
                            $('#newAnnouncementModal').modal('hide');

                            // create new element
                            var $newElem = ' \
                                <li class="list-group-item announcement-container"> \
                                    <div class="list-group-heading"> \
                                        <strong> {{{ $module->module_name }}} </strong> - now \
                                        @if(Auth::user()->user_level == "TEACHER") \
                                            <span class="pull-right"> \
                                                <button class="btn btn-danger announcement-delete" data-id="'+json["id"]+'"> Delete </button> \
                                            </span> \
                                        @endif \
                                    </div> \
                                    <p class="list-group-item-text">'+json["announcement_body"]+'</p> \
                                </li> \
                            ';

                            $($newElem).prependTo('#announcement-list');
                        }
                    });
                }
            });

            $('#announcement-list').on('click', '.announcement-delete',function(e) {
                e.preventDefault();
                // if they choose to delete the note
                if(confirm('Are you sure you want to permanently delete this announcement?')){
                    // setup url
                    var announcementID =  $(this).data('id');

                    var url = decodeURI("{{ URL::route('announcement.delete') }}");
                    url = url.replace('{id}', announcementID);

                    $this = $(this);

                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(id) {
                            $this.parentsUntil('#announcement-list').remove();
                        }
                    });
                }
            });
            
            // Used to display PDF in modal
            $('#material-list').on('click', '#preview-link', function() {
                $('#preview-frame').attr('src', $(this).data('src'));
            });

            $('#material-list').on('click', '.material-delete-button' ,function(e) {
                e.preventDefault();
                // if they choose to delete the note
                if(confirm('Are you sure you want to permanently delete this resource?')){
                    // setup url
                    var materialID =  $(this).data('id');

                    var url = decodeURI("{{ URL::route('material.delete') }}");
                    url = url.replace('{id}', materialID);

                    $this = $(this);

                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(id) {
                            $this.parentsUntil('#material-list').remove();
                        }
                    });
                }
            });
        });
    </script>
@stop