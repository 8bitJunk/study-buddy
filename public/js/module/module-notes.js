$(function() {
    // hides the delete button on the note edit form because chris said to.
    $('#delete-button').hide();
    $('#new-note-save').hide();
    $('#edit-button').hide();

    window.routeLink = "{{{ URL::route('note.json') }}}";

    // ajax for notes
    $('#note-list').on('click', '.note-loader', function(e) {
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

            // disable fields
            $('#note-form input[name = "noteTitle"]').prop('disabled', true);
            $('#note-form textarea[name = "noteBody"]').prop('disabled', true);
            $('#note-form input[name = "noteTags"]').prop('disabled', true);
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
                note_tags: $('#noteTags').val()
            },

            //console.log(data);
            success: function (json) {
                // update the parent form elements based on the json

                // then make the form uneditable
                $this
                    .parents('form')
                    .find(':input')
                    .attr('disabled', true);

                // update note list title
                $('a[data-id = "' + json['id'] + '"]').text(json['note_title']);

                // change delete button for edit button
                $('#edit-button').show();
                $('#delete-button').hide();
                $('#note-heading').text('Edit Note');
            }
        });
    });

    $('#edit-button').click(function () {
        $('#note-form input[name = "noteTitle"]').removeAttr('disabled').focus();
        $('#note-form textarea[name = "noteBody"]').removeAttr('disabled');
        $('#note-form input[name = "noteTags"]').removeAttr('disabled');
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
                module_id: moduleID,
                is_public: 0,
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

                    // disable form
                    $('#note-form input[name = "noteTitle"]').prop('disabled', true);
                    $('#note-form textarea[name = "noteBody"]').prop('disabled', true);
                    $('#note-form input[name = "noteTags"]').prop('disabled', true);
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

            console.log(url);
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
                $("#note-search-display").empty();
                $('#note-search-display').show().append('<br/>');

                
                $.each(json, function(){
                    $('<li class="list-group-item"><a href="#" data-id="'+this["id"]+'" class="note-loader"> '+this["note_title"]+' </a></li>')
                        .prependTo('#note-search-display');
                });
            }
        });
    });
});