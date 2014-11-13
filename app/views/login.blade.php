<html>
    <head>
        <title>login</title>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <div class="row">
            <div class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header col-sm-12">
                        <div class="navbar-brand">
                            Study Buddy
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Fixed Navbar -->

        <div class="container content">
            @if(Session::has('flash_error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Error!</strong> {{ Session::get('flash_error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                    {{ Form::open( [
                                'class' => 'form-signin',
                                'action' => ['UserController@login'],
                                'role' => 'form'
                            ]
                        ) 
                    }}

                        <h2 class="form-signin-heading text-center">Please sign in</h2>

                        <br />

                        <div class="input-group">
                            {{ Form::email('email', '', [
                                    'placeholder' => 'Email Address', 
                                    'class' => 'form-control', 
                                    'autofocus' => 'true'
                                ]
                            ); }}
                            <span class="input-group-addon"><i id="email-icon" class="glyphicon glyphicon-asterisk"></i></span>
                        </div>

                         <div class="input-group">
                            {{ Form::password('password', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Password'
                                ]
                            ) }}
                            <span class="input-group-addon"><i id="pass-icon" class="glyphicon glyphicon-asterisk"></i></span>
                        </div>

                        <br />

                        {{ Form::submit('Sign in', [
                                'class' => 'btn btn-lg btn-primary btn-block',
                                'disabled' => 'true'
                            ]
                        ) }}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    {{ HTML::script('js/google-analytics.js'); }}
    </body>
    {{ HTML::script('js/jquery.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/docs.js') }}

    <script>
        $(document).ready(function() {
            var pass = false;
            var email = false;

            function allowSubmit() {
                if(email && pass) {
                    $('input[type="submit"]').removeAttr('disabled');
                } else {
                    $('input[type="submit"]').prop('disabled', true);
                }
            }


            $("input[name='email']").on('propertychange keyup input paste', function(){
                var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!(reg.test($(this).val()))) {
                    email = false;
                    $(this).addClass('error');
                    $("#email-icon").removeClass("glyphicon glyphicon-ok");
                    $("#email-icon").addClass("glyphicon glyphicon-remove");
                    allowSubmit();
                } else {
                    email = true;
                    $(this).removeClass("error");
                    $("#email-icon").removeClass("glyphicon glyphicon-remove");
                    $("#email-icon").addClass("glyphicon glyphicon-ok");
                    allowSubmit();
                }
            });

            $("input[name='password']").on('propertychange keyup input paste', function(){
                if($(this).val().length < 5) {
                    pass = false;
                    $(this).addClass('error');
                    $("#pass-icon").removeClass("glyphicon glyphicon-ok");
                    $("#pass-icon").addClass("glyphicon glyphicon-remove");
                    allowSubmit();
                } else {
                    pass = true;
                    $(this).removeClass("error");
                    $("#pass-icon").removeClass("glyphicon glyphicon-remove");
                    $("#pass-icon").addClass("glyphicon glyphicon-ok");
                    allowSubmit();
                }
            });
        });
    </script>
</html>


