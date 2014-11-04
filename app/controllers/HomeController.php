<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showHome() {
		$user = Auth::user();

		$notes = Auth::user()->notes()
			->orderBy('created_at', 'desc')
			->take(5)
			->get();

		$announcements = $user->announcements()->take(3)->reverse();

        return View::make('home', compact('user', 'notes', 'announcements'));

	}

}
