<div class="row">
    <div class="col-sm-12">
        <h2>Announcements
            <span class="pull-right">
                @if(Auth::user()->user_level == "TEACHER")
                    @include('module.modals.newAnnouncementModal')
                @endif
            </span>
        </h2>
        <ul class="list-group">
            @foreach($module->announcements as $announcement)
                <li class="list-group-item">
                    <div class="list-group-heading">
                        <strong>{{{ Module::find($announcement->module_id)->module_name }}} </strong>
                        @if(Auth::user()->user_level == "TEACHER")
                            <span class="pull-right">
                                {{ Form::open(['url' => 'module/'. $module->id .'/announcement/' . $announcement->id . '/delete']) }}
                                    {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Do you really want to permanently delete this announcement?")'])}}
                                {{ Form::close() }}
                            </span>
                        @endif
                    </div>
                    <p class="list-group-item-text">{{{ $announcement->announcement_body }}}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>