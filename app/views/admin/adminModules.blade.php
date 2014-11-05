<div class="row">
    <div class="col-sm-12">
        <h2>Add Module</h2>
        {{ Form::open(array('method' => 'POST', 'action' => 'ModuleController@store', 'id' => 'admin-module-form')) }}
            {{ Form::input('text', 'module_name', '', ['class'=>'form-control', 'placeholder' => 'Name', 'required']) }} <br>
            {{ Form::textarea('module_description', '', ['class'=>'form-control', 'rows' => '8', 'placeholder' => 'Description', 'required']) }} <br>
            {{ Form::select('module_course', ($courses), '', ['class' => 'form-control', 'id' => 'module_course', 'required']) }} <br>
            {{ Form::submit('Add', array('class' => 'btn btn-primary btn-large btn-block', 'id' => 'admin-module-add')) }}
        {{ Form::close() }}
    </div>
</div>