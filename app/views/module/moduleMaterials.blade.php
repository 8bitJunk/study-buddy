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
            @foreach($recentMaterials as $recentMaterial)
                <li class="list-group-item">
                    <?php $filetype = explode(".", $recentMaterial->material_name); ?>
                    @if ($filetype[1] == 'pdf')
                        <span class='pull-right' id='preview-link' data-src="{{ $recentMaterial->material_path.$recentMaterial->material_name }}">
                            <a href="#" data-toggle="modal" data-target="#previewMaterialModal">
                                <i class="glyphicon glyphicon-eye-open"></i>
                                Preview
                            </a>
                        </span>
                    @endif
                    <a download href="{{$recentMaterial->material_path.$recentMaterial->material_name}}">{{ $recentMaterial->material_name }} <span class="pull-right"><i class="glyphicon glyphicon-download-alt"></i> Download</span></a>
                </li>
            @endforeach
        </ul>
    </div>
</div>