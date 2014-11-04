@include('module.modals.uploadMaterialModal')
@include('module.modals.previewMaterialModal')

<div class="row">
    <div class="col-sm-12">
        <h2>Uploaded Material
            <span class="pull-right">
                @if(Auth::user()->user_level == "TEACHER")
                    <button class="btn btn-primary" data-toggle="modal" data-target="#uploadFileModal">
                        <i class="glyphicon glyphicon-upload"></i>
                        Upload File
                    </button>
                    <br>
                @endif
            </span>
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <ul class="list-group" id="material-list">
            @foreach($moduleMaterials as $moduleMaterial)
                <li class="list-group-item">
                    <?php $filetype = explode(".", $moduleMaterial->material_name); ?>
                    @if(Auth::user()->user_level == "TEACHER")
                        <span class="pull-right">
                            <button class="btn btn-danger btn-xs material-delete-button" data-id="{{$moduleMaterial->id}}"> Delete </button>
                        </span>
                    @endif
                    <a download href="{{$moduleMaterial->material_path.$moduleMaterial->material_name}}">{{ $moduleMaterial->material_name }} <span class="pull-right" id="download-link"><i class="glyphicon glyphicon-download-alt"></i> Download</span></a>
                    @if ($filetype[1] == 'pdf')
                        <span class='pull-right' id='preview-link' data-src="{{ $moduleMaterial->material_path.$moduleMaterial->material_name }}">
                            <a href="#" data-toggle="modal" data-target="#previewMaterialModal">
                                <i class="glyphicon glyphicon-eye-open"></i>
                                Preview
                            </a>
                        </span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>