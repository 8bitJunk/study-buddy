<?php

class AnnouncementController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return Announcement::all();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$date = new \DateTime; // used to manually update created_at
		$moduleID = Input::get('moduleID');

		$id = DB::table('announcements')->insertGetId([
			'user_id'     => Auth::user()->id,
		    'module_id' => $moduleID,
		    'announcement_body' => Input::get('announcement'),
			'created_at' => $date,
		]);

		return Redirect::route('module', [$moduleID])
		    ->with('success', 'Announcement successfully created.');
	}

	public function delete($id, $announcementID) {

	    $note = Announcement::destroy($announcementID);

	    return Redirect::route('module', ['id'=>$id])
	        ->with('success', 'Announcement successfully deleted.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
