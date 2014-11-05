<?php

class ModuleController extends \BaseController {

	// shows the view for an individual module
	public function showModule($id) {

		$module = Module::find($id);
        $teachersInformation = $module->users()->whereUserLevel("TEACHER")->get();

        $moduleMaterials = $module->materials()->orderBy('created_at', 'desc')->get();
        
        $publicNotes = Note::where('is_public', '=', true)
                        ->where('module_id', '=', $id)
                        ->orderBy('updated_at', 'DESC')
                        ->get();

        return View::make('module/module', compact('module', 'teachersInformation', 'moduleMaterials', 'publicNotes'));
	}

    public function index() {
        $user = Auth::user();

        return View::make('module/moduleIndex', compact('user'));
    }

    public function store() {
        $moduleData = Input::only(
            'module_name',
            'module_description'
        );

        $course_module = Input::only(
            'module_course'
        );

        //$moduleData = array_map("htmlentities", $moduleData);

        $validator = Validator::make($moduleData, [
            'module_name' => 'required',
            'module_description' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
                ], 400);
        } else {
            $module = Module::create($moduleData);
            DB::table('course_module')->insert([
                'course_id' => $course_module['module_course'],
                'module_id' => $module->id
            ]);

            return $module;
        }
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