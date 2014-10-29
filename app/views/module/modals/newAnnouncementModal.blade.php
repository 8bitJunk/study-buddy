<!-- Button trigger modal -->
<button class="btn btn-primary" data-toggle="modal" data-target="#newAnnouncementModal">
    <i class="glyphicon glyphicon-plus"></i>
    Create New
</button>
<br>

<!-- Modal -->
<div class="modal fade" id="newAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create New Announcement</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        {{ Form::open(['url' => 'module/'.$module->id.'/announcement/new/']) }}

                            <div class="row">
                                {{ Form::Textarea('announcement', '', ['class' => 'form-control', 'rows' => '2', 'placeholder' => 'Announcement', 'id' => 'announcement'] )}}
                                {{ Form::hidden('moduleID', $module->id, ['id' => 'moduleID']) }}
                                <br />
                                <span class="pull-right">
                                    <button class="btn btn-primary" type="submit" id="announcement-submit">Save</button>
                                    <button class="btn btn-default" type="submit" data-dismiss="modal">Cancel</button>
                                </span>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>