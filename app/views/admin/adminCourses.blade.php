<div class="row">
	<div class="col-sm-12">
	    <h2>Add Course</h2>
	    <div class="form-group">
		    {{ Form::open(array('method' => 'POST', 'action' => 'CourseController@store', 'id' => 'admin-course-form')) }}
		        {{ Form::input('text', 'course_name', '', ['class'=>'form-control', 'placeholder' => 'Name', 'required']) }} <br>
		        {{ Form::submit('Add', array('class' => 'btn btn-primary btn-large btn-block', 'id' => 'admin-course-add')) }}
		    {{ Form::close() }}
	   	</div>
	</div>
</div>