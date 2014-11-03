<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



// display login page
Route::get('/', [
    'as' => 'login',
    function() {
       return View::make('login');
}]);

// logs the user in
Route::post('login',  [
    'as' => 'doLogin',
    'uses' => 'UserController@login'
]);

Route::group(['before' => 'auth'], function() {
    // homepage for the user
    Route::get('/home', [
        'as' => 'home',
        'uses' => 'HomeController@showHome'
    ]);


    // logs the user out
    Route::get('logout', [
        'as' => 'doLogout',
        'uses' => 'UserController@logout'
    ]);

    // display an individual module
    Route::get('module/{id}',  [
        'as' => 'module',
        'uses' => 'ModuleController@showModule'
    ]);

    // lists all of the users modules
    Route::get('modules/index',  [
        'as' => 'moduleIndex',
        'uses' => 'ModuleController@index'
    ]);

    // update the module title and description (teacher only)
    Route::post('module/{id}/update', [
        'as' => 'moduleUpdate',
        'uses' => 'ModuleController@update'
    ]);

    // upload material for that module (teacher only)
    Route::post('module/{id}/uploadMaterial',[
        'as' => 'uploadMaterial',
        'uses' => 'ModuleController@uploadMaterial'
    ]);

    // show all user notes for that module
    Route::get('module/{id}/notes',  [
        'as' => 'moduleNotes',
        'uses' => 'NoteController@getAllModuleNotes'
    ]);

    Route::post('module/{id}/note/new/store', [
        'as' => 'note.store',
        'uses' => 'NoteController@store'
    ]);

    Route::post('user/new', [
        'as' => 'user.store',
        'uses' => 'UserController@store'
    ]);

    Route::post('course/new', [
        'as' => 'course.store',
        'uses' => 'CourseController@store'
    ]);

    // update an existing note
    Route::post('note/{id}/update', [
        'as' => 'note.update',
        'uses' => 'NoteController@update'
    ]);

    // delete current note
    Route::delete('note/{id}/delete', [
        'as' => 'note.delete',
        'uses' => 'NoteController@delete'
    ]);

    // return an indiviual note (ajax)
    Route::get('note/{id}/json', [
        'as' => 'note.json',
        'uses' => 'NoteController@json'
    ]);

    Route::post('module/{id}/notes/search', [
        'as' => 'note.search',
        'uses' => 'NoteController@search'
    ]);

    // view a user's profile
    Route::get('/user/{id}/profile',  [
        'as' => 'viewProfile',
        'uses' => 'UserController@getProfile'
    ]);

    Route::get('/admin',  [
        'as' => 'viewAdmin',
        'uses' => 'UserController@showAdmin'
    ]);


    Route::get('materials/{id}', function ($id) {
        return Response::download( Material::find($id)->url );
    });

    Route::post('module/{id}/announcement/new', [
        'as' => 'newModuleAnnouncement',
        'uses' => 'AnnouncementController@store'
    ]);

    Route::post('module/{id}/announcement/{announcementID}/delete', [
        'as' => 'deleteAnnouncement',
        'uses' => 'AnnouncementController@delete'
    ]);

});

Route::resource('notes', 'NoteController');