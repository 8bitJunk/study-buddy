<!-- Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Upload File</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        {{ Form::open(['url' => 'module/'.$module->id.'/uploadMaterial', 'files' => true]) }}
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <div class="btn btn-primary btn-file">
                                        Browse <input type="file" name="file" multiple required>
                                    </div>
                                </div>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <br>
                            {{-- Form::text('folder', '', [
                                'class' => 'form-control',
                                'placeholder' => 'Folder Name',
                                'disabled' => 'true'
                            ]) --}}
                            <!-- <br> -->
                            {{ Form::textarea('description', '', [
                                'class' => 'form-control',
                                'rows' => '2',
                                'placeholder' => 'Description (optional)'
                            ] ) }}

                            {{ Form::hidden('moduleName', $module->module_name )}}
                            {{ Form::hidden('moduleID', $module->id )}}
                            {{ Form::hidden('uploaderID', Auth::user()->id )}}
                            <br>
                            <span class="pull-right">
                                <button class="btn btn-primary" type="submit">Upload</button>
                                <button class="btn btn-default" type="submit" data-dismiss="modal">Cancel</button>
                            </span>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Used to display the file name in the input box.
    $(document).on('change', '.btn-file :file', function() {
      var input = $(this),
          numFiles = input.get(0).files ? input.get(0).files.length : 1,
          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
    });
</script>