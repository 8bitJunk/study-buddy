<?php

class UserController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return User::all();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        echo "Create new User";
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // return null if none is found
        return User::find($id);

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

    public function login() {
        $userData = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];

        $validator = Validator::make($userData, 
            [
                'email' => 'required|email',
                'password' => 'required|alphanum|min:5',
            ]
        );

        if ($validator->fails()) {
            return Redirect::route('login')
                ->with(Response::json($validator->messages(), 400));

        } else {
            if(Auth::attempt($userData)) {
                return Redirect::route('home');
            } else {
                return Redirect::route('login')
                    ->with('flash_error', 'Your username/password combination has been rejected.');
            }
        }
    }

    public function logout() {
        Auth::logout();
        return Redirect::route('login');
    }

    public function getProfile($id) {

        $user = User::find($id);

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'level' => $user->user_level
        ];

        return View::make('viewProfile', compact('userData'));
    }
}