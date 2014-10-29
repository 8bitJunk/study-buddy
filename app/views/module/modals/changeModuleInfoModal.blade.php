<!-- Button trigger modal -->
<button class="btn btn-primary" data-toggle="modal" data-target="#moduleDescriptionModal">
    <i class="glyphicon glyphicon-edit"></i>
    Edit
</button>
<br>

<!-- Modal -->
<div class="modal fade" id="moduleDescriptionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Change Module Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        {{ Form::open(['url' => 'module/'.$module->id.'/update']) }}

                            <div class="row">
                                <div class="input-group input-group">
                                    <span class="input-group-addon">Title:</span>
                                    {{ Form::text('moduleName', $module->module_name, ['class' => 'form-control'] ) }}
                                </div>

                                <br />
                                {{ Form::Textarea('moduleDescription', $module->module_description, ['class' => 'form-control', 'rows' => '10'] )}}
                                <br />
                                <span class="pull-right">
                                    <button class="btn btn-primary" type="submit">Save</button>
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