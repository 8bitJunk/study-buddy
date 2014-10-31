@extends('master')

@section('title')
    {{ $userData['name'] }} {{ $userData['surname'] }}
@stop

@section('content')
<div class="row">
    <div class="col-sm-2">
        <h2 class="hidden-xs"><br /></h2>
        <ul class="nav nav-pills nav-stacked global-menu">
            <li>{{ HTML::linkRoute('home', 'Home') }}</li>
            <li> {{ HTML::linkRoute('moduleIndex', 'Your Modules') }}</li>
        </ul>
    </div>
    <div class="col-sm-4">
        <h2>Details</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-3">
                        <img class="profile-image" src="https://github.com/identicons/{{ $userData['name'] }}.png" alt="profile identicon">
                    </div>
                    <div class="col-sm-9">
                        <strong>Name:</strong> {{ $userData['name'] }} {{ $userData['surname'] }} <br />
                        <strong>Email:</strong> <a href="mailto:{{ $userData['email'] }}">{{ $userData['email'] }}</a> <br />
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <h2>Public Notes by {{ $userData['name'] }}
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
                        <span class="public-note-title">{{{$publicNote->note_title}}}</span>
                        <span class="pull-right ">
                            <span class="public-notes-created-time">last changed: {{$publicNote->updated_at->diffForHumans()}}</span>
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
@stop

@section('javascript')
    <script type="text/javascript">
        // public note collapse note body on load
        $('.public-note-body').hide();

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
    </script>
@stop