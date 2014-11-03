<div class="row">
    <div class="col-sm-12">
            <h2>Add User</h2>
            {{ Form::open(array('method' => 'POST', 'action' => 'UserController@store', 'id' => 'admin-user-form')) }}
                {{ Form::input('text', 'name', '', ['class'=>'form-control', 'placeholder' => 'Name', 'required']) }} <br>
                {{ Form::input('text', 'surname', '', ['class'=>'form-control', 'placeholder' => 'Surname', 'required']) }} <br>
                {{ Form::input('text', 'email', '', ['class'=>'form-control', 'placeholder' => 'Email', 'required']) }} <br>
                {{ Form::input('password', 'password', '', ['class'=>'form-control', 'placeholder' => 'Password', 'required']) }} <br>
                {{ Form::select('user_level', ['STUDENT'=>'STUDENT', 'TEACHER'=>'TEACHER', 'ADMIN'=>'ADMIN'], null, ['class'=>'form-control', 'required']) }} <br>
                {{ Form::submit('Add', array('class' => 'btn btn-primary btn-large btn-block', 'id' => 'admin-user-add')) }}
            {{ Form::close() }}
        <br />
    </div>
</div>