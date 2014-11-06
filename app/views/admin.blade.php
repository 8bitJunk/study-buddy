@extends('master')

@section('title')
    Admin
@stop

@section('content')

<!-- dynamically populated response message -->
<div class="alert alert-dismissible" id="response-message" role="alert">
  <button type="button" class="close" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong id="message-type"></strong><span id="message-text"></span>
</div>

<div class="row">
    <div class="col-sm-2">
        <h2 class="hidden-xs"><br /></h2>
        <ul class="nav nav-pills nav-stacked global-menu">
            <li> {{ HTML::linkRoute('home', 'Home') }}</li>
            <li> {{ HTML::linkRoute('module.index', 'Your Modules') }}</li>
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

@section('javascript')
    <script type="text/javascript" src="/plugins/multiselect.js/js/jquery.multi-select.js"></script>
    <script type="text/javascript">
        $(function() {
            // hide ajax response message on page load.
            $('#response-message').hide();

            // set up success alert to diaply later.
            $('#keep-order').multiSelect({ keepOrder: true });

            // hide the response message when user clicks close button.
            $('.alert .close').on('click', function(e) {
                $(this).parent().hide();
            });

            // function to show response message.
            function showMessage(colour, type, text){
                $('#response-message').removeClass();
                $('#response-message').addClass('alert alert-dismissible alert-'+ colour);
                $('#message-type').text(type + ': ');
                $('#message-text').html(text);
                $('#response-message').show();
            }

            // adding a new user, ajax.
            $('#admin-user-form').submit(function(e) {
                e.preventDefault();

                // get all selected module id's and add them to the array
                var userModules = [];
                $(".ms-selection").find(".ms-selected").each(function(){
                    userModules.push(($(this).data('id')));
                });

                $.ajax({
                    type: "POST",
                    datatype: "json",
                    url: decodeURI("{{ URL::route('user.store') }}"),
                    data: {
                        name: $.trim($('#admin-user-form input[name = "name"]').val()), 
                        surname: $.trim($('#admin-user-form input[name = "surname"]').val()),
                        email: $.trim($('#admin-user-form input[name = "email"]').val()),
                        password: $('#admin-user-form input[name = "password"]').val(),
                        user_level: $('#user_level option:selected').val(),
                        user_modules: userModules
                    },

                    success: function(json) {
                        // clear form upon successful creation of new user.
                        $('#admin-user-form input:not(#admin-user-add)').val("");
                        $('#user_level option[value="STUDENT"]').prop('selected', true);
                        $('#keep-order').multiSelect('deselect_all');
                        $('#keep-order').multiSelect('refresh');

                        // display success message.
                        var message = "New user <strong>" + json['name'] + "</strong> created."
                        showMessage('success', 'Success', message);
                    },

                    error: function(response) {
                        // display failure message.
                        // var json = response.responseJSON;
                        // console.log(json);
                        // var errorString;

                        // NEED TO FIX THIS LATER

                        // enumerate over the keys of the responseJSON
                        // for (var inputName in json){
                        //    for (var i=0; i < json[inputName].length; i++){
                        //         // add errors to a string
                        //         errorString += ("<strong>" + json[inputName] + "</strong>" + json[inputName][i] + ". ");
                        //     }

                        //     // set form to have error and show popover with errors
                        //     // next to relevant input field.
                        //     // $(thisForm).parent().addClass("has-error");
                        //     // $(thisForm).find("name[" + json[inputName] + "]").addClass(' \
                        //     //     data-container="body" \
                        //     //     data-toggle="popover" \
                        //     //     data-placement="left" \
                        //     //     data-content="' + popoverString + '"'
                        //     // );
                        // }

                        // show errors in message.
                        showMessage('danger', 'Error', response.responseText);
                    }
                });
            });
            
            // adding a new course, ajax.
            $('#admin-course-add').click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: decodeURI("{{ URL::route('course.store') }}"),
                    data: {
                        course_name: $.trim($('#admin-course-form input[name = "course_name"]').val()), 
                    },

                    success: function(json) {
                        // clear form upon successful creation of new course.
                        $('#admin-course-form input:not(#admin-course-add)').val("");
                        $('<option value="'+ json["id"] +'">'+ json["course_name"] +'</option>').appendTo('#module_course');

                        // display success message.
                        var message = "New course <strong>" + json['course_name'] + "</strong> created."
                        showMessage('success', 'Success', message);
                    },

                    error: function(response) {
                        // show errors in message.
                        showMessage('danger', 'Error', response.responseText);
                    }
                });
            });

            // adding a new module, ajax
            $('#admin-module-add').click(function(e) {
                e.preventDefault();

                console.log($('#module_course option:selected').val());

                $.ajax({
                    type: "POST",
                    url: decodeURI("{{ URL::route('module.store') }}"),
                    data: {
                        module_name: $.trim($('#admin-module-form input[name = "module_name"]').val()),
                        module_description: $('#admin-module-form textarea[name = "module_description"]').val(),
                        module_course: $('#module_course option:selected').val()
                    },

                    success: function(json) {
                        // clear form upon successful creation of new module.
                        $('#admin-module-form input[name = "module_name"]').val("");
                        $('#admin-module-form textarea[name = "module_description"]').val("");
                        $('<option data-id="'+json["id"]+'">'+json["module_name"]+'</option>').appendTo('#keep-order');
                        $('#keep-order').multiSelect('refresh');

                         // display success message.
                        var message = "New module <strong>" + json['module_name'] + "</strong> created."
                        showMessage('success', 'Success', message);
                    },

                    error: function(response) {
                        // show errors in message.
                        showMessage('danger', 'Error', response.responseText);
                    }
                });
            });

        });
    </script>
@stop