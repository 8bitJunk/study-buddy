@extends('master')

@section('title')
    Admin
@stop

@section('content')

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
<div class="row">
    <div class="col-sm-2">
        <h2 class="hidden-xs"><br /></h2>
        <ul class="nav nav-pills nav-stacked global-menu">
            <li> {{ HTML::linkRoute('home', 'Home') }}</li>
            <li> {{ HTML::linkRoute('moduleIndex', 'Your Modules') }}</li>
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
            // hide user creation success message on page load.
            $('#success-message').hide();

            // set up success alert to diaply later.
            $('#keep-order').multiSelect({ keepOrder: true });

            // adding a new user, ajax.
            $('#admin-user-add').click(function(e) {
                e.preventDefault();

                // get all selected module id's and add them to the array
                var userModules = [];
                $(".ms-selection").find(".ms-selected").each(function(){
                    userModules.push(($(this).data('id')));
                });

                $.ajax({
                    type: "POST",
                    url: decodeURI("{{ URL::route('user.store') }}"),
                    data: {
                        name: $('#admin-user-form input[name = "name"]').val(), 
                        surname: $('#admin-user-form input[name = "surname"]').val(),
                        email: $('#admin-user-form input[name = "email"]').val(),
                        password: $('#admin-user-form input[name = "password"]').val(),
                        user_level: $('#user_level option:selected').val(),
                        user_modules: userModules
                    },

                    success: function(json) {
                        // clear form upon successful creation of new user.
                        $('#admin-user-form input').val("");
                        $('#user_level option[value="STUDENT"]').prop('selected', true);
                        $('#keep-order').multiSelect('deselect_all');
                        $('#keep-order').multiSelect('refresh');

                        // display success message.
                        $('#success-message').show();
                    }
                });
            });

            // hide the success alert when user clicks close button.
            $('.alert .close').on('click', function(e) {
                $(this).parent().hide();
            });

        });
    </script>
@stop