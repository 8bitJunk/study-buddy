<?php

class ModuleController extends \BaseController {

	// shows the view for an individual module
	public function showModule($id) {

		$module = Module::find($id);
        $teachersInformation = $module->users()->whereUserLevel("TEACHER")->get();

        $recentMaterials = $module->materials()->orderBy('created_at', 'desc')->get();
        
        $publicNotes = $notes = Note::where('is_public', '=', true)
                        ->where('module_id', '=', $id)
                        ->orderBy('updated_at', 'DESC')
                        ->get();

        return View::make('module/module', compact('module', 'teachersInformation', 'recentMaterials', 'publicNotes'));
	}

    public function index() {
        $user = Auth::user();

        return View::make('module/moduleIndex', compact('user'));
    }

    public function  uploadMaterial() {
        $destinationPath = '';
        $filename        = '';
        $date = new \DateTime; // used to manually update created_at

        if (Input::hasFile('file')) {
            $file               = Input::file('file');
            $destinationPath    = '/module_materials/' . Input::get('moduleName') . '/' . Input::get('folder');
            $filename           = $file->getClientOriginalName();
            $uploadSuccess      = $file->move(public_path() . $destinationPath, $filename);
            $module_id          = Input::get('moduleID');
            $uploader_id        = Input::get('uploaderID');
            $description        = Input::get('description');

        }

        $id = DB::table('module_materials')->insertGetId([
            'module_id'     => $module_id,
            'material_path' => $destinationPath,
            'material_name' => $filename,
            'uploader_id'   => $uploader_id,
            'description'   => $description,
            'created_at' => $date
        ]);

        return Redirect::route('module', ['id'=>$module_id])
            ->with('success', 'Material successfully uploaded.');
    }

    public function update($id) {
        if($module  = Module::find($id)){
            $moduleData = [
                'module_name' => Input::get('moduleName'),
                'module_description' => Input::get('moduleDescription')
            ];

            $module->module_name = $moduleData['module_name'];
            $module->module_description = $moduleData['module_description'];

            $module->save();

            return Redirect::route('module', ['id'=>$id])
                ->with('success', 'Module successfully updated.');
        }
    }
}