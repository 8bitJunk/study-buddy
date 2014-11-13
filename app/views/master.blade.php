<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/plugins/multiselect.js/css/multi-select.css">
        <title> @yield('title') - Study Buddy </title>

        {{ HTML::script('js/jquery.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}

    </head>
    <body>
        <div class="row">
            <div class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header col-sm-12">
                        <a class="navbar-brand" href="/home">Study Buddy</a>
                        <div class="btn-group user-button pull-right">
                            <button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-user"></i> {{{ Auth::user()->name }}}</button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span> 
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>{{ HTML::linkRoute('viewProfile', 'View Profile', ['id' => Auth::user()->id]) }}</li>
                                @if(Auth::user()->user_level == 'ADMIN')
                                    <li>{{ HTML::linkRoute('viewAdmin', 'Admin Page') }}</li>
                                @endif
                                <li class="divider"></li>
                                <li>{{ HTML::linkRoute('doLogout', 'Logout') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Fixed Navbar -->
        <div class="container content">
            @yield('content')
        </div>
    {{ HTML::script('js/google-analytics.js'); }}
    </body>
    @yield('javascript')
</html>