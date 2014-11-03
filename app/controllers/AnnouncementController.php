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
		$date = new \DateTime; // used to manually update created_at

       $announcementData = Input::only(
           'module_id',
           'announcement_body',
           'user_id'
       );

       $validator = Validator::make($announcementData, [
           'announcement_body' => 'required',
           'module_id' => 'required',
           'user_id' => 'required'
       ]);

       if ($validator->fails()) {
           return Response::json($validator->messages(), 400);
       }
       else {
           $announcement = Announcement::create($announcementData);
           return $announcement;
       }
	}

	public function delete($id) {
	    $announcement = Announcement::destroy($id);
	    return $id;
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
