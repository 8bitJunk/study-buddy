<div class="row">
    <div class="col-sm-12">
        <h2>Announcements
            <span class="pull-right">
                @if(Auth::user()->user_level == "TEACHER")
                    @include('module.modals.newAnnouncementModal')
                @endif
            </span>
        </h2>
        <ul class="list-group" id="announcement-list">
            @foreach($module->announcements->reverse() as $announcement)
                <li class="list-group-item announcement-container">
                    <div class="list-group-heading">
                        <strong>{{{ Module::find($announcement->module_id)->module_name }}}</strong>
                         - {{{$announcement->created_at->diffForHumans()}}} 
                        @if(Auth::user()->user_level == "TEACHER")
                            <span class="pull-right">
                                <button class="btn btn-danger announcement-delete" data-id="{{$announcement->id}}"> Delete </button>
                            </span>
                        @endif
                    </div>
                    <p class="list-group-item-text">{{{ $announcement->announcement_body }}}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>