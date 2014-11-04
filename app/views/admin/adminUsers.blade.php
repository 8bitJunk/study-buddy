<div class="row">
    <div class="alert alert-success alert-dismissible" id="success-message" role="alert">
      <button type="button" class="close" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <strong>Success:</strong> New user created
    </div>
    <div class="col-sm-6">
    <h2>Add User</h2>
        {{ Form::open(array('method' => 'POST', 'action' => 'UserController@store', 'id' => 'admin-user-form')) }}
            {{ Form::input('text', 'name', '', ['class'=>'form-control', 'placeholder' => 'Name', 'required']) }} <br>
            {{ Form::input('text', 'surname', '', ['class'=>'form-control', 'placeholder' => 'Surname', 'required']) }} <br>
            {{ Form::input('text', 'email', '', ['class'=>'form-control', 'placeholder' => 'Email', 'required']) }} <br>
            {{ Form::input('password', 'password', '', ['class'=>'form-control', 'placeholder' => 'Password', 'required']) }} <br>
            {{ Form::select('user_level', ['STUDENT'=>'STUDENT', 'TEACHER'=>'TEACHER', 'ADMIN'=>'ADMIN'], null, ['class'=>'form-control', 'id'=>'user_level', 'required']) }} <br>
    </div>
    <div class="col-sm-6" id="module-selector">
        <h4>Select Modules for User</h4>
        <select id="keep-order" multiple="multiple" name="user_modules">
            @foreach($modules as $module)
                <option data-id="{{ $module->id }}">{{ $module->module_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-12">
            {{ Form::submit('Add', array('class' => 'btn btn-primary btn-large btn-block', 'id' => 'admin-user-add')) }}
        {{ Form::close() }}
    </div>
</div>